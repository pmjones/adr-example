<?php
namespace Pmjones\Adr\Web\Blog\Read;

use Pmjones\Adr\Web\Blog\BlogActionTest;

class BlogReadActionTest extends BlogActionTest
{
    public function testOk()
    {
        $request = $this->newRequest(['id' => '1']);
        $response = $this->action->__invoke($request);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testNotFound()
    {
        $request = $this->newRequest(['id' => '88']);
        $response = $this->action->__invoke($request);
        $this->assertEquals(404, $response->getStatusCode());
    }
}
