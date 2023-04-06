<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Contract;
use Illuminate\Support\Facades\Storage;

class Contractwr extends Component
{
    public $perpage = 5, $search = '';
    protected $listeners =  ['delete'];

    public function downloadpdf ($contract_number) {
        $data = Contract::where('contract_number', $contract_number)->first();
        // return response()->download(storage_path($pdf));
        // return response()->download(storage_path($pdf));
        // return Storage::download('pdfs\3Poxm6ik9vIoABHHO6pP6YBFa0kzr3zyvXT38Ty9.pdf');
        return Storage::download($data->pdf);
    }


    public function deleteConfirmation ($number) {
        $data = Contract::where('contract_number', $number )->first();
        $formattedNumber = contractNumberFormat($number);
        // $formattedNumber = invNumberFormat($number, $data->contract_date);
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
            $data = Contract::where('contract_number', $number)->get();
            foreach($data as $d) {
                $record = Contract::find($d->id);
                $record->delete();
            }
        }
        $this->dispatchBrowserEvent('success', ['message' => 'Data Deleted']);
    }

    public function render()
    {
        $data = Contract::groupBy('contract_number')->orderBy('contract_number', 'desc')->paginate($this->perpage);
        return view('livewire.contractwr', compact(['data']));
    }
}
