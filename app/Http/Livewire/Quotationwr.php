<?php

namespace App\Http\Livewire;

use App\Models\Package;
use Livewire\Component;
use App\Models\Customer;
use App\Models\Quotation;
use Livewire\WithPagination;

class Quotationwr extends Component
{
    use WithPagination;
    public $customer, $package, $packageData,  $price, $description, $customer_id, $status;
    public function mount () {
        $this->customer = Customer::all();
        $this->packageData = Package::all();
    }

    public function updatedPackage () {
        if($this->package) {
            $data = Package::where('package', $this->package)->first();
            $this->price = $data->price;
            $this->description = $data->description;
        }
    }

    public function render()
    {
        $data = Quotation::orderBy('id', 'desc')->paginate(5);
        return view('livewire.quotationwr', compact(['data']));
    }
}
