<?php

namespace App\Livewire\Cabangs;

use App\Models\Cabang;
use Laravel\SerializableClosure\Serializers\Native;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

class CabangCreate extends Component
{
    #[Title('Cabang Create')]

    #[Validate('required',message:'Field tidak boleh kosong')]
    #[Validate('min:3',message:'Field minimal 3 karakter')]
    public $nama;
    #[Validate('required',message:'Field tidak boleh kosong')]
    public $alamat;
    #[Validate('required',message:'Field tidak boleh kosong')]
    public $telepon;
    #[Validate('email')]
    public $email;
    
    public function render()
    {
        return view('livewire.cabangs.cabang-create');
    }
   public function create(){
        $this->validate();
        Cabang::create ($this->all());
        return $this->redirect('/cabangs',navigate:true);
   }
}
