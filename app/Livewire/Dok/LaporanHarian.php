<?php

namespace App\Livewire\Dok;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\PemeriksaanGigi;
use App\Models\KondisiGigi;
use Illuminate\Support\Carbon;
use Livewire\Attributes\Layout;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;

#[Layout('components.layouts.dok')]
class LaporanHarian extends Component
{
    use WithPagination;
#[Title('Laporan Harian Dokter')]
    public $tanggal;
    public $search = '';
    public $perPage = 10;
    protected $paginationTheme = 'bootstrap';

    public function mount()
    {
        $this->tanggal = now()->format('Y-m-d');
    }

    public function render()
    {
        $query = PemeriksaanGigi::with([
            'jadwal.patient',
            'kondisiGigi' => function ($query) {
                $query->select('id', 'pemeriksaan_id', 'nomor_gigi', 'kondisi', 'tindakan');
            }
        ])
        ->whereDate('tanggal_pemeriksaan', $this->tanggal)
        ->latest('created_at');

        if ($this->search) {
            $query->where(function($q) {
                $q->whereHas('jadwal.patient', function($patient) {
                    $patient->where('nama', 'like', '%'.$this->search.'%')
                           ->orWhere('no_ktp', 'like', '%'.$this->search.'%');
                });
            });
        }

        $pemeriksaan = $query->paginate($this->perPage);

        // Hitung summary dari data yang sudah diload
        $summary = $this->calculateSummary($pemeriksaan->items());

       return view('livewire.dok.laporan-harian', [
            'pemeriksaan' => $pemeriksaan,
            'totalPasien' => $pemeriksaan->total(),
            'totalTindakan' => $this->calculateSummary($pemeriksaan->items())['totalTindakan'],
            'kondisiGigiSummary' => $this->calculateSummary($pemeriksaan->items())['kondisiSummary']
        ]);
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
        $data = PemeriksaanGigi::with([
            'jadwal.patient',
            'jadwal.dokter',
            'kondisiGigi'
        ])
        ->whereDate('tanggal_pemeriksaan', $this->tanggal)
        ->orderBy('created_at', 'desc')
        ->get();

        $pdf = Pdf::loadView('exports.dok.laporan-harian', [
            'data' => $this->cleanData($data->toArray()),
            'tanggal' => $this->formatIndonesianDate($this->tanggal),
            'kondisiSummary' => $this->calculateSummary($data->toArray())['kondisiSummary']
        ])->setPaper('a4', 'portrait');

        return response()->streamDownload(
            fn () => print($pdf->output()),
            "laporan-harian-{$this->tanggal}.pdf"
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
        $fileName = "rekam-medis-{$noKtp}-{$this->tanggal}.pdf";

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

    public function updatedSearch()
    {
        $this->resetPage();
    }
}