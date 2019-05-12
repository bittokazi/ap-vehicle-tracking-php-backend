<?php
namespace App\Controllers\Backend;

use Core\Controller;
use Core\Request;
use Core\Response;
use Core\Validation;
use Core\Auth;
use App\Models\Counter;

class CounterController extends Controller {

    function __construct() {
        $this->counter = new Counter();
    }
  
    public function index() {
        $this->view()->json($this->counter->findAll());
    }

    public function addCounter($data) {
        $response->success = true;
        if(Validation::notEmptyArray($data->requestBody)) {
            Response::setStatusCode(412);
            $response->success = false;
            $response->error = array('Empty Fields');
        } else {
            $counter = $data->requestBody;
            if($this->counter->add($counter)) {
                $response->success = true;
            } else {
                Response::setStatusCode(412);
                $error = array();
                if($this->counter->where('title', $data->requestBody->title)->find()) $error[] = 'Counter Already Exist';
                $response->success = false;
                $response->error = $error;
            }
        }
        $this->view()->json($response);
    }

}

?>