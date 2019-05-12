<?php
namespace App\Models;

use Core\Model;
use Core\Auth;
use Core\Modules\ORM\ORM;

class TripFromCounter extends ORM {
    public $table_name = "trip_from_counter";
    public $id;
    public $trip_id;
    public $counter_id;
}
?>
