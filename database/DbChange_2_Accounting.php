<?php
namespace Database;

use Core\Database;
    
class DbChange_2_Accounting extends Database {
    public function install() {
        $this->query('CREATE TABLE memos (
            id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            memo_number INT(11) NOT NULL,
            quantity INT(11) NOT NULL,
            sender VARCHAR(255),
            sender_cell VARCHAR(255),
            sender_address VARCHAR(1000),
            receiver VARCHAR(255),
            receiver_cell VARCHAR(1000),
            receiver_address VARCHAR(1000),
            description VARCHAR(1000),
            memo_type INT(11) NOT NULL,
            total_amount INT(11) NOT NULL,
            comments VARCHAR(1000),
            created_at DATETIME
            )');
        $this->query('CREATE TABLE invoices (
            id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            serial_number INT(11) NOT NULL,
            total_curtoon INT(11) NOT NULL,
            start_counter INT(11) NOT NULL,
            end_counter INT(11) NOT NULL,
            created_at DATETIME
            )');
        $this->query('CREATE TABLE amounts (
            id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            memo_id INT(11) NOT NULL,
            calculate BOOLEAN,
            amount INT(11) NOT NULL,
            created_at DATETIME
            )');
    }
    public function seed() {
        
    }
    public function uninstall() {
        $this->query('DROP TABLE memos');
        $this->query('DROP TABLE invoices');
    }
}
?>