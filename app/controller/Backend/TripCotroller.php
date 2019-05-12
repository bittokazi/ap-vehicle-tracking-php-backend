<?php
namespace App\Controllers\Backend;

use Core\Controller;
use Core\Request;
use Core\Response;
use Core\Validation;
use Core\Auth;
use App\Models\Trip;
use App\Models\Counter;

class TripController extends Controller {

    function __construct() {
        $this->trip = new Trip();
        $this->counter = new Counter();
    }
  
    public function index() {
        $this->view()->json($this->trip->findAll());
    }

    public function addTrip($data) {
        $response->success = true;
        $trip = $data->requestBody;
        $trip->created_at = date("Y-m-d H:i:s");
        if($insertedId = $this->trip->save($trip)) {
            $response->success = true;
        } else {
            Response::setStatusCode(412);
            $error = array();
            $response->success = false;
            $response->error = $error;
        }
        $this->view()->json($response);
    }

    public function fromCounter($data) {
        $response->success = true;
        $response->trips = $this->trip
                                ->innerJoin('trip_from_counter', 'id', 'trip_id')
                                ->innerJoin('counters', 'counter_id', 'id', 'trip_from_counter')
                                // ->order('user.id', 'DESC')
                                ->where('counters.id', $data->id)
                                ->findAll();
        $this->view()->json($response); 
    }

    public function toCounter($data) {
        $response->success = true;
        $response->trips = $this->trip
                                ->innerJoin('trip_to_counter', 'id', 'trip_id')
                                ->innerJoin('counters', 'counter_id', 'id', 'trip_to_counter')
                                // ->order('user.id', 'DESC')
                                ->where('counters.id', $data->id)
                                ->findAll();
        $this->view()->json($response); 
    }

    public function counterTraffic($data) {
        $response->success = true;
        $response->trips = $this->trip
                                ->innerJoin('trip_to_counter', 'id', 'trip_id')
                                ->innerJoin('counters', 'counter_id', 'id', 'trip_to_counter')
                                ->innerJoin('trip_from_counter', 'id', 'trip_id')
                                ->where('counters.id', $data->id)
                                ->order('trips.id', 'DESC')
                                ->findAll();
        $this->view()->json($response); 
    }

}

?>