<?php
namespace App\Models\Accounting;

use Core\Model;
use Core\Auth;
use Core\Modules\ORM\ORM;

class Amount extends ORM {
    public $table_name = "amounts";
    public $id;
    public $memo_id;
    public $calculate;
    public $amount;
    public $created_at;
}
?>
