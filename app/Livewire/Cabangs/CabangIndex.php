<?php

namespace App\Livewire\Cabangs;

use App\Models\Cabang;
use Livewire\Component;
use Livewire\Attributes\Title;

class CabangIndex extends Component
{
   #[Title('Cabang')]
    public function render()
    {
        return view('livewire.cabangs.cabang', [
            'cabangs' => Cabang::all() 
        ]);
    }
    public function delete($id){
        $cabang = Cabang::find($id);
        $cabang->delete(); 
        return $this->redirect('/cabangs',navigate:true);
    }
}
