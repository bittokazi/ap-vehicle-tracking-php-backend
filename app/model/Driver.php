<?php
namespace App\Models;

use Core\Model;
use Core\Auth;
use Core\Modules\ORM\ORM;

class Driver extends ORM {
    public $table_name = "drivers";
    public $id;
    public $name;
    public $mobile_number;
    public $driving_license;
}
?>
