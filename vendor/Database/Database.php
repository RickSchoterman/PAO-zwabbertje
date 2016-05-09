<?php

class Database {

    protected $config;

    protected $connection;

    protected $vendorLocator;

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

    public function inject(Main $main) {
        $vendorLocator = $main->getLocator('vendor');
        $this->setVendorLocator($vendorLocator);
    }

    public function prepare() {
        $this->getVendorLocator()->attach('Mvc', array($this),
            function($self, $database) {
                $serviceLocator = $self->getServiceLocator();
                $serviceLocator->add('Database', $database);
                $self->setServiceLocator($serviceLocator);

                return $self;
            }
        );
    }

    public function __call($name, $arguments) {
        $name = strtolower($name);
        $method = substr($name, 0, 3);
        $table = substr($name, 3, strlen($name));

        $result = $this->query($table, $arguments[0]);

        $sqlResult = array();
        foreach($result as $key => $record) {
            $sqlResult[] = new Entity($record);
        }

        if(count($sqlResult) == 1) {
            $sqlResult = $sqlResult[0];
        }

        if(count($sqlResult) == 0) {
            $sqlResult = null;
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

                $query .= '`'.$field.'` = "'.$value.'"';

                $first = false;
            }
        }

        return $query;
    }

    public function sql($query) {
        $result = mysqli_query($this->getConnection(), $query);

        $data = array();

        $i=0;
        while($content = mysqli_fetch_array($result)){
            $data[$i] = $content;
            $i++;
        }

        return $data;
    }

    /**
     * @return mixed
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param mixed $config
     */
    public function setConfig($config)
    {
        $this->config = $config;
    }

    /**
     * @return mixed
     */
    public function getVendorLocator()
    {
        return $this->vendorLocator;
    }

    /**
     * @param mixed $vendorLocator
     */
    public function setVendorLocator($vendorLocator)
    {
        $this->vendorLocator = $vendorLocator;
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