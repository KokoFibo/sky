<?php

namespace App\Http\Livewire;

use App\Models\Package;
use Livewire\Component;
use App\Models\Contract;
use App\Models\Customer;
use Illuminate\Support\Facades\Session;


class Updatecontractwr extends Component
{
    public $contract_number, $customer_id, $contract_begin, $contract_end, $package, $price, $qty=1, $description, $status;
    public $contracts = [];
    public $lolos, $updateUpper;
    public $edit_price, $edit_description, $current_number, $number, $contract_number_full;
    public $current_id, $contract_id;

    protected $listeners =  ['delete'];

    public function deleteConfirmation ($id) {
        $this->dispatchBrowserEvent('delete_confirmation', [
            'title' => 'Are you sure',
            'text' => "to delete this data?",
            'icon' => 'warning',
            'id' => $id,
        ]);
    }

    public function delete ($id) {
        if($id != null) {
            $data = Contract::find($id);
            $data->delete();
            $this->contract = Contract::where('contract_number', $this->current_number)->get();

            $this->dispatchBrowserEvent('success', ['message' => 'Data Deleted']);
        }
    }

    public function mount ($current_number) {
        Session::put('task_url', request()->fullUrl());
        $this->updateUpper = false;
        $this->current_number = $current_number;
        $this->contract_number = $current_number;
        $this->packages = Package::all();

        $this->contract = Contract::where('contract_number', $this->current_number)->get();
        foreach($this->contract as $i) {
            $this->customer_id = $i->customer_id;
            $this->contract_begin = $i->contract_begin;
            $this->contract_end = $i->contract_end;
            $this->contract_number = $i->contract_number;
            $this->status = $i->status;

        }
        $this->customer = Customer::all();
        $this->contract_number_full = contractNumberFormat($current_number);
    }

    public function updatedEditPackage () {
        $data = Package::where('package', $this->edit_package)->get();
        $this->edit_price = $data->price;
        $this->edit_description = $data->description;
    }
    public function editUpper () {
        $this->updateUpper = true;
    }

    public function updateUpper () {
        $data_id = Contract::where('contract_number', $this->current_number)->select('id')->get();
        if($data_id != null) {
            foreach($data_id as $d) {
                $data = Contract::find($d->id);
                $data->customer_id = $this->customer_id;
                $data->contract_begin = $this->contract_begin;
                $data->contract_end = $this->contract_end;
                $data->status = $this->status;
                $data->save();
            }
            $this->dispatchBrowserEvent('success', ['message' => 'Data Updated']);
        }
        $this->updateUpper = false;
    }

    public function back () {
        return redirect()->to('/contract');
    }

    public function cancel () {
        $this->updateUpper = false;
        $this->updateLower = false;

    }

    public function editLower ($id) {
        $this->contract_id = $id;

    }
    public function updateLower ($id) {

        $this->current_id = $id;

        $this->updateLower = false;
    }

    public function render()
    {
        return view('livewire.updatecontractwr');
    }
}