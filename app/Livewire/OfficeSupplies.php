<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\OfficeSupply;

class OfficeSupplies extends Component
{
    // Specify the layout for Livewire
    protected string $layout = 'components.layouts.app'; // ✅ Add this line here

    public $supplies;
    public $name, $category, $quantity, $reorder_level, $supply_id;
    public $updateMode = false; // already initialized

    public function render()
    {
        $this->supplies = OfficeSupply::all();
        return view('livewire.office-supplies');
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
        OfficeSupply::find($id)->delete();
        session()->flash('message', 'Office Supply Deleted Successfully.');
    }
}
