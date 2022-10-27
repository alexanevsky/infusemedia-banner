<?php

class Db
{
    private const DB_DSN = 'mysql:host=db;dbname=views';
    private const DB_USERNAME = 'root';
    private const DB_PASSWORD = 'secret';

    private \PDO $pdo;

    public function __construct()
    {
        $this->pdo = new \PDO(self::DB_DSN, self::DB_USERNAME, self::DB_PASSWORD);
    }

    public function write(?string $ipAddress, ?string $userAgent, ?string $pageUrl): void
    {
        $this->pdo->beginTransaction();

        $sql = $this->pdo->prepare('SELECT * FROM views WHERE ip_address = :ip_address AND user_agent = :user_agent AND page_url = :page_url');
        $sql->execute([
            ':ip_address'   => $ipAddress,
            ':user_agent'   => $userAgent,
            ':page_url'     => $pageUrl,
        ]);

        $row = $sql->fetch(\PDO::FETCH_ASSOC);

        if (!$row) {
            $sql = $this->pdo->prepare('INSERT INTO views (ip_address, user_agent, page_url, view_date, views_count) VALUES (:ip_address, :user_agent, :page_url, CURRENT_TIMESTAMP, 1)');
            $sql->execute([
                ':ip_address'   => $ipAddress,
                ':user_agent'   => $userAgent,
                ':page_url'     => $pageUrl,
            ]);
        } else {
            $sql = $this->pdo->prepare('UPDATE views SET view_date = CURRENT_TIMESTAMP, views_count = views_count + 1 WHERE id = :id');
            $sql->execute([':id' => $row['id']]);
        }

        $this->pdo->commit();
    }
}
