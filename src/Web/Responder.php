<?php
namespace Pmjones\Adr\Web;

use Pmjones\Adr\Domain\Payload;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Diactoros\Response;

abstract class Responder
{
    protected $request;

    protected $response;

    protected $payload;

    public function __invoke(Request $request, Payload $payload) : Response
    {
        $this->request = $request;
        $this->payload = $payload;
        $this->response = $this->newResponse();

        $method = $this->getMethodForPayload();
        $this->$method();
        return $this->response;
    }

    protected function newResponse()
    {
        return new Response();
    }

    protected function getMethodForPayload() : string
    {
        $method = str_replace('_', '', strtolower($this->payload->getStatus()));
        return method_exists($this, $method) ? $method : 'notRecognized';
    }

    protected function notRecognized() : void
    {
        $domain_status = $this->payload->getStatus();
        $this->response = $this->response->withStatus(500);
        $this->response->getBody()->write("Unknown domain payload status: '$domain_status'");
    }

    protected function notFound() : void
    {
        $this->response = $this->response->withStatus(404);
        $this->response->getBody()->write("<html><head><title>404 Not Found</title></head><body>404 Not Found</body></html>");
    }

    protected function error() : void
    {
        $e = $this->payload->getResult()['exception'];
        $this->response = $this->response->withStatus(500);
        $this->response->getBody()->write($e->getMessage());
    }
}
