<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Contract;

class Contractwr extends Component
{
    public $perpage = 5, $search = '';
    public function render()
    {
        $data = Contract::groupBy('contract_number')->orderBy('contract_number', 'desc')->paginate($this->perpage);
        return view('livewire.contractwr', compact(['data']));
    }
}
