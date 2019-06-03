<?php
namespace Database;

use Core\Database;
    
class DBChangeLog_3_vehicle_distance extends Database {
    public function install() {
        //$this->query('ALTER TABLE vehicles ADD COLUMN distance INT(11)');
        $this->query('CREATE TABLE drivers (
            id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(1000) NOT NULL,
            mobile_number VARCHAR(255),
            driving_license VARCHAR(1000)
            )');
    }
    public function seed() {
        
    }
    public function uninstall() {
        $this->query('DROP TABLE drivers');
    }
}
?>