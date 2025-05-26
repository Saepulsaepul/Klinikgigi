<?php

namespace App\Livewire\Main;

use App\Models\JadwalPemeriksaan;
use App\Models\Patient;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Carbon\Carbon;
use Livewire\Attributes\Title;

class BuatJadwal extends Component
{
    #[Layout('components.layouts.main')]
    #[Title('Buat Jadwal Pemeriksaan')]

    public $tanggal;
    public $jam;
    public $dokter;
    public $keterangan;
    public $status = 'terjadwal';

    public $listDokter = [
        'Dr. Ahmad',
        'Dr. Budi',
        'Dr. Citra'
    ];

    public function mount()
    {
        $this->tanggal = now()->format('Y-m-d');
    }

    public function submit()
    {
        // Validasi form input
        $this->validate([
            'tanggal' => 'required|date|after_or_equal:today',
            'jam' => 'required|date_format:H:i',
            'dokter' => 'required|string',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $user = Auth::user();

        // Hanya pasien yang bisa booking
        if ($user->role !== 'pasien') {
            session()->flash('error', 'Hanya pasien yang dapat melakukan booking.');
            return;
        }

        // Ambil atau buat data patient
        $patient = $user->patient;
        if (!$patient) {
            $patient = Patient::create([
                'user_id' => $user->id,
                'nama' => $user->name,
                'no_hp' => $user->phone ?? '-',
                'alamat' => $user->address ?? '-',
            ]);
        }

        // Cek apakah sudah ada booking pada jam dan tanggal yang sama
        $jadwalExists = JadwalPemeriksaan::where('tanggal', $this->tanggal)
            ->where('jam', $this->jam)
            ->where('dokter', $this->dokter)
            ->exists();

        if ($jadwalExists) {
            session()->flash('error', 'Jadwal pada tanggal dan jam tersebut sudah penuh.');
            return;
        }

        try {
            // Simpan ke database
            JadwalPemeriksaan::create([
                'patient_id' => $patient->id,
                'dokter' => $this->dokter,
                'tanggal' => $this->tanggal,
                'jam' => $this->jam,
                'status' => $this->status,
                'keterangan' => $this->keterangan,
            ]);

            session()->flash('success', 'Jadwal berhasil ditambahkan.');
            $this->reset(['tanggal', 'jam', 'dokter', 'keterangan']);
            $this->tanggal = now()->format('Y-m-d'); // Reset tanggal ke hari ini
        } catch (\Exception $e) {
            
            session()->flash('error', 'Gagal membuat jadwal. Silakan coba lagi.');
        }
    }

    public function render()
    {
        return view('livewire.main.jadwal');
    }
}
