<?php
namespace Pmjones\Adr\DataSource\Blog;

class BlogRecord
{
    protected $id;
    protected $author;
    protected $title;
    protected $intro;
    protected $body;

    public function __construct(array $data = [])
    {
        $this->setData($data);
    }

    /**
     * @return mixed
     */
    public function __get(string $key)
    {
        return $this->$key;
    }

    public function __set(string $key, $val)
    {
        $this->$key = $val;
    }

    public function setData(array $data = []) : void
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }

    public function getData() : array
    {
        $properties = get_object_vars($this);
        return $properties;
    }
}
