<?php
namespace Pmjones\Adr\Web\Blog\Add;

use Pmjones\Adr\Web\Blog\BlogResponder;

class BlogAddResponder extends BlogResponder
{
    protected function new() : void
    {
        $this->renderTemplate('add');
    }
}
