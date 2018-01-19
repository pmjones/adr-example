<?php
namespace Pmjones\Adr\Web\Blog\Delete;

use Pmjones\Adr\Domain\Blog\BlogService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class BlogDeleteAction
{
    protected $domain;
    protected $responder;

    public function __construct(
        BlogService $domain,
        BlogDeleteResponder $responder
    ) {
        $this->domain = $domain;
        $this->responder = $responder;
    }

    public function __invoke(Request $request) : Response
    {
        $id = (int) $request->getAttributes()['id'] ?? 0;
        $payload = $this->domain->deletePost($id);
        return $this->responder->__invoke($request, $payload);
    }
}
