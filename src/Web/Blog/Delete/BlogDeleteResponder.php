<?php
namespace Pmjones\Adr\Web\Blog\Delete;

use Pmjones\Adr\Web\Blog\BlogResponder;

class BlogDeleteResponder extends BlogResponder
{
    protected function deleted() : void
    {
        $this->renderTemplate('deleted');
    }
}
