<?php

class Functions
{

    public function create_pdo(array $config) : new PDO()
    {
        $dsn = "mysql:host=".$config['database']['host'].";dbname=".$config['database']['dbname'].";charset=".$config['database']['charset'];
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        try {
             return new PDO($dsn, $config['database']['username'], $config['database']['password'], $options);
        } catch (\PDOException $e) {
             throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

}
