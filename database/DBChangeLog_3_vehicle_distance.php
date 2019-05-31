<?php
namespace Database;

use Core\Database;
    
class DBChangeLog_3_vehicle_distance extends Database {
    public function install() {
        $this->query('ALTER TABLE vehicles ADD COLUMN distance INT(11)');
    }
    public function seed() {
        
    }
    public function uninstall() {
        
    }
}
?>