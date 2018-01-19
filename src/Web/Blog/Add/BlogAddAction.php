<?php
namespace Pmjones\Adr\Web\Blog\Add;

use Pmjones\Adr\Domain\Blog\BlogService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class BlogAddAction
{
    protected $domain;
    protected $responder;

    public function __construct(
        BlogService $domain,
        BlogAddResponder $responder
    ) {
        $this->domain = $domain;
        $this->responder = $responder;
    }

    public function __invoke(Request $request) : Response
    {
        $payload = $this->domain->newPost();
        return $this->responder->__invoke($request, $payload);
    }
}
