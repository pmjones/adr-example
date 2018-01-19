<?php
namespace Pmjones\Adr\Web\Blog\Browse;

use Pmjones\Adr\Web\Blog\BlogResponder;

class BlogBrowseResponder extends BlogResponder
{
    protected function found() : void
    {
        $this->renderTemplate('browse');
    }
}
