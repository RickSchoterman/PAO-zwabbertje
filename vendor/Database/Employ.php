<?php

namespace Database;

use Library\EmployInterface;
use Library\EmployModel;
use Main\Main;

class Employ extends EmployModel implements EmployInterface {

    protected $connection;

    public function __construct($config) {
        $this->setConfig($config);

        $connection = mysqli_connect(
            $config['connection']['server'],
            $config['connection']['username'],
            $config['connection']['password'],
            $config['connection']['database']
        );

        if(mysqli_connect_errno()) {
            die(mysqli_connect_error());
        }

        $this->setConnection($connection);
    }

    public function prepare() {

    }

    public function execute($query, $reponse = true) {
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

    /**
     * @return mixed
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * @param mixed $connection
     */
    public function setConnection($connection)
    {
        $this->connection = $connection;
    }
}

?>