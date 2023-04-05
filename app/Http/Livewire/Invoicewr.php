<?php

namespace App\Http\Livewire;

use App\Models\Invoice;
use Carbon\Carbon;
use App\Models\Package;
use Livewire\Component;
use App\Models\Contract;
use App\Models\Customer;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class Invoicewr extends Component
{
    use WithPagination;

    public $perpage = 5, $search = '';
    protected $listeners =  ['delete'];

    public function deleteConfirmation ($number) {
        $data = Invoice::where('number', $number )->first();
        $formattedNumber = invNumberFormat($number, $data->invoice_date);
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
            $data = Invoice::where('number', $number)->get();
            foreach($data as $d) {
                $record = Invoice::find($d->id);
                $record->delete();
            }
        }
        $this->dispatchBrowserEvent('success', ['message' => 'Data Deleted']);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        // $data = Invoice::orderby('id', 'desc')->distinct('number')->paginate($this->perpage);
        // $data = DB::table('invoices')->distinct('number')->count('price')->paginate($this->perpage);

        $data = Invoice::groupBy('number')->orderBy('number', 'desc')->paginate($this->perpage);
        return view('livewire.invoicewr', compact(['data']));
    }
}
