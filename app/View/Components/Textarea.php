<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Textarea extends Component
{
    public $class, $prefix, $name, $caption, $value, $rows;
    public function __construct(
        $class = null,
        $prefix = null,
        $name = null,
        $caption = null,
        $value = '',
        $rows = 3
    )
    {
        $this->class = $class;
        $this->prefix = $prefix;
        $this->name = $name;
        $this->caption = $caption;
        $this->value = $value;
        $this->rows = $rows;
    }

    public function render()
    {
        return view('components.textarea');
    }
}
