<?php
namespace Pmjones\Adr\Web\Blog\Edit;

use Pmjones\Adr\Domain\Blog\BlogService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class BlogEditAction
{
    protected $domain;
    protected $responder;

    public function __construct(
        BlogService $domain,
        BlogEditResponder $responder
    ) {
        $this->domain = $domain;
        $this->responder = $responder;
    }

    public function __invoke(Request $request) : Response
    {
        $id = (int) $request->getAttributes()['id'] ?? 0;
        $payload = $this->domain->fetchPost($id);
        return $this->responder->__invoke($request, $payload);
    }
}
