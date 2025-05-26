<?php

namespace App\Livewire\Main;

use App\Models\JadwalPemeriksaan;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Carbon\Carbon;
use Livewire\Attributes\Title;

class Index extends Component
{
    #[Title('Dashboard Pasien')]
    public $user;
    public $upcomingAppointments;
    public $treatmentHistory;

    #[Layout('components.layouts.main')]
   
    public function mount()
    {
        $this->user = Auth::user();
        $patient = $this->user->patient;

        // Initialize as empty collections
        $this->upcomingAppointments = collect();
        $this->treatmentHistory = collect();

        if ($patient) {
            // Upcoming appointments - keep as Collection
            $this->upcomingAppointments = JadwalPemeriksaan::with('pemeriksaan')
                ->where('patient_id', $patient->id)
                ->where('tanggal', '>=', now()->toDateString())
                ->orderBy('tanggal')
                ->get()
                ->map(function ($item) {
                    return [
                        'tanggal' => Carbon::parse($item->tanggal)->format('d M Y'),
                        'jam' => $item->jam,
                        'dokter' => $item->dokter ?? '-',
                        'keterangan' => $item->keterangan ?? '-',
                        'status' => $item->status
                    ];
                });

            // Completed treatments history - keep as Collection
            $this->treatmentHistory = JadwalPemeriksaan::with('pemeriksaan')
                ->where('patient_id', $patient->id)
                ->where('status', 'selesai')
                ->orderByDesc('tanggal')
                ->get()
                ->map(function ($item) {
                    return [
                        'tanggal' => Carbon::parse($item->tanggal)->format('d M Y'),
                        'dokter' => $item->dokter ?? '-',
                        'rencana_perawatan' => $item->pemeriksaan->rencana_perawatan ?? '-',
                        'keterangan' => $item->keterangan ?? '-',
                    ];
                });
        }
    }

    public function render()
    {
        return view('livewire.main.index', [
            'hasUpcomingAppointments' => $this->upcomingAppointments->isNotEmpty(),
            'hasTreatmentHistory' => $this->treatmentHistory->isNotEmpty(),
        ]);
    }
}