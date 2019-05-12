<?php
namespace Database;

use Core\Database;
use Core\Auth;
    
class DbChageInit extends Database {
    public function install() {
        $this->query('CREATE TABLE user (
            id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(255) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL UNIQUE,
            firstname VARCHAR(30),
            lastname VARCHAR(30),
            status VARCHAR(30),
            role VARCHAR(30),
            device_uid VARCHAR(255),
            counter_id INT(11)
            )');

        $this->query('CREATE TABLE user_status (
                id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                title VARCHAR(255) NOT NULL UNIQUE
                )');

        $this->query('CREATE TABLE user_role (
                id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                title VARCHAR(255) NOT NULL UNIQUE
                )');
        
        $this->query('CREATE TABLE counters (
            id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NOT NULL UNIQUE,
            district VARCHAR(255) NOT NULL
            )');

        $this->query('CREATE TABLE vehicles (
            id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NOT NULL UNIQUE,
            registration_number VARCHAR(255) NOT NULL UNIQUE
            )');
    }
    public function seed() {
        $username = $_ENV['DEFAULT_USERNAME'];
        $password = Auth::CryptBf($_ENV['DEFAULT_PASSWORD']);
        $this->query("INSERT INTO user_status VALUES(NULL, 'Active')");
        $this->query("INSERT INTO user_status VALUES(NULL, 'Inactive')");
        $this->query("INSERT INTO user_role VALUES(NULL, 'Administrator')");
        $this->query("INSERT INTO user_role VALUES(NULL, 'Manager')");
        $this->query("INSERT INTO user VALUES(NULL, '".$username."', '".$password."', 'bitto.kazi@gmail.com', 'N/A', 'N/A', '1', '1', NULL, NULL)");
        //$this->query("INSERT INTO user VALUES(NULL, 'user', '".Auth::CryptBf('password')."', 'bitto.kazi1@gmail.com', 'N/A',  'N/A', '1', '2')");
    }
    public function uninstall() {
        $this->query('DROP TABLE user_status');
        $this->query('DROP TABLE user_role');
        $this->query('DROP TABLE user');
        $this->query('DROP TABLE counters');
        $this->query('DROP TABLE vehicles');
    }
}
?>