<?php
namespace Pmjones\Adr\Web\Blog\Edit;

use Pmjones\Adr\Web\Blog\BlogActionTest;

class BlogEditActionTest extends BlogActionTest
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
