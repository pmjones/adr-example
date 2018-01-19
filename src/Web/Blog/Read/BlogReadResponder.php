<?php
namespace Pmjones\Adr\Web\Blog\Read;

use Pmjones\Adr\Web\Blog\BlogResponder;

class BlogReadResponder extends BlogResponder
{
    protected function found() : void
    {
        $this->renderTemplate('read');
    }
}
