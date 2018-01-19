<?php
namespace Pmjones\Adr\Web\Blog\Browse;

use Pmjones\Adr\Domain\Blog\BlogService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class BlogBrowseAction
{
    protected $domain;
    protected $responder;

    public function __construct(
        BlogService $domain,
        BlogBrowseResponder $responder
    ) {
        $this->domain = $domain;
        $this->responder = $responder;
    }

    public function __invoke(Request $request) : Response
    {
        $page = $request->getQueryParams()['page'] ?? 1;
        $paging = $request->getQueryParams()['paging'] ?? 10;
        $payload = $this->domain->fetchPage((int) $page, (int) $paging);
        return $this->responder->__invoke($request, $payload);
    }
}
