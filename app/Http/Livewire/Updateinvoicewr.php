<?php

namespace App\Http\Livewire;

use App\Models\Invoice;
use App\Models\Package;
use Livewire\Component;
use App\Models\Contract;
use App\Models\Customer;
use Illuminate\Support\Facades\Session;

class Updateinvoicewr extends Component
{
    public $current_number, $invoice, $customer, $dataContract, $contract, $discount, $tax = 0.0, $status;
    public $customer_id, $invoice_date, $due_date, $number, $invoice_number, $invoice_id, $packages;
    public $updateUpper, $current_id, $prevContract, $idEditContract, $deleteContract, $isSave;
    public $package, $price, $qty, $formattedTax = 0.0;
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
            $data = Invoice::find($id);
            $data->delete();
            $this->invoice = Invoice::where('number', $this->current_number)->get();

            $this->dispatchBrowserEvent('success', ['message' => 'Data Deleted']);
        }
    }

    public function updatedContract () {
        if($this->prevContract != $this->contract){
            if($this->contract == ''){
                $prevData = Contract::where('contract_number', $this->prevContract)->first();
                $id_invoice = Invoice::where('number', $this->number)->where('package', $prevData->package)->first();
                try {
                    if($id_invoice->id != null) {
                        $this->idEditContract = $id_invoice->id;
                        $this->deleteContract = true;
                    }
                } catch (\Exception $e) {
                     return $e->getMessage();
                }

            } else {

                if($this->prevContract == '')
                {
                    $data = Contract::where('contract_number', $this->contract)->first();
                    $this->package = $data->package;
                    $this->price = $data->price;
                    $this->qty = $data->qty;
                    $this->prevContract = $this->contract;
                    $this->isSave = true;

                } else {
                    $data = Contract::where('contract_number', $this->contract)->first();
                    $prevData = Contract::where('contract_number', $this->prevContract)->first();
                    $id_invoice = Invoice::where('number', $this->number)->where('package', $prevData->package)->first();
                    $this->package = $data->package;
                    $this->price = $data->price;
                    $this->qty = $data->qty;
                    $this->prevContract = $this->contract;
                    $this->idEditContract = $id_invoice->id;
                }


            }
        }
    }

    public function mount ($current_number) {
        Session::put('task_url', request()->fullUrl());
        $this->updateUpper = false;
        $this->current_number = $current_number;
        $this->number = $current_number;
        $this->packages = Package::all();
        $this->idEditContract = 0;
        $this->deleteContract = false;
        $this->isSave = false;

        $this->invoice = Invoice::where('number', $this->current_number)->get();
        foreach($this->invoice as $i) {
            $this->customer_id = $i->customer_id;
            $this->invoice_date = $i->invoice_date;
            $this->due_date = $i->due_date;
            $this->contract = $i->contract;
            $this->discount = $i->discount;
            $this->tax = $i->tax;
            $this->status = $i->status;
            $this->prevContract = $i->contract; ;

        }
        $this->customer = Customer::all();
        $this->dataContract = Contract::where('customer_id', $this->customer_id)->get();
        $this->invoice_number = invNumberFormat($this->number, $this->invoice_date);
    }

    public function updatedTax () {
        // cara ini supaya tidak error saat edit
        try {
            $this->formattedTax = number_format((float)$this->tax);
        } catch (\Exception $e) {
             return $e->getMessage();
}
    }

    public function updatedEditPackage () {
        $data = Package::where('package', $this->edit_package)->get();
        $this->edit_price = $data->price;
    }
    public function editUpper () {
        $this->updateUpper = true;
    }

    public function updatedDiscount () {
        if($this->discount == null) {
            $this->discount = 0;
        }
    }

    public function updateUpper () {
        $data_id = Invoice::where('number', $this->current_number)->select('id')->get();
        if($data_id != null) {
            if ($this->deleteContract == true) {
                dd(getInvoiceId($number));
                $data = Invoice::find(getInvoiceId($number));
                // $data = Invoice::find($this->idEditContract);
                $data->delete();
                $data = Invoice::where('number', $this->number)->where('package',$this->package)->first();
                dd($this->number, $this->package);
                $invoice_id = Invoice::find($d->id);
                $invoice_id->contract = '';
                $invoice_id->save;
                $this->deleteContract = false;
                $this->invoice = Invoice::where('number', $this->current_number)->get();

            } elseif($this->isSave == true) {
                $data = new Invoice();
                $data->tax = $this->tax;
                $data->discount = $this->discount;
                $data->invoice_date = $this->invoice_date;
                $data->due_date = $this->due_date;
                $data->customer_id = $this->customer_id;
                $data->contract = $this->contract;
                $data->package = $this->package;
                $data->price = $this->price;
                $data->qty = $this->qty;
                $data->tax = $this->tax;
                $data->discount = $this->discount;
                $data->status = $this->status;

                } else {
                foreach($data_id as $d) {
                    $data = Invoice::find($d->id);
                    $data->customer_id = $this->customer_id;
                    $data->contract = $this->contract;
                    if($this->idEditContract == $d->id) {
                        $data->package = $this->package;
                        $data->price = $this->price;
                        $data->qty = $this->qty;
                    }
                    $data->invoice_date = $this->invoice_date;
                    $data->due_date = $this->due_date;
                    if($this->discount == null) {
                        $this->discount = 0;
                    }
                    $data->discount = $this->discount;
                    $data->tax = $this->tax;
                    $data->status = $this->status;
                    $data->save();
                    $this->invoice = Invoice::where('number', $this->current_number)->get();

                }
                $this->dispatchBrowserEvent('success', ['message' => 'Data Updated']);
            }
        }


        $this->updateUpper = false;
    }

    public function back () {
        return redirect()->to('/invoice');
    }

    public function cancel () {
        $this->updateUpper = false;
        $this->updateLower = false;

    }

    public function editLower ($id) {
        $this->invoice_id = $id;

    }

    public function updateLower ($id) {

        $this->current_id = $id;
        // if($this->invoice_id != null) {
        //     $data = Invoice::find($this->invoice_id);
        //     $data->package = $this->package;
        //     $data->price = $this->price;
        //     $data->qty = $this->qty;
        //     $data->save();
        // }
        $this->updateLower = false;
    }

    public function render()
    {
            return view('livewire.updateinvoicewr');
    }
}
