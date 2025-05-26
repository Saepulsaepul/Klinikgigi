<?php

namespace App\Livewire\Dok;

use Livewire\Attributes\Layout;
use Livewire\Component;
use Carbon\Carbon;
use App\Models\User;
use App\Models\JadwalPemeriksaan;
use App\Models\Patient;
use App\Models\PemeriksaanGigi;
use Livewire\Attributes\Title;
use Livewire\WithPagination;

#[Layout('components.layouts.dok')]
#[Title('Dashboard Dokter')]
class DokDashboard extends Component
{
    use WithPagination;

    public $selectedDate;
    public $viewMode = 'day';
    public $showAppointmentModal = false;
    public $appointmentDetails = [];
    public $listDokter = [];
    public $searchTerm = '';

    public function mount()
    {
        $this->selectedDate = now()->format('Y-m-d');
        $this->listDokter = User::where('role', 'dokter')->get();
    }

    public function getStatsProperty()
    {
        return [
            'today_appointments' => JadwalPemeriksaan::whereDate('tanggal', $this->selectedDate)
                                    ->where('status', '!=', 'batal')
                                    ->count(),
            'total_patients' => Patient::count(),
            'pending_treatments' => JadwalPemeriksaan::whereDate('tanggal', $this->selectedDate)
                                    ->where('status', 'terjadwal')
                                    ->count(),
            'completed_treatments' => PemeriksaanGigi::whereDate('created_at', $this->selectedDate)
                                    ->count(),
        ];
    }

    public function getAppointmentsProperty()
    {
        return JadwalPemeriksaan::with(['patient', 'pemeriksaan'])
            ->whereDate('tanggal', $this->selectedDate)
            ->when($this->searchTerm, function($query) {
                $query->whereHas('patient', function($q) {
                    $q->where('nama', 'like', '%'.$this->searchTerm.'%');
                });
            })
            ->orderBy('jam')
            ->paginate(10);
    }

    public function getPatientsProperty()
    {
        return Patient::whereHas('jadwals', function($query) {
            $query->whereDate('tanggal', $this->selectedDate)
                ->where('status', 'terjadwal')
                  ->whereDoesntHave('pemeriksaan');
        })
        ->orderBy('nama')
        ->limit(5)
        ->get(['nama', 'no_hp', 'tanggal_lahir']);
    }

    public function changeDate($days)
    {
        $this->selectedDate = Carbon::parse($this->selectedDate)
            ->addDays($days)
            ->format('Y-m-d');
        $this->resetPage();
    }

    public function showAppointmentDetails($id)
    {
        $this->appointmentDetails = JadwalPemeriksaan::with(['patient', 'pemeriksaan'])
            ->findOrFail($id);
            
        $this->showAppointmentModal = true;
    }

    public function completeAppointment($id)
    {
        $jadwal = JadwalPemeriksaan::findOrFail($id);
        
        // Update the appointment status
        $jadwal->update(['status' => 'selesai']);
        
        // Create examination record if it doesn't exist
        if (!$jadwal->pemeriksaan) {
            PemeriksaanGigi::create([
                'jadwal_pemeriksaan_id' => $jadwal->id,
                'rencana_perawatan' => 'Perawatan selesai',
                'tindakan' => 'Pemeriksaan rutin',
                'catatan' => 'Pasien dalam kondisi baik'
            ]);
        }
        
        $this->dispatch('notify', 
            type: 'success', 
            message: 'Perawatan selesai dicatat'
        );
        $this->showAppointmentModal = false;
    }

    public function cancelAppointment($id)
    {
        $jadwal = JadwalPemeriksaan::findOrFail($id);
        $jadwal->update(['status' => 'batal']);
        
        $this->dispatch('notify', 
            type: 'success', 
            message: 'Jadwal berhasil dibatalkan'
        );
    }

    public function render()
    {
        return view('livewire.dok.dashboard', [
            'stats' => $this->stats,
            'appointments' => $this->appointments,
            'patients' => $this->patients
        ]);
    }
}