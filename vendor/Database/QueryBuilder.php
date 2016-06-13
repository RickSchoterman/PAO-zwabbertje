<?php

namespace Database;

class QueryBuilder
{
    public function create(Entity $entity) {
        $query = 'INSERT INTO `' . $entity->tableName . '`';

        $indexes = '';
        $values = '';

        foreach($entity->__properties() as $index => $value) {
            if($indexes != '') {
                $indexes .= ', ';
            }

            $indexes = '`' . $index . '`';

            if($values == '') {
                $values = '"' . $value . '"';
            } else {
                $values .= ', "' . $value . '"';
            }
        }

        $query .=  ' (' . $indexes . ') VALUES (' . $values . ')';

        return $query;
    }

    public function find($table, $criteria) {
        $query = 'SELECT * FROM `'.$table.'`';

        $query .= $this->buildQuery($criteria);

        return $query;
    }

    public function update(Entity $entity) {
        $query = 'UPDATE `' . $entity->tableName . '`';

        $updateString = '';
        foreach($entity->__properties() as $index => $value) {
            if($updateString != '') {
                $updateString .= ', ';
            }

            $updateString .= '`' . $index . '`="' . $value . '"';
        }

        $query .= ' SET ' . $updateString . ' ' . $this->buildQuery(array('id' => $entity->getId()));

        return $query;
    }

    public function remove(Entity $entity) {
        $query = 'DELETE FROM `' . $entity->tableName . '`';

        $query .= $this->buildQuery($entity->__properties());

        return $query;
    }

    protected function buildQuery($criteria) {
        $query = '';

        if($criteria) {
            $query .= ' WHERE ';

            $first = true;
            foreach($criteria as $field => $value) {
                if(!$first) {
                    $query .= ' AND ';
                }

                if($value instanceof Entity) {
                    if(!$field) {
                        $field = $this->createTableName($value->tableName);
                    }

                    $query .= '`'.$field.'_id` = "'.$value->getId().'"';
                } else {
                    $query .= '`'.$field.'` = "'.$value.'"';
                }

                $first = false;
            }
        }

        return $query;
    }

    protected function createTableName($name) {
        $tableName = '';
        $first = true;
        for($i=0; $i<strlen($name); $i++) {
            $char = $name[$i];

            if($first) {
                $tableName .= strtolower($char);
                $first = false;
                continue;
            }

            if(ctype_upper($char)) {
                $tableName .= '_'.strtolower($char);
            } else {
                $tableName .= $char;
            }
        }

        return $tableName;
    }
}

?>