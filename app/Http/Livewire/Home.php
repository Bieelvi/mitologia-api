<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Home extends Component
{
    public $titlePage = 'Home';

    public function render()
    {        
        return view('livewire.home')
            ->layoutData(['titlePage' => $this->titlePage]);
    }
}
