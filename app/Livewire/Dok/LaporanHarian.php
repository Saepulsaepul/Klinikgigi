<?php

namespace App\Livewire\Dok;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\PemeriksaanGigi;
use App\Models\KondisiGigi;
use App\Models\Patient;
use Illuminate\Support\Carbon;
use Livewire\Attributes\Layout;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;

#[Layout('components.layouts.dok')]
#[Title('Laporan Dokter')]
class LaporanHarian extends Component
{
    use WithPagination;

    public $tanggal;
    public $bulan;
    public $search = '';
    public $perPage = 10;
    public $reportType = 'daily'; // 'daily' or 'monthly'
    public $showAllPatients = false;
    public $showVisitsOnly = true;
    public $viewingPatientHistory = false;
    public $selectedPatient = null;
    public $patientHistory = [];
    protected $paginationTheme = 'bootstrap';

    public function mount()
    {
        $this->tanggal = now()->format('Y-m-d');
        $this->bulan = now()->format('Y-m');
    }

    public function render()
    {
        if ($this->showAllPatients) {
            return $this->renderPatientSearch();
        }

        return $this->renderExaminationReport();
    }

    protected function renderExaminationReport()
    {
        $query = PemeriksaanGigi::with([
            'jadwal.patient',
            'kondisiGigi' => function ($query) {
                $query->select('id', 'pemeriksaan_id', 'nomor_gigi', 'kondisi', 'tindakan');
            }
        ]);

        if ($this->reportType === 'daily') {
            $query->whereDate('tanggal_pemeriksaan', $this->tanggal);
        } else {
            $query->whereYear('tanggal_pemeriksaan', Carbon::parse($this->bulan)->year)
                  ->whereMonth('tanggal_pemeriksaan', Carbon::parse($this->bulan)->month);
        }

        $query->latest('created_at');

        if ($this->search) {
            $query->where(function($q) {
                $q->whereHas('jadwal.patient', function($patient) {
                    $patient->where('nama', 'like', '%'.$this->search.'%')
                           ->orWhere('no_ktp', 'like', '%'.$this->search.'%');
                });
            });
        }

        $pemeriksaan = $query->paginate($this->perPage);

        $summary = $this->calculateSummary($pemeriksaan->items());

        return view('livewire.dok.laporan-harian', [
            'pemeriksaan' => $pemeriksaan,
            'totalPasien' => $pemeriksaan->total(),
            'totalTindakan' => $summary['totalTindakan'],
            'kondisiGigiSummary' => $summary['kondisiSummary'],
            'allPatients' => collect([]), // Empty collection for the view
            'showAllPatients' => $this->showAllPatients,
            'reportType' => $this->reportType,
            'viewingPatientHistory' => $this->viewingPatientHistory,
            'selectedPatient' => $this->selectedPatient,
            'patientHistory' => $this->patientHistory,
        ]);
    }

    protected function renderPatientSearch()
    {
        $query = Patient::withCount(['jadwals as examinations_count' => function($q) {
            $q->has('pemeriksaan');
        }])
        ->with(['jadwals' => function($q) {
            $q->has('pemeriksaan')
              ->with('pemeriksaan')
              ->latest()
              ->take(1);
        }]);

        if ($this->search) {
            $query->where('nama', 'like', '%'.$this->search.'%')
                  ->orWhere('no_ktp', 'like', '%'.$this->search.'%');
        }

        if ($this->showVisitsOnly) {
            $query->has('jadwals.pemeriksaan');
        }

        $allPatients = $query->paginate($this->perPage);

        return view('livewire.dok.laporan-harian', [
            'pemeriksaan' => collect([]), // Empty collection for the view
            'allPatients' => $allPatients,
            'totalPasien' => $allPatients->total(),
            'totalTindakan' => 0,
            'kondisiGigiSummary' => [],
            'showAllPatients' => $this->showAllPatients,
            'reportType' => $this->reportType,
            'viewingPatientHistory' => $this->viewingPatientHistory,
            'selectedPatient' => $this->selectedPatient,
            'patientHistory' => $this->patientHistory,
        ]);
    }

    public function togglePatientSearch()
    {
        $this->showAllPatients = !$this->showAllPatients;
        $this->resetPage();
    }

    public function viewPatientHistory($patientId)
    {
        $this->selectedPatient = Patient::find($patientId);
        $this->patientHistory = PemeriksaanGigi::whereHas('jadwal', function($q) use ($patientId) {
            $q->where('patient_id', $patientId);
        })
        ->with(['kondisiGigi', 'jadwal.dokter'])
        ->latest()
        ->get();

        $this->viewingPatientHistory = true;
    }

    public function closePatientHistory()
    {
        $this->viewingPatientHistory = false;
        $this->selectedPatient = null;
        $this->patientHistory = [];
    }

    protected function calculateSummary(array $data)
    {
        $collection = collect($data);
        $kondisiGigi = $collection->pluck('kondisiGigi')->flatten();

        return [
            'totalTindakan' => $kondisiGigi->whereNotNull('tindakan')->count(),
            'kondisiSummary' => $kondisiGigi->groupBy('kondisi')->map->count()
        ];
    }

    public function exportPdf()
    {
        $query = PemeriksaanGigi::with([
            'jadwal.patient',
            'jadwal.dokter',
            'kondisiGigi'
        ]);

        if ($this->reportType === 'daily') {
            $query->whereDate('tanggal_pemeriksaan', $this->tanggal);
        } else {
            $query->whereYear('tanggal_pemeriksaan', Carbon::parse($this->bulan)->year)
                  ->whereMonth('tanggal_pemeriksaan', Carbon::parse($this->bulan)->month);
        }

        $data = $query->orderBy('created_at', 'desc')->get();

        $title = $this->reportType === 'daily' 
            ? "Laporan Harian {$this->formatIndonesianDate($this->tanggal)}"
            : "Laporan Bulanan {$this->formatIndonesianMonth($this->bulan)}";

        $pdf = Pdf::loadView('exports.dok.laporan-harian', [
            'data' => $this->cleanData($data->toArray()),
            'title' => $title,
            'kondisiSummary' => $this->calculateSummary($data->toArray())['kondisiSummary'],
            'isMonthly' => $this->reportType === 'monthly'
        ])->setPaper('a4', 'portrait');

        $fileName = $this->reportType === 'daily'
            ? "laporan-harian-{$this->tanggal}.pdf"
            : "laporan-bulanan-{$this->bulan}.pdf";

        return response()->streamDownload(
            fn () => print($pdf->output()),
            $fileName
        );
    }

    public function exportRekamMedis($pemeriksaanId)
    {
        $pemeriksaan = PemeriksaanGigi::with([
            'jadwal.patient',
            'jadwal.dokter',
            'kondisiGigi'
        ])->findOrFail($pemeriksaanId);

        $pdf = Pdf::loadView('exports.dok.rekam-medis', [
            'pemeriksaan' => $this->cleanData($pemeriksaan->toArray()),
            'tanggal' => $this->formatIndonesianDate($pemeriksaan->tanggal_pemeriksaan),
        ])->setPaper('a4', 'portrait');

        $noKtp = $pemeriksaan->jadwal->patient->no_ktp ?? 'RM';
        $fileName = "rekam-medis-{$noKtp}-{$pemeriksaan->tanggal_pemeriksaan}.pdf";

        return response()->streamDownload(
            fn () => print($pdf->output()),
            $fileName
        );
    }

    protected function formatIndonesianDate($dateString)
    {
        if (empty($dateString)) return '';

        $date = Carbon::parse($dateString);
        $days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        $months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 
                  'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        return $days[$date->dayOfWeek] . ', ' . $date->day . ' ' . 
               $months[$date->month-1] . ' ' . $date->year;
    }

    protected function formatIndonesianMonth($monthString)
    {
        if (empty($monthString)) return '';

        $date = Carbon::parse($monthString);
        $months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 
                  'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        return $months[$date->month-1] . ' ' . $date->year;
    }

    protected function cleanData($data)
    {
        if (is_array($data)) {
            return array_map([$this, 'cleanData'], $data);
        }

        if (is_string($data)) {
            $data = mb_convert_encoding($data, 'UTF-8', 'UTF-8');
            return preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/u', '', $data);
        }

        return $data;
    }

    public function updatedTanggal()
    {
        $this->resetPage();
    }

    public function updatedBulan()
    {
        $this->resetPage();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedReportType()
    {
        $this->resetPage();
    }
}