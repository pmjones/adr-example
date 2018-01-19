<?php
namespace Pmjones\Adr\Web\Blog\Update;

use Pmjones\Adr\Web\Blog\BlogActionTest;

class BlogUpdateActionTest extends BlogActionTest
{
    public function testUpdated()
    {
        $request = $this->newRequest(['id' => '1'], [], [
            'blog' => [
                'title' => 'Edited Title',
                'author' => 'Edited Author',
                'intro' => 'Edited Intro',
                'body' => 'Edited Body',
            ]
        ]);
        $response = $this->action->__invoke($request);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testNotValid()
    {
        $request = $this->newRequest(['id' => '1'], [], [
            'blog' => [
                'title' => '',
                'author' => 'Edited Author',
                'intro' => 'Edited Intro',
                'body' => 'Edited Body',
            ]
        ]);
        $response = $this->action->__invoke($request);
        $this->assertEquals(422, $response->getStatusCode());
    }
}
