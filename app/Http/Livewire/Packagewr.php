<?php

namespace App\Http\Livewire;

use App\Models\Package;
use Livewire\Component;
use Livewire\WithPagination;

class Packagewr extends Component
{
    use WithPagination;
    public $package, $price, $idPackage;
    protected $listeners =  ['delete'];


    public function clear () {
        $this->package = '';
        $this->price = '';
    }

    public function deleteConfirmation ($id) {
        $data = Package::find($id);
        $package = $data->package;
        $this->dispatchBrowserEvent('delete_confirmation', [
            'title' => 'Are you sure',
            'text' => "to delete " . $package.  " ?",
            'icon' => 'warning',
            'id' => $id,
        ]);
    }

    public function delete ($id) {
        if($id != null) {
            $data = Package::find($id);
            $data->delete();
            $this->dispatchBrowserEvent('success', ['message' => 'Data Deleted']);
        }
    }

    public function savePackage () {
        $data = new Package();
        $data->package = $this->package;
        $data->price = $this->price;
        $data->save();
        $this->clear();
        $this->dispatchBrowserEvent('success', ['message' => 'Data Saved']);
    }

    public function editPackage ($id) {
        if($id != null) {
            $data = Package::find($id);
            $this->idPackage = $data->id;
            $this->package = $data->package;
            $this->price = $data->price;
        }
    }

    public function updatePackage () {
        $data = Package::find($this->idPackage);
        $data->package = $this->package;
        $data->price = $this->price;
        $data->save();
        $this->clear();
        $this->dispatchBrowserEvent('success', ['message' => 'Data Updated']);


    }

    public function render()
    {
        $data = Package::orderBy('package', 'asc')->paginate(10);

        return view('livewire.packagewr', compact('data'));
    }
}
