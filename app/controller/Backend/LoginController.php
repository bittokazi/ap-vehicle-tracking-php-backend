<?php
namespace App\Controllers\Backend;

use Core\Controller;
use Core\Request;
use Core\Response;
use Core\Validation;
use Core\Auth;
use App\Models\User;
use \Firebase\JWT\JWT;

class LoginController extends Controller {

    function __construct() {
        $this->user = new User();
    }
  
    public function index($data) {
        $response->success = true;
        $user = $this->user
                ->where('username', $data->requestBody->username)
                ->w_and('password', Auth::CryptBf($data->requestBody->password))
                ->find();
        
        if($user!=null) {
            $key = AUTH_KEY;
            $token = array(
                "iss" => "http://example.org",
                "aud" => "http://example.com",
                "iat" => 1356999524
            );
            $jwt = JWT::encode($token, $key);
            $response->token = $jwt;
            $response->user = $user;
            $this->user = new User();
            foreach($this->user->where('device_uid', $data->requestBody->deviceId)->findAll() as $userCheck) {
                $this->user = new User();
                $userRemoveDid->id = $userCheck->id;
                $userRemoveDid->device_uid = null;
                $this->user->sync($userRemoveDid);
            }
            $this->user = new User();
            $userUpdated->id = $user->id;
            $userUpdated->device_uid = $data->requestBody->deviceId;
            $this->user->sync($userUpdated);
        } else {
            Response::setStatusCode(401);
            $error = array();
            $error[] = "Username or Password Do not Match";
            $response->success = false;
            $response->error = $error;
            $response->data = $data->requestBody;
        }
        $this->view()->json($response);
    }

}

?>
