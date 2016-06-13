<?php

namespace Database;

use Database\Entity;
use MongoDB\Driver\Query;

class Repository
{
    protected $connection;
    protected $table;

    public function __construct($connection, $table) {
        $this->connection = $connection;
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

        return $result;
    }

    private function find($criteria) {
        $queryBuilder = new QueryBuilder();
        $query = $queryBuilder->find($this->table, $criteria);

        $result = $this->execute($query);

        $sqlResult = array();
        foreach ($result as $key => $record) {
            $sqlResult[] = new Entity($this->table, $record);
        }

        return $sqlResult;
    }

    public function remove(Entity $object){
        $queryBuilder = new QueryBuilder();
        $query = $queryBuilder->remove($object);

        $this->execute($query, false);
    }

    public function save(Entity $object){
        $queryBuilder = new QueryBuilder();

        $result = $this->findOneBy(array("id" => $object->getId()));

        if(!empty($result)){
            $queryBuilder->update($object);
        }else{
            $queryBuilder->create($object);
        }
    }

    private function execute($query, $reponse = true) {
        $result = mysqli_query($this->connection, $query);

        if(!$reponse) {
            return;
        }

        $data = array();

        $i=0;
        while($content = mysqli_fetch_array($result, MYSQLI_ASSOC)){
            $data[$i] = $content;
            $i++;
        }

        return $data;
    }
}

?>