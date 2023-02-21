<?php

namespace App\Http\Livewire;

use Livewire\Component;

class User extends Component
{
    public $titlePage = 'Register';

    public function render()
    {
        return view('livewire.user')
            ->layoutData(['titlePage' => $this->titlePage]);
    }
}
