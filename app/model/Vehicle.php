<?php
namespace App\Models;

use Core\Model;
use Core\Auth;
use Core\Modules\ORM\ORM;

class Vehicle extends ORM {
    public $table_name = "vehicles";
    public $id;
    public $title;
    public $registration_number;
    public $distance;
}
?>
