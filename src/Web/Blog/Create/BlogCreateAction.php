<?php
namespace Pmjones\Adr\Web\Blog\Create;

use Pmjones\Adr\Domain\Blog\BlogService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class BlogCreateAction
{
    protected $domain;
    protected $responder;

    public function __construct(
        BlogService $domain,
        BlogCreateResponder $responder
    ) {
        $this->domain = $domain;
        $this->responder = $responder;
    }

    public function __invoke(Request $request) : Response
    {
        $data = $request->getParsedBody()['blog'] ?? [];
        $payload = $this->domain->addPost((array) $data);
        return $this->responder->__invoke($request, $payload);
    }
}
