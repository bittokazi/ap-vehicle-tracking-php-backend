<?php
namespace App\Controllers\Backend;

use Core\Controller;
use Core\Request;
use Core\Response;
use Core\Validation;
use Core\Auth;
use App\Models\User;
use App\Models\Role;

class UserController extends Controller {

    function __construct() {
        $this->user = new User();
        $this->role = new Role();
    }
  
    public function index() {
        $this->view()->json($this->user->findAll());
    }

    public function addUserResource($data) {
        $response->success = true;
        if(Validation::notEmptyArray($data->requestBody)) {
            Response::setStatusCode(412);
            $response->success = false;
            $response->error = array('Empty Fields');
        } else {
            $user = $data->requestBody;
            $user->password = Auth::CryptBf($user->password);
            if($this->user->add($user)) {
                $response->success = true;
            } else {
                Response::setStatusCode(412);
                $error = array();
                if($this->user->where('username', Request::post('username'))->find()) $error[] = 'Username Already Exist';
                $this->user = new User();
                if($this->user->where('email', Request::post('email'))->find()) $error[] = 'Email Already Exist';
                $response->success = false;
                $response->error = $error;
            }
        }
        $this->view()->json($response);
    }
}

?>