<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Customer;
use Livewire\WithPagination;

class Customerwr extends Component
{
    use WithPagination;

    public $name, $salutation, $title, $company, $address, $mobile, $email, $notes, $idCustomer, $is_active;
    public $perpage = 10, $search = '';
    protected $listeners =  ['delete'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function deleteConfirmation($id)
    {
        $data = Customer::find($id);
        $name = $data->name;
        $company = $data->company;
        $this->dispatchBrowserEvent('delete_confirmation', [
            'title' => 'Are you sure',
            'text' => "to delete " . $name . " of " . $company . " data?",
            'icon' => 'warning',
            'id' => $id,
        ]);
    }

    public function delete($id)
    {
        if ($id != null) {
            $data = Customer::find($id);
            $data->delete();
            $this->dispatchBrowserEvent('success', ['message' => 'Data Deleted']);
        }
    }

    public function editCustomer($id)
    {
        if ($id != null) {
            $data = Customer::find($id);
            $this->idCustomer = $data->id;
            $this->name = $data->name;
            $this->salutation = $data->salutation;
            $this->title = $data->title;
            $this->company = $data->company;
            $this->address = $data->address;
            $this->mobile = $data->mobile;
            $this->email = $data->email;
            $this->notes = $data->notes;
            $this->is_active = $data->is_active;
        }
    }

    public function updateCustomer()
    {
        $this->validate();
        $data = Customer::find($this->idCustomer);
        $data->name = $this->name;
        $data->salutation = $this->salutation;
        $data->title = $this->title;
        $data->company = $this->company;
        $data->address = $this->address;
        $data->mobile = $this->mobile;
        $data->email = trim($this->email, ' ');
        $data->notes = $this->notes;
        $data->is_active = $this->is_active;
        $data->save();
        $this->clear();
        $this->dispatchBrowserEvent('success', ['message' => 'Data Updated']);
    }

    public function clear()
    {
        $this->name = '';
        $this->salutation = '';
        $this->title = '';
        $this->company = '';
        $this->address = '';
        $this->mobile = '';
        $this->email = '';
        $this->notes = '';
        $this->is_active = '';
    }

    protected $rules = [
        'name' => 'required',
        'salutation' => 'required',
        'title' => 'required',
        'company' => 'nullable',
        'address' => 'nullable',
        'mobile' => 'required',
        'email' => 'required',
        'notes' => 'nullable',
        'is_active' => 'nullable',
    ];


    public function saveCustomer()
    {
        $this->validate();
        $data = new Customer();
        $data->name = $this->name;
        $data->salutation = $this->salutation;
        $data->title = $this->title;
        $data->company = $this->company;
        $data->address = $this->address;
        $data->mobile = $this->mobile;
        $data->email = trim($this->email, ' ');
        $data->notes = $this->notes;
        $data->is_active = true;
        $data->save();
        $this->clear();
        $this->dispatchBrowserEvent('success', ['message' => 'Data Saved']);
    }

    public function render()
    {
        $data = Customer::orderBy('id', 'desc')
            ->where('name', 'like', '%' . trim($this->search) . '%')
            ->orWhere('company', 'like', '%' . trim($this->search) . '%')
            ->paginate($this->perpage);
        return view('livewire.customerwr', compact('data'));
    }
}
