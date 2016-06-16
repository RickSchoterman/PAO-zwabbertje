<?php

namespace Database;

use Database\Entity;
use MongoDB\Driver\Query;

class Repository
{
    protected $employ;
    protected $table;

    public function __construct($employ, $table) {
        $this->employ = $employ;
        $this->table = $table;
    }

    public function findBy($criteria) {
        return $this->find($criteria);
    }

    public function findOneBy($criteria) {
        $result = $this->find($criteria);

        if(empty($result)) {
            return null;
        }

        return $result[0];
    }

    private function find($criteria) {
        $queryBuilder = new QueryBuilder();
        $query = $queryBuilder->find($this->table, $criteria);

        $result = $this->employ->execute($query);

        $sqlResult = array();
        foreach ($result as $key => $record) {
            $sqlResult[] = new Entity($this->table, $record);
        }

        return $sqlResult;
    }
}

?>