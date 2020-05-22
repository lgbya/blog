<?php
namespace App\Http\Controllers\Admin\Extensions;

use Encore\Admin\Show\AbstractField;

class EditorMdShow extends AbstractField
{

    public function render($arg = '')
    {
        return view('extensions\editormd', ['docContent' => $this->value]);
    }

}