<?php
namespace Pmjones\Adr\Web\Blog\Edit;

use Pmjones\Adr\Web\Blog\BlogResponder;

class BlogEditResponder extends BlogResponder
{
    protected function found() : void
    {
        $this->renderTemplate('edit');
    }
}
