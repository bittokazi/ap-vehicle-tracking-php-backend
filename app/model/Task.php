<?php
namespace App\Models;

use Core\Model;
use Core\Auth;
use Core\Modules\ORM\ORM;

class Task extends ORM {
    public $table_name = "tasks";
    public $id;
    public $title;
    public $start_counter;
    public $end_counter;
    public $vehicle_id;
    public $completed;
    public $description;
    public $created_at;
    public $driver_id;
    public $tripEntity = 'App\\Models\\Trip';
    public $taskVehicleEntity = 'App\\Models\\Vehicle';
    public $taskDriverEntity = 'App\\Models\\Driver';
    public $counterStartEntity = 'App\\Models\\Counter';
    public $counterEndEntity = 'App\\Models\\Counter';

    public function mapTripEntity() {
        $relationMetaData = new \stdClass();
        $relationMetaData->table = 'trips';
        $relationMetaData->mapFrom = 'id';
        $relationMetaData->mapTo = 'task_id';
        $relationMetaData->mapFromMT = 'id';
        $relationMetaData->mapToET = 'task_id';
        $relationMetaData->relation = "OneToMany";
        $relationMetaData->fetchType = "eager";
        $relationMetaData->property = "tripEntity";
        $relationMetaData->saveRelation = true;
        return $relationMetaData;
    }

    public function mapTaskVehicleEntity() {
        $relationMetaData = new \stdClass();
        $relationMetaData->table = 'vehicles';
        $relationMetaData->mapFrom = 'vehicle_id';
        $relationMetaData->mapTo = 'id';
        $relationMetaData->relation = "OneToOne";
        $relationMetaData->fetchType = "eager";
        $relationMetaData->property = "taskVehicleEntity";
        $relationMetaData->saveRelation = false;
        return $relationMetaData;
    }

    public function mapTaskDriverEntity() {
        $relationMetaData = new \stdClass();
        $relationMetaData->table = 'drivers';
        $relationMetaData->mapFrom = 'driver_id';
        $relationMetaData->mapTo = 'id';
        $relationMetaData->relation = "OneToOne";
        $relationMetaData->fetchType = "eager";
        $relationMetaData->property = "taskDriverEntity";
        $relationMetaData->saveRelation = false;
        return $relationMetaData;
    }

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
