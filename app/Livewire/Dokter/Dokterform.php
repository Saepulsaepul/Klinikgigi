<?php

namespace App\Livewire\Dokter;

use Livewire\Attributes\Layout;
use Livewire\Component;


class Dokterform extends Component
{
    #[Layout('components.layouts.app')]
    public function render()
    {
        return view('livewire.dokter.dokterform');
    }
}
