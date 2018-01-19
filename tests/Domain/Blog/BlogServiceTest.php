<?php
namespace Pmjones\Adr\Domain\Blog;

use Pmjones\Adr\DataSource\Blog\BlogMapper;
use Pmjones\Adr\DataSource\Blog\BlogRecord;
use Pmjones\Adr\DataSource\Blog\BlogRecordSet;
use Pmjones\Adr\Domain\Payload;
use Pmjones\Adr\SqliteFixture;

class BlogServiceTest extends \PHPUnit\Framework\TestCase
{
    protected $pdo;
    protected $domain;

    protected function setup()
    {
        $this->pdo = SqliteFixture::setup();
        $this->domain = new BlogService(
            new BlogMapper($this->pdo),
            new BlogFilter()
        );
    }

    protected function assertCreated(Payload $payload)
    {
        $this->assertSame(Payload::STATUS_CREATED, $payload->getStatus());
    }

    protected function assertDeleted(Payload $payload)
    {
        $this->assertSame(Payload::STATUS_DELETED, $payload->getStatus());
    }

    protected function assertError(Payload $payload)
    {
        $this->assertSame(Payload::STATUS_ERROR, $payload->getStatus());
    }

    protected function assertFound(Payload $payload)
    {
        $this->assertSame(Payload::STATUS_FOUND, $payload->getStatus());
    }

    protected function assertNew(Payload $payload)
    {
        $this->assertSame(Payload::STATUS_NEW, $payload->getStatus());
    }

    protected function assertNotFound(Payload $payload)
    {
        $this->assertSame(Payload::STATUS_NOT_FOUND, $payload->getStatus());
    }

    protected function assertNotValid(Payload $payload)
    {
        $this->assertSame(Payload::STATUS_NOT_VALID, $payload->getStatus());
    }

    protected function assertUpdated(Payload $payload)
    {
        $this->assertSame(Payload::STATUS_UPDATED, $payload->getStatus());
    }

    public function testFetchPage()
    {
        $payload = $this->domain->fetchPage(1);
        $this->assertFound($payload);

        $blogs = $payload->getResult()['blogs'];
        $this->assertInstanceOf(BlogRecordSet::CLASS, $blogs);
        $this->assertCount(3, $blogs);

        $this->assertEquals(1, $blogs[0]->id);
        $this->assertEquals(2, $blogs[1]->id);
        $this->assertEquals(3, $blogs[2]->id);
    }

    public function testFetchPost()
    {
        $payload = $this->domain->fetchPost(0);
        $this->assertNotFound($payload);

        $payload = $this->domain->fetchPost(1);
        $this->assertFound($payload);

        $blog = $payload->getResult()['blog'];
        $this->assertInstanceOf(BlogRecord::CLASS, $blog);
        $this->assertEquals(1, $blog->id);
    }

    public function testNewPost()
    {
        $payload = $this->domain->newPost();
        $this->assertNew($payload);

        $blog = $payload->getResult()['blog'];
        $this->assertInstanceOf(BlogRecord::CLASS, $blog);
        $this->assertNull($blog->id);
    }

    public function testCreatePost()
    {
        $data = [
            'title' => 'Added title',
            'author' => 'Added author',
            'intro' => 'Added intro',
            'body' => 'Added body',
        ];

        $payload = $this->domain->addPost($data);

        $this->assertCreated($payload);

        $blog = $payload->getResult()['blog'];
        $this->assertInstanceOf(BlogRecord::CLASS, $blog);
        $this->assertEquals(4, $blog->id);
    }

    public function testCreatePost_notValid()
    {
        $data = [
            'author' => 'Added author',
            'intro' => 'Added intro',
            'body' => 'Added body',
        ];

        $payload = $this->domain->addPost($data);
        $this->assertNotValid($payload);

        $messages = $payload->getResult()['messages'];
        $this->assertSame('Title cannot be empty.', $messages['title']);
    }

    public function testEditPost()
    {
        $payload = $this->domain->editPost(1, [
            'title' => 'Changed title',
        ]);

        $this->assertUpdated($payload);

        $blog = $payload->getResult()['blog'];
        $this->assertInstanceOf(BlogRecord::CLASS, $blog);
        $this->assertEquals(1, $blog->id);
        $this->assertEquals('Changed title', $blog->title);
    }

    public function testEditPost_notFound()
    {
        $payload = $this->domain->editPost(0, [
            'title' => 'Changed title',
        ]);

        $this->assertNotFound($payload);
    }

    public function testEditPost_notValid()
    {
        $payload = $this->domain->editPost(1, [
            'title' => '',
        ]);

        $this->assertNotValid($payload);

        $blog = $payload->getResult()['blog'];
        $this->assertInstanceOf(BlogRecord::CLASS, $blog);
        $this->assertEquals(1, $blog->id);
    }

    public function testDeletePost()
    {
        $payload = $this->domain->deletePost(1);
        $this->assertDeleted($payload);
    }

    public function testDeletePost_notFound()
    {
        $payload = $this->domain->deletePost(0);
        $this->assertNotFound($payload);
    }

    public function testServiceError()
    {
        $this->pdo->exec("DROP TABLE blog");
        $payload = $this->domain->fetchPage(1);
        $this->assertError($payload);
    }
}
