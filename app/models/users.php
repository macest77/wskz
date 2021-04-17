<?php

include 'functions.php';

class Users
{
    private $login;
    private $password;
    private $first_name;
    private $last_name;
    private $sex;
    private $pdo;
    private $error_messages;
    private $update_fields = array('password', 'first_name',
                    'last_name', 'sex');
    
    public function __construct()
    {
        $functions = new Functions();
        $this->pdo = $functions->create_pdo($config);
        $this->error_messages = array();
        
        return true;
    }
    
    private function isValid(array $data) : bool
    {
        //need to do validation - login must have at least 6 letters (strlen() > 6)
        //passwords must be the same
        return true;
    }
    
    public function insert(array $data)
    {
        if ($this->isValid($data) ) {
            try {
                $sql = 'INSERT INTO users
                    VALUES (login = ?, password = ?, first_name = ?,
                    last_name = ?, sex = ?)';
        
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([$data['login'], password_hash($data['password'], PASSWORD_DEFAULT),
                    $data['first_name'], $data['last_name'], $data['sex']]);
                    
            } catch (PDOException $e) {
                $this->selectByLogin($data);
                
                if ($this->login != '') {
                    $updates = array();
                    
                    foreach($this->update_fields as $field) {
                        
                        if ($field == 'password')
                            $data[$field] = password_hash($data['password'], PASSWORD_DEFAULT);
                     
                        if ($data[$field] != $this->{$field})
                            $updates[$field] = $data[$field];
                    }
                    if ( count($updates) > 0 ) {
                        
                        $sql = 'UPDATE users SET ';
                        
                        foreach( $updates as $field_name => $field_value) {
                            $sql .= $field_name.' = :'.$field_name.',';
                        }
                        $sql = substr($sql,0,-1);
                        
                        $stmt = $this->pdo->prepare($sql);
                        $stmt->execute($updates);
                    }
                } else {
                    $this->error_messages[] = 'Error inserting data';
                }
            }
        }
    }
    
    public function selectByLogin(array $data)
    {
        $sql = 'SELECT * fROM users
                    WHERE login = ?';
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$data['login']]);
        while ($row = $stmt->fetch() ) {
            $this->login = $row['login'];
            $this->password = $row['password'];
            $this->first_name = $row['first_name'];
            $this->last_name = $row['last_name'];
            $this->sex = $row['sex'];
        }
    }
    
    public function getErrorMessages() : array
    {
        if ( count($this->error_messages) > 0 )
            return $this->error_messages;
        
        return null;
    }
    
    public function getSessionUserData() : array
    {
        return array('login'=>$this->login,
                        'password'=>$this->password);
    }
}

/*create table wskz_users (
login VARCHAR(20) PRIMARY KEY,
password VARCHAR(50) NOT NULL,
first_name VARCHAR(30) NOT NULL,
last_name VARCHAR(50) NOT NULL,
sex enum('M', 'K')) CHARACTER SET utf8 collate utf8_general_ci

*/
