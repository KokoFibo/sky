<?php

namespace App\Http\Livewire;

use App\Models\Package;
use Livewire\Component;

class Test extends Component
{
    public function render()
    {
        $data = Package::find(55);
        return view('livewire.test', [
            'data' => $data
        ]);
    }
}
