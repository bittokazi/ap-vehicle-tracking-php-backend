<?php
namespace App\Controllers\Backend;

use Core\Controller;
use Core\Request;
use Core\Response;
use Core\Validation;
use Core\Auth;
use App\Models\Driver;

class DriverController extends Controller {

    function __construct() {
        $this->driver = new Driver();
    }
  
    public function index() {
        $this->view()->json($this->driver->findAll());
    }

    public function addDriver($data) {
        $response->success = true;
        if(Validation::notEmptyArray($data->requestBody)) {
            Response::setStatusCode(412);
            $response->success = false;
            $response->error = array('Empty Fields');
        } else {
            $counter = $data->requestBody;
            if($this->driver->add($counter)) {
                $response->success = true;
            } else {
                Response::setStatusCode(412);
                $error = array();
                $error[] = 'Unknown Error Occured';
                $response->success = false;
                $response->error = $error;
            }
        }
        $this->view()->json($response);
    }

}

?>