<?php
namespace Pmjones\Adr\Domain\Blog;

use Pmjones\Adr\DataSource\Blog\BlogMapper;
use Pmjones\Adr\Domain\ApplicationService;
use Pmjones\Adr\Domain\Payload;
use Exception;

class BlogService extends ApplicationService
{
    protected $mapper;
    protected $filter;

    public function __construct(
        BlogMapper $mapper,
        BlogFilter $filter
    ) {
        $this->mapper = $mapper;
        $this->filter = $filter;
    }

    protected function fetchPage(int $page = 1, int $paging = 10) : Payload
    {
        $blogs = $this->mapper->selectAllByPage($page, $paging);

        return $this->newPayload(Payload::STATUS_FOUND, [
            'blogs' => $blogs,
        ]);
    }

    protected function fetchPost(int $id) : Payload
    {
        $blog = $this->mapper->selectOneById($id);

        if ($blog === null) {
            return $this->newPayload(Payload::STATUS_NOT_FOUND, [
                'id' => $id
            ]);
        }

        return $this->newPayload(Payload::STATUS_FOUND, [
            'blog' => $blog
        ]);
    }

    protected function newPost(array $data = []) : Payload
    {
        return $this->newPayload(Payload::STATUS_NEW, [
            'blog' => $this->mapper->newRecord($data)
        ]);
    }

    protected function addPost(array $data) : Payload
    {
        // instantiate a new record
        $blog = $this->mapper->newRecord($data);

        // validate the record
        if (! $this->filter->forInsert($blog)) {
            return $this->newPayload(Payload::STATUS_NOT_VALID, [
                'blog' => $blog,
                'messages' => $this->filter->getMessages()
            ]);
        }

        // insert the record
        $this->mapper->insert($blog);
        return $this->newPayload(Payload::STATUS_CREATED, [
            'blog' => $blog,
        ]);
    }

    protected function editPost(int $id, array $data) : Payload
    {
        // fetch the record
        $blog = $this->mapper->selectOneById($id);
        if ($blog === null) {
            return $this->newPayload(Payload::STATUS_NOT_FOUND, [
                'id' => $id
            ]);
        }

        // set data in the record; do not overwrite existing $id
        unset($data['id']);
        $blog->setData($data);

        // validate the record
        if (! $this->filter->forUpdate($blog)) {
            return $this->newPayload(Payload::STATUS_NOT_VALID, [
                'blog' => $blog,
                'messages' => $this->filter->getMessages()
            ]);
        }

        // update the record
        $this->mapper->update($blog);
        return $this->newPayload(Payload::STATUS_UPDATED, [
            'blog' => $blog,
        ]);
    }

    protected function deletePost(int $id) : Payload
    {
        // fetch the record
        $blog = $this->mapper->selectOneById($id);
        if (! $blog) {
            return $this->newPayload(Payload::STATUS_NOT_FOUND, [
                'id' => $id
            ]);
        }

        // delete the record
        $this->mapper->delete($blog);
        return $this->newPayload(Payload::STATUS_DELETED, [
            'blog' => $blog,
        ]);
    }
}
