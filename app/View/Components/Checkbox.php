<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Checkbox extends Component
{
    public $prefix, $name, $caption;
    public function __construct(
        $prefix = '',
        $name = '',
        $caption = ''
    )
    {
        $this->prefix = $prefix;
        $this->name = $name;
        $this->caption = $caption;
    }

    public function render()
    {
        return view('components.checkbox');
    }
}
