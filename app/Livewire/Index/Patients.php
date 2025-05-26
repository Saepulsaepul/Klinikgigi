<?php

namespace App\Livewire\Index;

use App\Models\Patient;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Title;

#[Layout('components.layouts.index')]
class Patients extends Component
{
    
    use WithPagination;
#[Title('Daftar Pasien')]
    public $search = '';
    public $jenisKelaminFilter = '';
    public $selectedPatientId;
    public $showDeleteModal = false;
    
    protected $paginationTheme = 'bootstrap';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingJenisKelaminFilter()
    {
        $this->resetPage();
    }

    public function confirmDelete($id)
    {
        $this->selectedPatientId = $id;
    $this->showDeleteModal = true;
    $this->dispatch('showDeleteModal');
    }

    public function deletePatient()
    {
        Patient::findOrFail($this->selectedPatientId)->delete();

    $this->showDeleteModal = false;

    $this->dispatch('show-toast', [
        'type' => 'success',
        'message' => 'Pasien berhasil dihapus.'
    ]);

    $this->dispatch('close-modal');
    }

    public function render()
    {
        $query = Patient::query();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('nama', 'like', '%' . $this->search . '%')
                  ->orWhere('no_ktp', 'like', '%' . $this->search . '%')
                  ->orWhere('alamat', 'like', '%' . $this->search . '%')
                  ->orWhere('no_hp', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->jenisKelaminFilter !== '') {
            $query->where('jenis_kelamin', $this->jenisKelaminFilter);
        }

        return view('livewire.index.patients', [
            'patients' => $query->orderBy('created_at', 'desc')->paginate(10),
        ]);
    }
}