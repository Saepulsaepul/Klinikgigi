<?php

namespace App\Livewire\Cabangs;

use App\Models\Cabang;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

class CabangEdit extends Component
{
   
        #[Title('Cabang Edit')]

    #[Validate('required',message:'Field tidak boleh kosong')]
    #[Validate('min:3',message:'Field minimal 3 karakter')]
    public $nama;
    #[Validate('required',message:'Field tidak boleh kosong')]
    public $alamat;
    #[Validate('required',message:'Field tidak boleh kosong')]
    public $telepon;
    #[Validate('email')]
    public $email;

    public $cabang;
    public function mount($id)
    {
        $this->cabang = Cabang::find($id);
       $this->nama = $this->cabang->nama;
       $this->alamat = $this->cabang->alamat;
       $this->telepon = $this->cabang->telepon;
       $this->email = $this->cabang->email;
    }
    public function render()
    {
        return view('livewire.cabangs.cabang-edit');
    }
    public function update(){
        $this->validate();
        $this->cabang->update($this->all());
        return $this->redirect('/cabangs',navigate:true);

       
    }
}
