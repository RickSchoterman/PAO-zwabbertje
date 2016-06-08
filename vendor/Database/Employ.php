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