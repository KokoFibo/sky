<?php

namespace App\Livewire;

use App\Models\Package;
use Livewire\Component;
use Livewire\WithPagination;

class Packagewr extends Component
{
    use WithPagination;
    public $package, $price, $description, $idPackage, $description1;
    protected $listeners =  ['delete'];


    public function clear()
    {
        $this->package = '';
        $this->price = '';
        $this->description = '';
        $this->description1 = '';
    }



    public function deleteConfirmation($id)
    {
        $data = Package::find($id);
        $package = $data->package;
        $this->dispatchBrowserEvent('delete_confirmation', [
            'title' => 'Are you sure',
            'text' => "to delete " . $package .  " ?",
            'icon' => 'warning',
            'id' => $id,
        ]);
    }

    public function delete($id)
    {
        if ($id != null) {
            $data = Package::find($id);
            $data->delete();
            $this->dispatch('success', ['message' => 'Data Deleted']);
        }
    }

    protected $rules = [


        'package' => 'required',
        'price' => 'required|numeric',
        'description' => 'required',

    ];

    public function savePackage()
    {
        $this->price = convert_numeric($this->price);
        $this->validate();
        $data = new Package();

        $data->package = $this->package;
        $data->price = $this->price;
        $data->description = $this->description;
        $data->save();
        $this->clear();
        $this->dispatch('success', ['message' => 'Data Saved']);
    }

    public function editPackage($id)
    {
        if ($id != null) {
            $data = Package::find($id);
            $this->idPackage = $data->id;
            $this->package = $data->package;
            $this->price = $data->price;
            $this->description1 = $data->description;
        }
    }

    public function updatePackage()
    {
        $this->price = convert_numeric($this->price);

        $this->validate();

        $data = Package::find($this->idPackage);
        $data->package = $this->package;
        $data->price = $this->price;
        $data->description = $this->description1;
        $data->save();
        $this->clear();
        $this->dispatch('success', ['message' => 'Data Updated']);
    }

    public function render()
    {
        $data = Package::orderBy('id', 'desc')->paginate(10);

        return view('livewire.packagewr', compact('data'));
    }
}