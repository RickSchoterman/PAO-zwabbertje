<?php

namespace Database\Services;

use Database\Entity;
use Library\EmployModel;
use Main\Locator;

class EntityManager {

    protected $connection;

    public function __construct() {

    }

    public function inject(EmployModel $employ) {
        $this->connection = $employ->getConnection();
    }

    public function __call($name, $arguments) {
        $name = strtolower($name);
        $table = substr($name, 3, strlen($name));

        $result = $this->query($table, $arguments[0]);

        $sqlResult = array();
        foreach($result as $key => $record) {
            $sqlResult[] = new Entity($table, $record);
        }

        if(count($sqlResult) == 1) {
            $sqlResult = $sqlResult[0];
        }

        return $sqlResult;
    }

    public function query($table, $arguments) {
        $query = $this->buildQuery($table, $arguments);
        return $this->sql($query);
    }

    public function buildQuery($table, $arguments) {
        $query = 'SELECT * FROM `'.$table.'`';

        if($arguments) {
            $query .= ' WHERE ';

            $first = true;
            foreach($arguments as $field => $value) {
                if(!$first) {
                    $query .= ' AND ';
                }

                if(is_object($value)) {
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

    public function sql($query) {
        $result = mysqli_query($this->connection, $query);

        $data = array();

        $i=0;
        while($content = mysqli_fetch_array($result)){
            $data[$i] = $content;
            $i++;
        }

        return $data;
    }

    public function createTableName($name) {
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