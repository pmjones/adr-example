<?php
namespace Pmjones\Adr\Web\Blog\Update;

use Pmjones\Adr\Domain\Blog\BlogService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class BlogUpdateAction
{
    protected $domain;
    protected $responder;

    public function __construct(
        BlogService $domain,
        BlogUpdateResponder $responder
    ) {
        $this->domain = $domain;
        $this->responder = $responder;
    }

    public function __invoke(Request $request) : Response
    {
        $id = $request->getAttributes()['id'] ?? 0;
        $data = $request->getParsedBody()['blog'] ?? [];
        $payload = $this->domain->editPost((int) $id, (array) $data);
        return $this->responder->__invoke($request, $payload);
    }
}
