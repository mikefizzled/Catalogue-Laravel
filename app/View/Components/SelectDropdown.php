<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SelectDropdown extends Component
{
    public $name;
    public $options;
    public $selected;
    public $optionLabel;

    public function __construct($name, $options, $optionLabel, $selected = null)
    {
        $this->name = $name;
        $this->options = $options;
        $this->selected = $selected;
        $this->optionLabel = $optionLabel;
    }

    public function render()
    {
        return view('components.select-dropdown');
    }
}
