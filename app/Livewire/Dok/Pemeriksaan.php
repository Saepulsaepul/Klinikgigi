<?php

namespace App\Livewire\Dok;

use Livewire\Component;
use Carbon\Carbon;
use App\Models\Patient;
use App\Models\JadwalPemeriksaan;
use App\Models\PemeriksaanGigi;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\WithFileUploads;

#[Layout('components.layouts.dok')]
#[Title('Pemeriksaan Gigi Dokter')]
class Pemeriksaan extends Component
{
    use WithFileUploads;

    public $selectedScheduleId = null;
    public $selectedPatient = null;
    public $examinationData = [
        'date' => '',
        'complaint' => '',
        'diagnosis' => '',
        'treatment' => '',
        'notes' => '',
        'images' => []
    ];

    public $treatments = [
        'Scaling',
        'Tambal Gigi',
        'Cabut Gigi',
        'Pembersihan Karang Gigi',
        'Pemasangan Behel',
        'Pemutihan Gigi'
    ];

    public $schedules = [];
    public $examinationHistory = [];
    public $showOdontogram = false;
    public $lastExaminationId = null;

    public function mount()
    {
        $this->examinationData['date'] = now()->format('Y-m-d');
        $this->loadSchedules();
    }

    public function loadSchedules()
    {
        $this->schedules = JadwalPemeriksaan::with(['patient' => function($query) {
                $query->select('id', 'nama', 'no_hp', 'tanggal_lahir');
            }])
            ->where('status', 'terkonfirmasi')
            ->whereDate('tanggal', '>=', now()->subDays(3))
            ->whereDate('tanggal', '<=', now()->addDays(7))
            ->orderBy('tanggal')
            ->orderBy('jam')
            ->get();
    }

    public function selectSchedule($scheduleId)
    {
        $this->selectedScheduleId = $scheduleId;
        $schedule = JadwalPemeriksaan::with('patient')->findOrFail($scheduleId);
        $this->selectedPatient = $schedule->patient;
        $this->loadExaminationHistory($schedule->patient_id);
        $this->showOdontogram = false;
        $this->lastExaminationId = null;
        
        // Reset form data kecuali tanggal
        $this->examinationData = [
            'date' => now()->format('Y-m-d'),
            'complaint' => $schedule->keterangan ?? '',
            'diagnosis' => '',
            'treatment' => '',
            'notes' => '',
            'images' => []
        ];
    }

    public function loadExaminationHistory($patientId)
    {
        $this->examinationHistory = PemeriksaanGigi::with(['jadwal', 'kondisiGigi'])
            ->whereHas('jadwal', function ($query) use ($patientId) {
                $query->where('patient_id', $patientId);
            })
            ->orderBy('tanggal_pemeriksaan', 'desc')
            ->get()
            ->toArray();
    }

    public function saveExamination()
    {
        $validated = $this->validate([
            'examinationData.date' => 'required|date',
            'examinationData.complaint' => 'required|string|max:500',
            'examinationData.diagnosis' => 'required|string|max:500',
            'examinationData.treatment' => 'required|string|max:255',
            'examinationData.notes' => 'nullable|string|max:1000',
            'examinationData.images.*' => 'nullable|image|max:2048',
        ]);

        // Handle file uploads
        $imagePaths = [];
        if (!empty($this->examinationData['images'])) {
            foreach ($this->examinationData['images'] as $image) {
                $imagePaths[] = $image->store('examination-images', 'public');
            }
        }

        $pemeriksaan = PemeriksaanGigi::create([
            'jadwal_id' => $this->selectedScheduleId,
            'tanggal_pemeriksaan' => $validated['examinationData']['date'],
            'keluhan_pasien' => $validated['examinationData']['complaint'],
            'diagnosis' => $validated['examinationData']['diagnosis'],
            'rencana_perawatan' => $validated['examinationData']['treatment'],
            'catatan_tambahan' => $validated['examinationData']['notes'],
            'gambar' => !empty($imagePaths) ? json_encode($imagePaths) : null,
        ]);

        // Update appointment status
        JadwalPemeriksaan::find($this->selectedScheduleId)
            ->update(['status' => 'selesai']);

        $this->lastExaminationId = $pemeriksaan->id;
        $this->showOdontogram = true;
        $this->loadExaminationHistory($this->selectedPatient->id);
        
        $this->dispatch('notify', 
            type: 'success', 
            message: 'Pemeriksaan berhasil disimpan. Silakan lengkapi odontogram.'
        );
    }

    public function backToForm()
    {
        $this->showOdontogram = false;
        $this->loadExaminationHistory($this->selectedPatient->id);
    }

    public function render()
    {
        return view('livewire.dok.pemeriksaan');
    }
}