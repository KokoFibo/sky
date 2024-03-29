<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use App\Models\Package;
use App\Models\Contract;
use App\Models\Customer;
use App\Models\Quotation;
use Livewire\Component;

class Createquotationwr extends Component
{
    public $number, $price, $qty, $tax, $quotation_date, $status, $package_id, $quotation_id, $paket, $discount;
    public $quotations = [],
        $package,
        $customer,
        $customer_id;
    public $lolos;

    public function updatePrice($index)
    {
        $data = Package::where('package', $this->quotations[$index]['package'])->first();
        if ($data != null) {
            $this->quotations[$index]['price'] = $data->price;
            $this->quotations[$index]['description'] = $data->description;
        }
    }


    public function add_row()
    {
        if ($this->tax == null) {
            $this->tax = 0;
        }
        if ($this->discount == null) {
            $this->discount = 0;
        }
        $this->quotations[] = [
            'number' => getQuotationRealNumber(),
            'quotation_date' => $this->quotation_date,
            'customer_id' => $this->customer_id,
            'package' => '',
            'price' => 0,
            'qty' => 0,
            'discount' => $this->discount,
            'tax' => $this->tax,
            'description' => '',
            'status' => 'Draft',
        ];
    }

    public function delete_row($index)
    {
        unset($this->quotations[$index]);
        $this->quotations = array_values($this->quotations);
    }
    protected $rules = [
        'package' => 'required',
        'price' => 'required|numeric',
        'description' => 'required',
];

    public function saveQuotation()
    {

            for ($i = 0; $i < count($this->quotations); $i++) {
            if ($this->quotations[$i]['package'] == '' || $this->quotations[$i]['price'] <= 0 || $this->quotations[$i]['qty'] <= 0 || $this->quotations[$i]['description'] == '') {
                $this->lolos = 0;
                break;
            } else {
                $this->lolos = 1;
            }
        }

        if ($this->lolos == 1) {
            for ($i = 0; $i < count($this->quotations); $i++) {
                $this->quotations[$i]['customer_id'] = $this->customer_id;
                $this->quotations[$i]['quotation_date'] = $this->quotation_date;
            }

            foreach ($this->quotations as $key => $value) {
                $data = quotation::create([
                    'number' => $value['number'],
                    'quotation_date' => $value['quotation_date'],
                    'customer_id' => $value['customer_id'],
                    'package' => $value['package'],
                    'price' => $value['price'],
                    'qty' => $value['qty'],
                    // 'tax' => $value['tax'],
                    'discount' => $this->discount,
                    'tax' => $this->tax,
                    'description' => $value['description'],
                    'status' => $value['status'],
                ]);
            }
            $this->quotations = [];
            $this->dispatchBrowserEvent('success', ['message' => 'Data Saved']);
            return redirect()->to('/quotation');
        } else {
            $this->dispatchBrowserEvent('error', ['message' => 'Data incomplete']);
        }
    }

    public function createQuotation()
    {
        $this->number = getQuotationNumber();
        $this->quotation_date = date('Y-m-d');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function clear()
    {

        $this->customer_id = '';
        $this->package = '';
        $this->price = '0';
        $this->qty = '';
        $this->discount = '';
        $this->tax = '';
        $this->description = '';
        $this->status = 'Draft';
    }

    public function updatedCustomerId()
    {
        $this->dataContract = Contract::where('customer_id', $this->customer_id)->get();

        try {
            if ($this->dataContract != null) {
                $this->contract = $this->dataContract[0]->contract_number;
            }
        } catch (\Exception $e) {
            $this->contract = '';
            return $e->getMessage();
        }
    }

    public function mount()
    {

        $this->customer = Customer::all();
        $this->packageData = Package::all();
        $this->createQuotation();
    }

    public function render()
    {
        return view('livewire.createquotationwr');
    }
}
