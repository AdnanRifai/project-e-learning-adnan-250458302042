<?php

namespace App\Livewire\Admin\Module;

use Livewire\Component;
use App\Models\Module;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class ModuleIndex extends Component
{
    public $modules;

    public function mount()
    {
        $this->modules = Module::with('course')->latest()->get();
    }

    public function delete($id)
    {
        Module::findOrFail($id)->delete();
        session()->flash('message', 'Module deleted successfully.');
        $this->modules = Module::with('course')->latest()->get(); // refresh list
    }

    public function render()
    {
        return view('livewire.admin.module.module-index');
    }
}
