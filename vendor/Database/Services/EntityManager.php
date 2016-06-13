<?php

namespace Database\Services;

use Database\Entity;
use Database\Repository;
use Library\EmployModel;
use Main\Locator;

class EntityManager {

    protected $connection;

    public function __construct() {

    }

    public function inject(EmployModel $employ) {
        $this->connection = $employ->getConnection();
    }

    public function getRepository($table) {
        return new Repository($this->connection, $table);
    }

    
}

?>