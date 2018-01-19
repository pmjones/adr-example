<?php
namespace Pmjones\Adr;

use PDO;

class SqliteFixture
{
    static public function setup()
    {
        $pdo = new PDO('sqlite::memory:');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $pdo->exec("
            CREATE TABLE blog (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                author VARCHAR(64),
                title VARCHAR(128),
                intro VARCHAR(255),
                body TEXT
            );
        ");

        $sth = $pdo->prepare("
            INSERT INTO blog (id, author, title, intro, body)
            VALUES(:id, :author, :title, :intro, :body);
        ");

        for ($i = 1; $i <= 3; $i ++) {
            $sth->execute([
                'id' => null,
                'author' => "Author {$i}",
                'title' => "Title {$i}",
                'intro' => "Intro {$i}",
                'body' => "Body {$i}",
            ]);
        }

        return $pdo;
    }
}
