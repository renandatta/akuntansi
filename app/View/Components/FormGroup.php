<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FormGroup extends Component
{
    public $caption, $id;
    public function __construct(
        $caption = '',
        $id = ''
    )
    {
        $this->caption = $caption;
        $this->id = $id;
    }

    public function render()
    {
        return view('components.form-group');
    }
}
