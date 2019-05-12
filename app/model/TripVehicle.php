<?php
namespace App\Models;

use Core\Model;
use Core\Auth;
use Core\Modules\ORM\ORM;

class TripVehicle extends ORM {
    public $table_name = "trip_vehicle";
    public $id;
    public $trip_id;
    public $vehicle_id;
}
?>
