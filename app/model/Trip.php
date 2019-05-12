<?php
namespace App\Models;

use Core\Model;
use Core\Auth;
use Core\Modules\ORM\ORM;

class Trip extends ORM {
    public $table_name = "trips";
    public $id;
    public $task_id;
    public $order_number;
    public $created_at;
    public $left_at;
    public $description;
    public $tripFromCounterEntity = 'App\\Models\\Counter';
    public $tripToCounterEntity = 'App\\Models\\Counter';
    public $tripVehicleEntity = 'App\\Models\\Vehicle';
    public $taskEntity = 'App\\Models\\Task';


    public function mapToCounterEntity() {
        $relationMetaData = new \stdClass();
        $relationMetaData->table = 'trip_to_counter';
        $relationMetaData->mapFrom = 'id';
        $relationMetaData->mapTo = 'trip_id';
        $relationMetaData->mapFromMT = 'counter_id';
        $relationMetaData->mapToET = 'id';
        $relationMetaData->relation = "ManyToMany";
        $relationMetaData->fetchType = "eager";
        $relationMetaData->property = "tripToCounterEntity";
        $relationMetaData->saveRelation = false;
        return $relationMetaData;
    }

    public function mapFromCounterEntity() {
        $relationMetaData = new \stdClass();
        $relationMetaData->table = 'trip_from_counter';
        $relationMetaData->mapFrom = 'id';
        $relationMetaData->mapTo = 'trip_id';
        $relationMetaData->mapFromMT = 'counter_id';
        $relationMetaData->mapToET = 'id';
        $relationMetaData->relation = "ManyToMany";
        $relationMetaData->fetchType = "eager";
        $relationMetaData->property = "tripFromCounterEntity";
        $relationMetaData->saveRelation = false;
        return $relationMetaData;
    }

    public function mapTripVehicleEntity() {
        $relationMetaData = new \stdClass();
        $relationMetaData->table = 'trip_vehicle';
        $relationMetaData->mapFrom = 'id';
        $relationMetaData->mapTo = 'trip_id';
        $relationMetaData->mapFromMT = 'vehicle_id';
        $relationMetaData->mapToET = 'id';
        $relationMetaData->relation = "ManyToMany";
        $relationMetaData->fetchType = "eager";
        $relationMetaData->property = "tripVehicleEntity";
        $relationMetaData->saveRelation = false;
        return $relationMetaData;
    }

    public function mapTaskEntity() {
        $relationMetaData = new \stdClass();
        $relationMetaData->table = 'tasks';
        $relationMetaData->mapFrom = 'task_id';
        $relationMetaData->mapTo = 'id';
        $relationMetaData->relation = "OneToOne";
        $relationMetaData->fetchType = "break";
        $relationMetaData->property = "taskEntity";
        $relationMetaData->saveRelation = false;
        return $relationMetaData;
    }
}
?>
