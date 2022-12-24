<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FilePreview extends Component
{
    public $file, $name, $class;
    public function __construct($file,
                                $name = '',
                                $class = '')
    {
        $this->file = $file;
        $this->name = $name;
        $this->class = $class;
    }

    public function render()
    {
        $temp = explode('.', $this->file);
        $file_type = end($temp);
        return view('components.file-preview', compact('file_type'));
    }
}
