<?php
namespace App\Models\Accounting;

use Core\Model;
use Core\Auth;
use Core\Modules\ORM\ORM;

class Invoice extends ORM {
    public $table_name = "invoices";
    public $id;
    public $serial_number;
    public $total_curtoon;
    public $start_counter;
    public $end_counter;
    public $created_at;
    public $counterStartEntity = 'App\\Models\\Counter';
    public $counterEndEntity = 'App\\Models\\Counter';

    public function mapCounterStartEntity() {
        $relationMetaData = new \stdClass();
        $relationMetaData->table = 'counters';
        $relationMetaData->mapFrom = 'start_counter';
        $relationMetaData->mapTo = 'id';
        $relationMetaData->relation = "OneToOne";
        $relationMetaData->fetchType = "eager";
        $relationMetaData->property = "counterStartEntity";
        $relationMetaData->saveRelation = false;
        return $relationMetaData;
    }

    public function mapCounterEndEntity() {
        $relationMetaData = new \stdClass();
        $relationMetaData->table = 'counters';
        $relationMetaData->mapFrom = 'end_counter';
        $relationMetaData->mapTo = 'id';
        $relationMetaData->relation = "OneToOne";
        $relationMetaData->fetchType = "eager";
        $relationMetaData->property = "counterEndEntity";
        $relationMetaData->saveRelation = false;
        return $relationMetaData;
    }
}
?>
