<?php

namespace App\Livewire\Index;

use Livewire\Component;
use App\Models\Patient;
use App\Models\Cabang;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('components.layouts.index')]
class Createpasien extends Component
{
    #[Title('Tambah Pasien')]
    public $nama;
    public $no_ktp;
    public $no_hp;
    public $email;
    public $tanggal_lahir;
    public $jenis_kelamin;
    public $alamat;
    public $cabang_id;

    public $editingPatientId = null;
    public $isEditing = false;

    protected function rules()
    {
        return [
            'nama' => 'required|string|max:255',
            'no_ktp' => 'nullable|string|max:20|unique:patients,no_ktp,' . $this->editingPatientId,
            'no_hp' => 'required|string|max:15',
            'email' => 'nullable|email|unique:patients,email,' . $this->editingPatientId,
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'alamat' => 'nullable|string',
            'cabang_id' => 'required|exists:cabangs,id',
        ];
    }

    protected $messages = [
        'nama.required' => 'Nama pasien wajib diisi',
        'no_hp.required' => 'Nomor HP wajib diisi',
        'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih',
        'cabang_id.required' => 'Cabang wajib dipilih',
        'no_ktp.unique' => 'Nomor KTP sudah terdaftar',
        'email.unique' => 'Email sudah terdaftar'
    ];

    public function mount($id = null)
    {
        $this->cabang_id = Auth::user()->cabang_id ?? null;

        if ($id) {
            $this->loadPatient($id);
        }
    }

    public function loadPatient($id)
    {
        $patient = Patient::findOrFail($id);
        $this->editingPatientId = $patient->id;
        $this->isEditing = true;

        $this->nama = $patient->nama;
        $this->no_ktp = $patient->no_ktp;
        $this->no_hp = $patient->no_hp;
        $this->email = $patient->email;
        $this->tanggal_lahir = $patient->tanggal_lahir;
        $this->jenis_kelamin = $patient->jenis_kelamin;
        $this->alamat = $patient->alamat;
        $this->cabang_id = $patient->cabang_id;
    }

    public function save()
    {
        $validatedData = $this->validate();

        if ($this->isEditing) {
            $patient = Patient::findOrFail($this->editingPatientId);
            $patient->update($validatedData);
            session()->flash('success', 'Data pasien berhasil diperbarui');
        } else {
            Patient::create([
                ...$validatedData,
                'user_id' => Auth::id(),
            ]);
            session()->flash('success', 'Pasien berhasil ditambahkan');
        }

        return redirect()->route('receptionist-dashboard');
    }

    public function render()
    {
        return view('livewire.index.createpasien', [
            'cabangs' => Cabang::all(),
            'isEditing' => $this->isEditing
        ]);
    }
}
