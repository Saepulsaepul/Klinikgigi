<?php

namespace App\Livewire\Index;

use Livewire\Component;
use App\Models\Patient;
use App\Models\JadwalPemeriksaan;
use Livewire\Attributes\Layout;
use Carbon\Carbon;
use Livewire\Attributes\Title;
use Livewire\WithPagination;

#[Layout('components.layouts.index')]
class ReseptionistDashboard extends Component
{
    
    use WithPagination;
#[Title ('Dashboard Resepsionis')]
    public $nama, $no_ktp, $no_hp, $tanggal_lahir, $jenis_kelamin, $email, $alamat;

    public $schedule = [
        'patient_id' => '',
        'tanggal' => '',
        'jam' => '',
        'dokter' => '',
        'keterangan' => '',
        'status' => 'terjadwal',
    ];

    public $searchPatient = '';
    public $searchJadwal = '';
    public $activeTab = 'dashboard';
    protected $listeners = ['deleteConfirmed' => 'deleteJadwal'];

    protected $queryString = ['searchPatient', 'searchJadwal'];

    public function updatedSearchPatient()
    {
        $this->resetPage();
    }

    public function updatedSearchJadwal()
    {
        $this->resetPage();
    }

    public function render()
    {
        $today = Carbon::today();

        $jadwalsQuery = JadwalPemeriksaan::with('patient')
            ->whereDate('tanggal', $today)
            ->when($this->searchJadwal, function ($query) {
                $query->whereHas('patient', function ($q) {
                    $q->where('nama', 'like', '%' . $this->searchJadwal . '%');
                })
                ->orWhere('dokter', 'like', '%' . $this->searchJadwal . '%');
            });

        $jadwals = $jadwalsQuery->orderBy('tanggal')->orderBy('jam')->paginate(10);

        $patients = Patient::when($this->searchPatient, function ($query) {
            $query->where('nama', 'like', '%' . $this->searchPatient . '%')
                  ->orWhere('no_ktp', 'like', '%' . $this->searchPatient . '%')
                  ->orWhere('no_hp', 'like', '%' . $this->searchPatient . '%');
        })->orderBy('nama')->paginate(10);

        return view('livewire.index.dashboard', [
            'pasienHariIni' => Patient::whereDate('created_at', $today)->count(),
            'jadwalHariIni' => $jadwalsQuery->count(),
            'menungguKonfirmasi' => JadwalPemeriksaan::where('status', 'terjadwal')->count(),
            'jadwals' => $jadwals,
            'totalJadwal' => $jadwalsQuery->count(),
            'patients' => $patients,
            'totalPatients' => Patient::count(),
            'allPatients' => Patient::orderBy('id','desc')->get(),
        ]);
    }

    public function switchTab($tab)
    {
        $this->activeTab = $tab;
        $this->resetPage();
        $this->reset(['searchPatient', 'searchJadwal']);
    }

    public function createSchedule($patientId)
    {
        $this->schedule['patient_id'] = $patientId;
        $this->activeTab = 'schedule';
    }

    public function storeSchedule()
    {
        $validated = $this->validate([
            'schedule.patient_id' => 'required|exists:patients,id',
            'schedule.tanggal' => 'required|date|after_or_equal:today',
            'schedule.jam' => 'required|date_format:H:i',
            'schedule.dokter' => 'required|string|max:100',
            'schedule.keterangan' => 'nullable|string',
        ]);

        if (isset($this->schedule['id'])) {
            JadwalPemeriksaan::find($this->schedule['id'])->update($validated['schedule']);
            $message = 'Jadwal berhasil diperbarui!';
        } else {
            JadwalPemeriksaan::create($validated['schedule']);
            $message = 'Jadwal pemeriksaan berhasil dibuat!';
        }

        $this->resetScheduleForm();
        $this->dispatch('alert', type: 'success', message: $message);
    }

    public function resetScheduleForm()
    {
        $this->schedule = [
            'patient_id' => '',
            'tanggal' => '',
            'jam' => '',
            'dokter' => '',
            'keterangan' => '',
            'status' => 'terjadwal',
        ];
        $this->resetErrorBag();
    }

    public function registerPatient()
    {
        $validated = $this->validate([
            'nama' => 'required|string|max:255',
            'no_ktp' => 'required|string|max:20|unique:patients,no_ktp',
            'no_hp' => 'required|string|max:15',
            'tanggal_lahir' => 'required|date|before:today',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'email' => 'nullable|email|max:255|unique:patients,email',
            'alamat' => 'required|string|max:500',
        ]);

        Patient::create($validated);

        $this->resetForm();
        $this->dispatch('alert', type: 'success', message: 'Pasien berhasil didaftarkan!');
    }

    public function resetForm()
    {
        $this->reset([
            'nama',
            'no_ktp',
            'no_hp',
            'tanggal_lahir',
            'jenis_kelamin',
            'email',
            'alamat',
        ]);
        $this->resetErrorBag();
    }

    public function confirmJadwal($id)
    {
        $jadwal = JadwalPemeriksaan::findOrFail($id);
        $jadwal->update(['status' => 'terkonfirmasi']);
        $this->dispatch('alert', type: 'success', message: 'Jadwal berhasil dikonfirmasi!');
    }

    public function editJadwal($id)
    {
        $jadwal = JadwalPemeriksaan::findOrFail($id);
        $this->schedule = [
            'patient_id' => $jadwal->patient_id,
            'tanggal' => $jadwal->tanggal->format('Y-m-d'),
            'jam' => $jadwal->jam,
            'dokter' => $jadwal->dokter,
            'keterangan' => $jadwal->keterangan,
            'status' => $jadwal->status,
            'id' => $jadwal->id,
        ];
        $this->activeTab = 'schedule';
    }

    public function editPatient($id)
    {
        $patient = Patient::findOrFail($id);
        $this->fill($patient->only([
            'nama', 'no_ktp', 'no_hp', 'tanggal_lahir',
            'jenis_kelamin', 'email', 'alamat',
        ]));
        $this->activeTab = 'patient';
    }

    public function confirmDeletePatient($id)
    {
        $this->dispatchBrowserEvent('confirm-delete', [
            'type' => 'warning',
            'title' => 'Hapus Pasien?',
            'text' => 'Data pasien dan semua jadwal terkait akan dihapus',
            'id' => $id,
            'method' => 'deletePatient',
        ]);
    }

    public function deletePatient($id)
    {
        Patient::findOrFail($id)->delete();
        $this->dispatch('alert', type: 'success', message: 'Pasien berhasil dihapus');
    }

    public function markAsDone($id)
    {
        $jadwal = JadwalPemeriksaan::findOrFail($id);
        $jadwal->update(['status' => 'selesai']);
        $this->dispatch('alert', type: 'success', message: 'Jadwal ditandai selesai!');
    }

    public function deleteJadwal($id)
    {
        JadwalPemeriksaan::findOrFail($id)->delete();
        session()->flash('success', 'Jadwal berhasil dihapus.');
    }

    public function exportJadwal()
    {
        $today = Carbon::today();
        $fileName = 'jadwal-pemeriksaan-' . $today->format('Y-m-d') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$fileName}",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $jadwals = JadwalPemeriksaan::with('patient')
            ->whereDate('tanggal', $today)
            ->get();

        $callback = function () use ($jadwals) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['No', 'Nama Pasien', 'Tanggal', 'Jam', 'Dokter', 'Status']);

            foreach ($jadwals as $index => $jadwal) {
                fputcsv($file, [
                    $index + 1,
                    $jadwal->patient->nama ?? '-',
                    $jadwal->tanggal->format('d/m/Y'),
                    $jadwal->jam,
                    $jadwal->dokter,
                    $jadwal->status,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
