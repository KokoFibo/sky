<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use App\Models\Invoice;
use App\Models\Package;
use Livewire\Component;
use App\Models\Contract;
use App\Models\Customer;

class Createinvoicewr extends Component
{
    public $number,  $price,  $qty, $tax,  $invoice_date, $due_date, $status, $package_id, $invoice_id, $paket;
    public $invoices = [], $package, $contract, $contract_date, $customer, $customer_id;
    public $lolos, $dataContract, $discount, $subtotal, $total, $test, $contract_list;

    public function updatePrice($index)
    {
        $data = Package::where('package', $this->invoices[$index]['package'])->first();
        if ($data != null) {
            $this->invoices[$index]['price'] = $data->price;
        }
    }

    public function add_row()
    {
        if ($this->discount == null) {
            $this->discount = 0;
        }
        if ($this->tax == null) {
            $this->tax = 0;
        }
        $this->invoices[] = [
            'number' => getInvoiceRealNumber(),
            'invoice_date' => $this->invoice_date,
            'due_date' => $this->due_date,
            'customer_id' => $this->customer_id,
            'contract' => $this->contract,
            'package' => '',
            'price' => 0,
            'qty' => 0,
            'tax' => $this->tax,
            'discount' => $this->discount,
            'status' => 'Draft',
        ];
    }
    // ok
    public function updatedContract()
    {
        $data = Contract::where('contract_number', $this->contract)->get();
        if ($data->isNotEmpty()) {
            $this->contract_date = $data[0]->contract_date;
            if ($this->contract != null) {
                if ($this->discount == null) {
                    $this->discount = 0;
                }
                if ($this->tax == null) {
                    $this->tax = 0;
                }
                $this->invoice = [];
                $this->delete_row(0);
                foreach ($data as $d) {

                    $this->invoices[] = [
                        'number' => getInvoiceRealNumber(),
                        'invoice_date' => $this->invoice_date,
                        'due_date' => $this->due_date,
                        'customer_id' => $this->customer_id,
                        'contract' => $this->contract,
                        'package' => $d->package,
                        'price' => $d->price,
                        // 'qty' => $d->qty,
                        'qty' => 0,
                        'tax' => $this->tax,
                        'discount' => $this->discount,
                        'status' => 'Draft',
                    ];
                }
            }
        } else {
            // $this->delete_row(0);
            $this->delete_all_row(0);
        }
    }
    public function updatedCustomerId()
    {
        try {
            $this->contract = '';
            // $this->dataContract = Contract::where('customer_id', $this->customer_id)->first();
            // $this->contract = $this->dataContract->contract_number;
            $this->contract_list = Contract::where('customer_id', $this->customer_id)
                ->where('done', '==', '0000-00-00')->select('contract_number', 'contract_date')->distinct()
                ->get();

            // $this->contract_date = $data->contract_date;

            // $this->contract = $data->contract_number;
            // if($this->contract != null) {
            //     $this->delete_row(0);

            //     if ($this->discount == null) {
            //         $this->discount = 0;
            //     }
            //     if ($this->tax == null) {
            //         $this->tax = 0;
            //     }
            //     $this->invoices[] = [
            //         'number' => getInvoiceRealNumber(),
            //         'invoice_date' => $this->invoice_date,
            //         'due_date' => $this->due_date,
            //         'customer_id' => $this->customer_id,
            //         'contract' => $this->contract,
            //         'package' => $data->package,
            //         'price' => $data->price,
            //         // 'qty' => $data->qty,
            //         'qty' => 0,
            //         'tax' => $this->tax,
            //         'discount' => $this->discount,
            //         'status' => 'Draft',
            //     ];

            // } else {
            //     $this->delete_row(0);
            //     $this->contract = '';
            // }
        } catch (\Exception $e) {
            $this->delete_row(0);
            $this->contract = '';

            return $e->getMessage();
        }
    }

    public function delete_row($index)
    {
        unset($this->invoices[$index]);
        $this->invoices = array_values($this->invoices);
    }
    public function delete_all_row()
    {
        unset($this->invoices[0]);
        unset($this->invoices[1]);
        unset($this->invoices[2]);
        unset($this->invoices[3]);
        unset($this->invoices[4]);


        $this->invoices = array_values($this->invoices);
    }

    public function saveInvoice()
    {
        for ($i = 0; $i < count($this->invoices); $i++) {
            if ($this->invoices[$i]['package'] == "" || $this->invoices[$i]['price'] <= 0 ||  $this->invoices[$i]['qty'] <= 0) {
                $this->lolos = 0;
                break;
            } else {
                $this->lolos = 1;
            }
        }

        if ($this->lolos == 1) {



            for ($i = 0; $i < count($this->invoices); $i++) {
                $this->invoices[$i]['customer_id'] = $this->customer_id;
                $this->invoices[$i]['contract'] = $this->contract;
                $this->invoices[$i]['tax'] = $this->tax;
                $this->invoices[$i]['discount'] = $this->discount;
                $this->invoices[$i]['invoice_date'] = $this->invoice_date;
                $this->invoices[$i]['due_date'] = $this->due_date;
            }

            // dd($this->invoices[0]['customer_id']);
            foreach ($this->invoices as $key => $value) {
                $data = Invoice::create([
                    'number' => $value['number'],
                    'invoice_date' => $value['invoice_date'],
                    'due_date' => $value['due_date'],
                    'customer_id' => $value['customer_id'],
                    'contract' => $value['contract'],
                    'package' => $value['package'],
                    'price' => $value['price'],
                    'qty' => $value['qty'],
                    'tax' => $value['tax'],
                    'discount' => $value['discount'],
                    'status' => $value['status'],
                ]);
            }
            // }
            $this->invoices = [];
            $this->dispatchBrowserEvent('success', ['message' => 'Data Saved']);

            return  redirect()->to('/invoice');
        } else {
            $this->dispatchBrowserEvent('error', ['message' => 'Data incomplete']);
        }
    }

    public function createInvoice()
    {
        $this->number = getInvoiceNumber();
        $this->invoice_date = date('Y-m-d');
        $this->due_date = dueDate($this->invoice_date);
    }



    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function clear()
    {

        $this->customer_id = '';
        $this->contract = '';
        $this->package = '';
        $this->price = '0';
        $this->qty = '0';
        $this->tax = '0';
        $this->discount = '0';
        $this->status = 'Draft';
    }


    public function mount()
    {
        $this->subtotal = 0;
        $this->total = 0;
        $this->customer = Customer::all();
        $this->packageData = Package::all();
        // $this->clear();
        $this->createInvoice();
    }



    public function render()
    {
        return view('livewire.createinvoicewr');
    }
}
