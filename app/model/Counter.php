<?php
namespace App\Models;

use Core\Model;
use Core\Auth;
use Core\Modules\ORM\ORM;

class Counter extends ORM {
    public $table_name = "counters";
    public $id;
    public $title;
    public $district;
}