<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\JadwalPemeriksaan;
use App\Notifications\JadwalPemeriksaanReminder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class KirimPengingatJadwal extends Command
{
    protected $signature = 'jadwal:ingatkan';
    protected $description = 'Mengirim pengingat email untuk jadwal pemeriksaan 1 jam sebelumnya';

    public function handle(): void
    {
        $now = Carbon::now();
        $satuJamLagi = $now->copy()->addHour();
        
        $this->info("Memeriksa jadwal antara: {$now->toDateTimeString()} - {$satuJamLagi->toDateTimeString()}");

        // Query untuk mencari jadwal yang tepat 1 jam lagi dari sekarang
        $jadwals = JadwalPemeriksaan::with(['patient'])
            ->where('status', 'terjadwal')
            ->whereDate('tanggal', $now->format('Y-m-d'))
            ->whereRaw("TIMEDIFF(CONCAT(tanggal, ' ', jam), ?) BETWEEN '00:59:00' AND '01:01:00'", [$now->format('Y-m-d H:i:s')])
            ->get();

        $this->info('Jumlah jadwal ditemukan: '.$jadwals->count());

        foreach ($jadwals as $jadwal) {
            try {
                if (!$jadwal->patient) {
                    $this->error('Pasien tidak ditemukan untuk jadwal ID: '.$jadwal->id);
                    continue;
                }

                if (empty($jadwal->patient->email)) {
                    $this->error('Email pasien kosong untuk pasien ID: '.$jadwal->patient->id);
                    continue;
                }

                $waktuPemeriksaan = Carbon::parse($jadwal->tanggal.' '.$jadwal->jam);
                $this->info("Memproses jadwal ID: {$jadwal->id} - {$waktuPemeriksaan->format('Y-m-d H:i:s')}");

                $jadwal->patient->notify(new JadwalPemeriksaanReminder($jadwal));
                
                $this->info('Notifikasi berhasil dikirim ke: ' . $jadwal->patient->email);
                
            } catch (\Exception $e) {
                $this->error('Gagal mengirim notifikasi: '.$e->getMessage());
                Log::error('Gagal mengirim notifikasi jadwal', [
                    'jadwal_id' => $jadwal->id,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
            }
        }
    }
}