<?php

namespace App\Http\Livewire;

use App\Models\Package;
use Livewire\Component;
use App\Models\Contract;
use App\Models\Customer;

class Createcontractwr extends Component
{
    public $contract_number, $customer_id, $contract_begin, $contract_end, $package, $price, $qty=1, $description, $status;
    public $contracts = [];
    public $lolos;

    public function add_row()
    {
        $this->contracts[] = [
            'customer_id' => $this->customer_id,
            'contract_number' => getContractRealNumber(),
            'contract_begin' => $this->contract_begin,
            'contract_end' => $this->contract_end,
            'package' => '',
            'price' => 0,
            'qty' => 1,
            'description' =>'',
            'status' => 'Open',
        ];
    }

    public function updatePrice ($index) {
        $data = Package::where('package', $this->contracts[$index]['package'])->first();
        if ($data != null) {
            $this->contracts[$index]['price'] = $data->price;
            $this->contracts[$index]['description'] = $data->description;
        }
    }

    public function delete_row($index)
    {
        unset($this->contracts[$index]);
        $this->contracts = array_values($this->contracts);
    }

    public function saveContract()
    {
        for($i = 0; $i < count($this->contracts); $i++){
            if($this->contracts[$i]['package'] == "" || $this->contracts[$i]['price'] <= 0 ||  $this->contracts[$i]['qty'] <= 0 || $this->contracts[$i]['description'] == "") {
                $this->lolos = 0; break;
            } else {
                $this->lolos = 1;
            }
        }
        if ($this->lolos == 1 ) {
            for ($i = 0; $i < count($this->contracts); $i++) {
                $this->contracts[$i]['customer_id'] = $this->customer_id;
                $this->contracts[$i]['contract_begin'] = $this->contract_begin;
                $this->contracts[$i]['contract_end'] = $this->contract_end;
            }
            foreach ($this->contracts as $key => $value) {
                $data = Contract::create([
                    'contract_number' => $value['contract_number'],
                    'contract_begin' => $value['contract_begin'],
                    'contract_end' => $value['contract_end'],
                    'customer_id' => $value['customer_id'],
                    'package' => $value['package'],
                    'price' => $value['price'],
                    'qty' => $value['qty'],
                    'description' => $value['description'],
                    'status' => $value['status'],
                ]);
            }
            $this->contracts = [];
            $this->dispatchBrowserEvent('success', ['message' => 'Data Saved']);
            return  redirect()->to('/contract');
        } else {
            $this->dispatchBrowserEvent('error', ['message' => 'Data incomplete']);
        }
    }

    public function createContract()
    {
        $this->contract_number = getContractNumber();

    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function clear()
    {

        $this->package = '';
        $this->price = '0';
        $this->qty = '0';
        $this->description = '';
        $this->status = 'Open';
    }

    public function mount()
    {
        $this->customer = Customer::all();
        $this->packageData = Package::all();
        $this->createContract();
    }

    public function render()
    {
        return view('livewire.createcontractwr');
    }
}