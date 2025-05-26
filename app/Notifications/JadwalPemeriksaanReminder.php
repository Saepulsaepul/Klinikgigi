<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\JadwalPemeriksaan;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class JadwalPemeriksaanReminder extends Notification implements ShouldQueue
{
    use Queueable;

    public $tries = 3;
    public $backoff = [60, 300];
    public $jadwal;

    public function __construct(JadwalPemeriksaan $jadwal)
    {
        $this->jadwal = $jadwal;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        try {
            // Validasi dasar
            if (!$this->jadwal) {
                throw new \Exception('Data jadwal tidak valid');
            }

            if (!$this->jadwal->patient) {
                throw new \Exception('Data pasien tidak ditemukan untuk jadwal ID: ' . $this->jadwal->id);
            }

            if (empty($notifiable->email)) {
                throw new \Exception('Email pasien tidak tersedia untuk pasien ID: ' . $this->jadwal->patient->id);
            }

            // Format waktu pemeriksaan
            $waktuPemeriksaan = $this->formatWaktuPemeriksaan();
            $jamPemeriksaan = $this->formatJam($this->jadwal->jam);
            $dokter = is_string($this->jadwal->dokter) ? $this->jadwal->dokter : ($this->jadwal->dokter->name ?? 'Belum ditentukan');

            // Buat konten email
            $mailMessage = (new MailMessage)
                ->subject('Pengingat Jadwal Pemeriksaan - 1 Jam Lagi')
                ->greeting('Halo ' . $notifiable->name . '!')
                ->line('Ini adalah pengingat bahwa Anda memiliki jadwal pemeriksaan:')
                ->line('Tanggal: ' . $this->jadwal->tanggal->format('d F Y'))
                ->line('Jam: ' . $jamPemeriksaan)
                ->line('Dokter: ' . $dokter)
                ->action('Lihat Detail', url('/jadwal'))
                ->line('Harap hadir 15 menit sebelum jadwal pemeriksaan.')
                ->line('Terima kasih telah menggunakan layanan kami!');

            return $mailMessage;

        } catch (\Exception $e) {
            Log::error('Gagal membuat email notifikasi: ' . $e->getMessage(), [
                'jadwal_id' => $this->jadwal->id ?? null,
                'patient_id' => $this->jadwal->patient->id ?? null,
                'exception' => $e
            ]);
            throw $e;
        }
    }

    /**
     * Format waktu pemeriksaan menjadi string yang lebih mudah dibaca
     */
    protected function formatWaktuPemeriksaan(): string
    {
        try {
            $tanggal = $this->jadwal->tanggal->format('Y-m-d');
            $jam = $this->extractTimeFromJamField();
            $waktu = Carbon::createFromFormat('Y-m-d H:i:s', "$tanggal $jam");
            return $waktu->format('d F Y H:i');
        } catch (\Exception $e) {
            Log::warning('Gagal memformat waktu pemeriksaan', [
                'tanggal' => $this->jadwal->tanggal,
                'jam' => $this->jadwal->jam,
                'error' => $e->getMessage()
            ]);
            return $this->jadwal->tanggal->format('d F Y') . ' ' . $this->extractTimeFromJamField();
        }
    }

    /**
     * Format jam menjadi HH:mm
     */
    protected function formatJam(string $jam): string
    {
        try {
            $timePart = $this->extractTimeFromJamField();
            return Carbon::createFromFormat('H:i:s', $timePart)->format('H:i');
        } catch (\Exception $e) {
            return $this->extractTimeFromJamField(); // Kembalikan format waktu saja
        }
    }

    /**
     * Ekstrak bagian waktu dari field jam (handle jika berisi datetime)
     */
    protected function extractTimeFromJamField(): string
    {
        // Jika format jam sudah H:i:s
        if (preg_match('/^\d{2}:\d{2}:\d{2}$/', $this->jadwal->jam)) {
            return $this->jadwal->jam;
        }
        
        // Jika format jam adalah datetime (2025-05-26 09:00:00)
        if (preg_match('/\d{2}:\d{2}:\d{2}$/', $this->jadwal->jam, $matches)) {
            return $matches[0];
        }
        
        // Default return
        return $this->jadwal->jam;
    }
}