<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Alert extends Component
{
    public $type, $id;
    public function __construct($type = '', $id = '')
    {
        $this->type = $type;
        $this->id = $id;
    }

    public function render()
    {
        return view('components.alert');
    }
}
