<?php
namespace Pmjones\Adr\Domain\Blog;

use Pmjones\Adr\DataSource\Blog\BlogRecord;

class BlogFilter
{
    protected $messages = [];

    public function getMessages() : array
    {
        return $this->messages;
    }

    public function forInsert(BlogRecord $record) : bool
    {
        $this->messages = [];
        return $this->basic($record);
    }

    public function forUpdate(BlogRecord $record) : bool
    {
        $this->messages = [];

        $record->id = (int) $record->id;
        if (! $record->id) {
            $this->messages['id'] = 'ID cannot be empty.';
        }

        return $this->basic($record);
    }

    protected function basic(BlogRecord $record) : bool
    {
        $record->author = trim($record->author);
        if (! $record->author) {
            $this->messages['author'] = 'Author cannot be empty.';
        }

        $record->title = trim($record->title);
        if (! $record->title) {
            $this->messages['title'] = 'Title cannot be empty.';
        }

        $record->body = trim($record->body);
        if (! $record->body) {
            $this->messages['body'] = 'Body cannot be empty.';
        }

        return $this->isValid();
    }

    protected function isValid() : bool
    {
        return count($this->messages) == 0;
    }
}
