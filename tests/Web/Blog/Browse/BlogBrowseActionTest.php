<?php
namespace Pmjones\Adr\Web\Blog\Browse;

use Pmjones\Adr\Web\Blog\BlogActionTest;

class BlogBrowseActionTest extends BlogActionTest
{
    public function testDefaultPage()
    {
        $request = $this->newRequest();
        $response = $this->action->__invoke($request);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testAnotherPage()
    {
        $request = $this->newRequest([], ['page' => '2', 'paging' => '50']);
        $response = $this->action->__invoke($request);
        $this->assertEquals(200, $response->getStatusCode());
    }
}
