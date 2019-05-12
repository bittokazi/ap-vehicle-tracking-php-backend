<?php
namespace App\Controllers\Backend;

use Core\Controller;
use Core\Request;
use Core\Response;
use Core\Validation;
use Core\Auth;
use App\Models\UserStatus;

class UserStatusController extends Controller {

    function __construct() {
        $this->userStatus = new UserStatus();
    }
  
    public function index() {
        $this->view()->json($this->userStatus->findAll());
    }
    
}

?>