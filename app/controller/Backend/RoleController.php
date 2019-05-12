<?php
namespace App\Controllers\Backend;

use Core\Controller;
use Core\Request;
use Core\Response;
use Core\Validation;
use Core\Auth;
use App\Models\Role;

class RoleController extends Controller {

    function __construct() {
        $this->role = new Role();
    }
  
    public function index() {
        $this->view()->json($this->role->findAll());
    }

}

?>