<?php
namespace Pmjones\Adr\DataSource\Blog;

use PDO;

class BlogMapper
{
    protected $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function newRecord(array $row) : BlogRecord
    {
        return new BlogRecord($row);
    }

    public function newRecordSet(array $rows) : BlogRecordSet
    {
        $records = [];
        foreach ($rows as $row) {
            $records[] = $this->newRecord($row);
        }
        return new BlogRecordSet($records);
    }

    public function selectOneById(int $id) : ?BlogRecord
    {
        $stm = 'SELECT * FROM blog WHERE id = :id';
        $sth = $this->pdo->prepare($stm);
        $sth->execute(['id' => $id]);

        $row = $sth->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return $this->newRecord($row);
        }

        return null;
    }

    public function selectAllByPage(
        int $page = 1,
        int $paging = 10
    ) : BlogRecordSet {

        $offset = ($page - 1) * $paging;

        $stm = "SELECT * FROM blog LIMIT {$paging} OFFSET {$offset}";
        $sth = $this->pdo->prepare($stm);
        $sth->execute();

        $rows = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $this->newRecordSet($rows);
    }

    public function insert(BlogRecord $record) : bool
    {
        $stm = 'INSERT INTO blog (
            author,
            title,
            intro,
            body
        ) VALUES (
            :author,
            :title,
            :intro,
            :body
        )';

        $sth = $this->pdo->prepare($stm);
        $sth->execute([
            'author' => $record->author,
            'title' => $record->title,
            'intro' => $record->intro,
            'body' => $record->body,
        ]);

        $affected = (bool) $sth->rowCount();
        if ($affected > 0) {
            $record->id = $this->pdo->lastInsertId();
        }

        return $affected;
    }

    public function update(BlogRecord $record) : bool
    {
        $stm = 'UPDATE blog SET
            author = :author,
            title = :title,
            intro = :intro,
            body = :body
        WHERE id = :id';

        $sth = $this->pdo->prepare($stm);
        $sth->execute($record->getData());

        return (bool) $sth->rowCount();
    }

    public function delete(BlogRecord $record) : bool
    {
        $stm = 'DELETE FROM blog WHERE id = :id';
        $sth = $this->pdo->prepare($stm);
        $sth->execute(['id' => $record->id]);
        return (bool) $sth->rowCount();
    }
}
