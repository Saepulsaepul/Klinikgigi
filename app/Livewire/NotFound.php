<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Component;

class NotFound extends Component
{
    #[Layout('components.layouts.notfount')]
    public function render()
    {
        return view('livewire.not-found');
    }
}
