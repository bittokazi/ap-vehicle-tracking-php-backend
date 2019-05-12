<?php
namespace App\Models;

use Core\Model;
use Core\Auth;
use Core\Modules\ORM\ORM;

class Role extends ORM {
    public $table_name = "user_role";
    public $id;
    public $title;
}
?>
