<?php
namespace Pmjones\Adr\Web\Blog\Create;

use Pmjones\Adr\Web\Blog\BlogResponder;

class BlogCreateResponder extends BlogResponder
{
    protected function created() : void
    {
        $blog = $this->payload->getResult()['blog'];
        $this->response = $this->response
            ->withStatus(201)
            ->withHeader('Location', "/blog/read/{$blog->id}");
    }

    protected function notValid()
    {
        $this->response = $this->response->withStatus(422);
        $this->renderTemplate('add');
    }
}
