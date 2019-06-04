<?php
namespace App\Models\Accounting;

use Core\Model;
use Core\Auth;
use Core\Modules\ORM\ORM;

class Memo extends ORM {
    public $table_name = "memos";
    public $id;
    public $memo_number;
    public $quantity;
    public $sender;
    public $sender_cell;
    public $sender_address;
    public $receiver;
    public $receiver_cell;
    public $receiver_address;
    public $description;
    public $memo_type;
    public $total_amount;
    public $comments;
    public $created_at;
    public $amountEntity = 'App\\Models\\Accounting\\Amount';

    public function mapAmountEntity() {
        $relationMetaData = new \stdClass();
        $relationMetaData->table = 'amounts';
        $relationMetaData->mapFrom = 'id';
        $relationMetaData->mapTo = 'memo_id';
        // $relationMetaData->mapFromMT = 'id';
        // $relationMetaData->mapToET = 'task_id';
        $relationMetaData->relation = "OneToMany";
        $relationMetaData->fetchType = "eager";
        $relationMetaData->property = "amountEntity";
        $relationMetaData->saveRelation = true;
        return $relationMetaData;
    }
}
?>
