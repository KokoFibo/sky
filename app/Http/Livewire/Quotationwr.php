<?php

namespace App\Http\Livewire;

use App\Models\Quotation;
use Carbon\Carbon;
use App\Models\Package;
use Livewire\Component;
use App\Models\Customer;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class Quotationwr extends Component
{
    use WithPagination;
    public $customer, $package, $packageData,  $price, $description, $customer_id, $status;
    public $perpage = 5, $search = '';
    protected $listeners =  ['delete'];

    public function deleteConfirmation ($number) {
        $data = Quotation::where('number', $number )->first();
        $formattedNumber = quoNumberFormat($number, $data->quotation_date);
        $company = getCompany($data->customer_id);
        $this->dispatchBrowserEvent('delete_confirmation', [
            'title' => 'Are you sure',
            'text' => "to delete " . $formattedNumber. " of ". $company. " data?",
            'icon' => 'warning',
            'id' => $number,
        ]);
    }

    public function delete ($id) {
        $number = $id;

        if($id != null) {
            $data = Quotation::where('number', $number)->get();
            foreach($data as $d) {
                $record = Quotation::find($d->id);
                $record->delete();
            }
        }
        $this->dispatchBrowserEvent('success', ['message' => 'Data Deleted']);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function mount () {
        // $this->customer = Customer::all();
        // $this->packageData = Package::all();
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
        $data = DB::table('quotations')->groupBy('number')->orderBy('number', 'desc')->paginate($this->perpage);
        return view('livewire.quotationwr', compact(['data']));
    }
}
