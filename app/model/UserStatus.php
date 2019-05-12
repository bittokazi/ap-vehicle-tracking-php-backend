<?php
namespace App\Models;

use Core\Model;
use Core\Auth;
use Core\Modules\ORM\ORM;

class UserStatus extends ORM {
    public $table_name = "user_status";
    public $id;
    public $title;
}
?>
