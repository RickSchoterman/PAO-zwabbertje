<?php

namespace Database\Services;

use Database\Entity;
use Database\QueryBuilder;
use Database\Repository;
use Library\EmployModel;
use Main\Locator;

class EntityManager {

    protected $employ;

    public function __construct() {

    }

    public function inject(EmployModel $employ) {
        $this->employ = $employ;
    }

    public function getRepository($table) {
        return new Repository($this->employ, $table);
    }

    public function remove(Entity $object){
        $queryBuilder = new QueryBuilder();
        $query = $queryBuilder->remove($object);

        $this->employ->execute($query, false);
    }

    public function save(Entity $object){
        $queryBuilder = new QueryBuilder();

        if($object->id) {
            $result = $this->getRepository($object->tableName)->findOneBy(array('id' => $object->getId()));
        }

        if(isset($result) && !empty($result)){
            $query = $queryBuilder->update($object);
            $this->employ->execute($query, false);
        } else {
            $query = $queryBuilder->create($object);
            $this->employ->execute($query, false);
        }
    }
}

?>