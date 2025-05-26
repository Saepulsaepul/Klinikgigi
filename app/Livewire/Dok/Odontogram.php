<?php

namespace App\Livewire\Dok;

use Livewire\Component;
use App\Models\KondisiGigi;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('components.layouts.dok')]
#[Title('Odontogram Dokter')]
class Odontogram extends Component
{
    public $pemeriksaanId;
    public $toothConditions = [];
    public $selectedTooth = null;
    public $showDetailPanel = false;
    public $editingTooth = [
        'nomor_gigi' => null,
        'kondisi' => 'sehat',
        'tindakan' => null,
        'catatan' => null,
    ];

    protected $allTeeth = [
        '18','17','16','15','14','13','12','11','21','22','23','24','25','26','27','28',
        '48','47','46','45','44','43','42','41','31','32','33','34','35','36','37','38'
    ];

    public function mount($pemeriksaanId = null)
    {
        $this->pemeriksaanId = $pemeriksaanId;
        $this->loadToothConditions();
    }

    public function loadToothConditions()
    {
        // Initialize with default values
        foreach ($this->allTeeth as $tooth) {
            $this->toothConditions[$tooth] = [
                'nomor_gigi' => $tooth,
                'kondisi' => 'sehat',
                'tindakan' => null,
                'catatan' => null,
            ];
        }

        // Load from database if available
        if ($this->pemeriksaanId) {
            $existingConditions = KondisiGigi::where('pemeriksaan_id', $this->pemeriksaanId)
                ->get()
                ->keyBy('nomor_gigi');

            foreach ($existingConditions as $tooth => $condition) {
                if (in_array($tooth, $this->allTeeth)) {
                    $this->toothConditions[$tooth] = [
                        'nomor_gigi' => $tooth,
                        'kondisi' => $condition->kondisi,
                        'tindakan' => $condition->tindakan,
                        'catatan' => $condition->catatan,
                    ];
                }
            }
        }
    }

    public function getToothSymbol($condition)
    {
        return match($condition) {
            'sehat' => '✓',
            'karies' => '●',
            'tambalan' => '◑',
            'hilang' => '✕',
            'akar' => '⌄',
            'implants' => 'ⓘ',
            default => ''
        };
    }

    public function selectTooth($toothNumber)
    {
        if (!in_array($toothNumber, $this->allTeeth)) return;

        $this->selectedTooth = $toothNumber;
        $this->editingTooth = $this->toothConditions[$toothNumber] ?? [
            'nomor_gigi' => $toothNumber,
            'kondisi' => 'sehat',
            'tindakan' => null,
            'catatan' => null,
        ];
        $this->showDetailPanel = true;
    }

    public function saveTooth()
    {
        if (!$this->selectedTooth) return;

        $this->toothConditions[$this->selectedTooth] = $this->editingTooth;
        
        // Save to database
        if ($this->pemeriksaanId) {
            KondisiGigi::updateOrCreate(
                [
                    'pemeriksaan_id' => $this->pemeriksaanId,
                    'nomor_gigi' => $this->selectedTooth,
                ],
                [
                    'kondisi' => $this->editingTooth['kondisi'],
                    'tindakan' => $this->editingTooth['tindakan'],
                    'catatan' => $this->editingTooth['catatan'],
                ]
            );
        }

        $this->closeDetailPanel();
    }

    public function closeDetailPanel()
    {
        $this->selectedTooth = null;
        $this->showDetailPanel = false;
        $this->reset('editingTooth');
    }

    public function render()
    {
        return view('livewire.dok.odontogram', [
            'getToothSymbol' => fn($condition) => $this->getToothSymbol($condition)
        ]);
    }
}