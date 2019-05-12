<?php
namespace App\Controllers\Backend;

use Core\Controller;
use Core\Request;
use Core\Response;
use Core\Validation;
use Core\Auth;
use App\Models\Vehicle;

class VehicleController extends Controller {

    function __construct() {
        $this->vehicle = new Vehicle();
    }
  
    public function index() {
        $this->view()->json($this->vehicle->findAll());
    }

    public function addVehicle($data) {
        $response->success = true;
        if(Validation::notEmptyArray($data->requestBody)) {
            Response::setStatusCode(412);
            $response->success = false;
            $response->error = array('Empty Fields');
        } else {
            $vehicle = $data->requestBody;
            if($this->vehicle->add($vehicle)) {
                $response->success = true;
            } else {
                Response::setStatusCode(412);
                $error = array();
                if($this->vehicle->where('title', $data->requestBody->title)->find()) $error[] = 'Vehicle Already Exist';
                $this->vehicle = new Vehicle();
                if($this->vehicle->where('registration_number', $data->requestBody->registration_number)->find()) $error[] = 'Vehicle Registration Already Exist';
                $response->success = false;
                $response->error = $error;
            }
        }
        $this->view()->json($response);
    }


}

?>