<?php

namespace Snowdog\DevTest\Model;

use Snowdog\DevTest\Core\Database;

class PageManager
{

    /**
     * @var Database|\PDO
     */
    private $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function getAllByWebsite(Website $website)
    {
        $websiteId = $website->getWebsiteId();
        /** @var \PDOStatement $query */
        $query = $this->database->prepare('SELECT * FROM pages WHERE website_id = :website');
        $query->bindParam(':website', $websiteId, \PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_CLASS, Page::class);
    }

    public function create(Website $website, $url)
    {
        $websiteId = $website->getWebsiteId();
        /** @var \PDOStatement $statement */
        $statement = $this->database->prepare('INSERT INTO pages (url, website_id) VALUES (:url, :website)');
        $statement->bindParam(':url', $url, \PDO::PARAM_STR);
        $statement->bindParam(':website', $websiteId, \PDO::PARAM_INT);
        $statement->execute();
        return $this->database->lastInsertId();
    }

    public function updateDateTimePage($hostname, $url)
    {

        $statement = $this->database->prepare('SELECT website_id from websites where hostname = :hostname');
        $statement->bindParam(':hostname', $hostname, \PDO::PARAM_STR);
        $statement->execute();

        $websiteId = $statement->fetchColumn();

        //if ($websiteId !== NULL) {

            $dateTime = new \DateTime('NOW');
            $dateFormat = $dateTime->format('Y-m-d H:i:s');
            $statement = $this->database->prepare('UPDATE pages set date_time_last_view = :now where url = :url AND website_id = :websiteId');
            $statement->bindParam(':now', $dateFormat, \PDO::PARAM_STR);
            $statement->bindParam(':url', $url, \PDO::PARAM_STR);
            $statement->bindParam(':websiteId', $websiteId, \PDO::PARAM_INT);
            $statement->execute();

            return $statement->rowCount();
        //}

    }
}
