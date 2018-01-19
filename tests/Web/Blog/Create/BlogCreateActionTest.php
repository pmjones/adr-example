<?php
namespace Pmjones\Adr\Web\Blog\Create;

use Pmjones\Adr\Web\Blog\BlogActionTest;

class BlogCreateActionTest extends BlogActionTest
{
    public function testCreated()
    {
        $request = $this->newRequest([], [], [
            'blog' => [
                'title' => 'New Title',
                'author' => 'New Author',
                'intro' => 'New Intro',
                'body' => 'New Body',
            ]
        ]);
        $response = $this->action->__invoke($request);
        $this->assertEquals(201, $response->getStatusCode());
        $this->assertEquals('/blog/read/4', $response->getHeaders()['Location'][0]);
    }

    public function testNotValid()
    {
        $request = $this->newRequest([], [], [
            'blog' => [
                'title' => '',
                'author' => 'New Author',
                'intro' => 'New Intro',
                'body' => 'New Body',
            ]
        ]);
        $response = $this->action->__invoke($request);
        $this->assertEquals(422, $response->getStatusCode());
    }
}
