<?php
namespace App\Models;

use Core\Model;
use Core\Auth;
use Core\Modules\ORM\ORM;

class User extends ORM {
    public $table_name = "user";
    public $id;
    public $firstname;
    public $lastname;
    public $username;
    public $email;
    public $role;
    public $status;
    public $device_uid;
    public $counter_id;
    public $roleEntity = 'App\\Models\\Role';
    public $userStatusEntity = 'App\\Models\\UserStatus';
    public $userCounterEntity = 'App\\Models\\Counter';


    public function mapRoleEntity() {
        $relationMetaData = new \stdClass();
        $relationMetaData->table = 'user_role';
        $relationMetaData->mapFrom = 'role';
        $relationMetaData->mapTo = 'id';
        $relationMetaData->relation = "OneToOne";
        $relationMetaData->fetchType = "eager";
        $relationMetaData->property = "roleEntity";
        return $relationMetaData;
    }

    public function mapUserStatusEntity() {
        $relationMetaData = new \stdClass();
        $relationMetaData->table = 'user_status';
        $relationMetaData->mapFrom = 'status';
        $relationMetaData->mapTo = 'id';
        $relationMetaData->relation = "OneToOne";
        $relationMetaData->fetchType = "eager";
        $relationMetaData->property = "userStatusEntity";
        return $relationMetaData;
    }

    public function mapUserCounterEntity() {
        $relationMetaData = new \stdClass();
        $relationMetaData->table = 'counters';
        $relationMetaData->mapFrom = 'counter_id';
        $relationMetaData->mapTo = 'id';
        $relationMetaData->relation = "OneToOne";
        $relationMetaData->fetchType = "eager";
        $relationMetaData->property = "userCounterEntity";
        return $relationMetaData;
    }

    public function hideProperties() {
      return ['password'];
    }
}
?>
