<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\OfficeSupply;

class OfficeSupplies extends Component
{
    public $supplies;
    public $archivedSupplies; // ✅ Add this
    public $name, $category, $quantity, $reorder_level, $supply_id;
    public $updateMode = false; 

    public $showArchive = false; // ✅ Add this

    public function render()
    {
        $this->supplies = OfficeSupply::all();
        $this->archivedSupplies = OfficeSupply::onlyTrashed()->get(); // ✅ Fetch archived items

        return view('livewire.office-supplies')
            ->layout('components.layout.layout');
    }

    private function resetInputFields(){
        $this->name = '';
        $this->category = '';
        $this->quantity = '';
        $this->reorder_level = '';
        $this->supply_id = null;
        $this->updateMode = false;
    }

    public function store()
    {
        $validatedData = $this->validate([
            'name' => 'required|string',
            'category' => 'required|string',
            'quantity' => 'required|integer|min:0',
            'reorder_level' => 'required|integer|min:0',
        ]);

        OfficeSupply::create($validatedData);
        session()->flash('message', 'Office Supply Created Successfully.');
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $supply = OfficeSupply::findOrFail($id);
        $this->supply_id = $id;
        $this->name = $supply->name;
        $this->category = $supply->category;
        $this->quantity = $supply->quantity;
        $this->reorder_level = $supply->reorder_level;
        $this->updateMode = true;
    }

    public function update()
    {
        $validatedData = $this->validate([
            'name' => 'required|string',
            'category' => 'required|string',
            'quantity' => 'required|integer|min:0',
            'reorder_level' => 'required|integer|min:0',
        ]);

        if ($this->supply_id) {
            $supply = OfficeSupply::find($this->supply_id);
            $supply->update($validatedData);
            session()->flash('message', 'Office Supply Updated Successfully.');
            $this->resetInputFields();
        }
    }

    public function delete($id)
    {
        OfficeSupply::find($id)->delete(); // ✅ Soft delete
        session()->flash('message', 'Office Supply Archived Successfully.');
    }

    // ✅ Archive toggle
    public function toggleArchive()
    {
        $this->showArchive = !$this->showArchive;
    }

    // ✅ Restore archived item
    public function restore($id)
    {
        OfficeSupply::withTrashed()->find($id)->restore();
        session()->flash('message', 'Office Supply Restored Successfully.');
    }

    // ✅ Permanently delete
    public function forceDelete($id)
    {
        OfficeSupply::withTrashed()->find($id)->forceDelete();
        session()->flash('message', 'Office Supply Deleted Permanently.');
    }
}
