<?php
namespace Pmjones\Adr\Web\Blog\Add;

use Pmjones\Adr\Web\Blog\BlogActionTest;

class BlogAddActionTest extends BlogActionTest
{
    public function test()
    {
        $request = $this->newRequest();
        $response = $this->action->__invoke($request);
        $this->assertEquals(200, $response->getStatusCode());
    }
}
