<?php

namespace App\Livewire\Admin\Module;

use Livewire\Component;
use App\Models\Module;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class ModuleShow extends Component
{
    public $module;

    public function mount(Module $module)
    {
        $this->module = $module->load('course');
    }

    public function render()
    {
        return view('livewire.admin.module.module-show');
    }
}
