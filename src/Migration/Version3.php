<?php

namespace Snowdog\DevTest\Migration;

use Snowdog\DevTest\Core\Database;

class Version3
{
    /**
     * @var Database|\PDO
     */
    private $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function __invoke()
    {
        $this->addColumnPageTable();
    }

    private function addColumnPageTable()
    {
        $query = <<<SQL
            alter table `pages` add `date_time_last_view` datetime;
SQL;
       $this->database->exec($query);

    }


}
