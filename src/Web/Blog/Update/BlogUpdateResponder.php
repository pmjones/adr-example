<?php
namespace Pmjones\Adr\Web\Blog\Update;

use Pmjones\Adr\Web\Blog\BlogResponder;

class BlogUpdateResponder extends BlogResponder
{
    protected function updated() : void
    {
        $this->renderTemplate('edit');
    }

    protected function notValid() : void
    {
        $this->response = $this->response->withStatus('422');
        $this->renderTemplate('edit');
    }
}
