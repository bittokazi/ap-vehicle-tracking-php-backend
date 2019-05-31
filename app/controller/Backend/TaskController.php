<?php
namespace App\Controllers\Backend;

use Core\Controller;
use Core\Request;
use Core\Response;
use Core\Validation;
use Core\Auth;
use App\Models\Task;
use App\Models\Counter;
use App\Models\Trip;
use App\Models\User;
use App\Models\Vehicle;

use yidas\googleMaps\Client;

class TaskController extends Controller {

    function __construct() {
        $this->task = new Task();
        $this->trip = new Trip();
        $this->user = new User();
        $this->vehicle = new Vehicle();
        $this->gmaps = new \yidas\googleMaps\Client(['key'=>'AIzaSyAKHP7ldSVRMVy16w-f1gr0E8jPNtY5DHI']);
    }

    public function index() {
        $this->view()->json($this->task->findAll());
    }

    public function allTaskPage($data) {
        $this->view()->json($this->task->order('completed', 'ASC')->limit($data->p*10, 10)->findAll());
    }

    public function getLocation() {
        $gmaps = new \yidas\googleMaps\Client(['key'=>'AIzaSyAKHP7ldSVRMVy16w-f1gr0E8jPNtY5DHI']);

        //$result = $gmaps->geocode('Dhaka');

        $distanceMatrixResult = $gmaps->distanceMatrix('Dhaka', 'Rajshahi');

        $this->view()->json($distanceMatrixResult);
    }

    public function taskWithCounterId($data) {
        $trip = $this->trip
                        ->innerJoin('trip_to_counter', 'id', 'trip_id', 'trips')
                        ->innerJoin('counters', 'counter_id', 'id', 'trip_to_counter')
                        ->innerJoin('tasks', 'task_id', 'id', 'trips')
                        ->where('counters.id', $data->id)
                        ->findAll();
        $this->view()->json($trip);
    }

    public function taskWithCounterIdPage($data) {
        $trip = $this->trip
                        ->innerJoin('trip_to_counter', 'id', 'trip_id', 'trips')
                        ->innerJoin('counters', 'counter_id', 'id', 'trip_to_counter')
                        ->innerJoin('tasks', 'task_id', 'id', 'trips')
                        ->where('counters.id', $data->id)
                        ->order('tasks.completed', 'ASC')
                        ->limit($data->p*10, 10)
                        ->findAll();
        $this->view()->json($trip);
    }

    public function findByTaskIdAndCounterId($data) {
        $trip = $this->trip
                        ->innerJoin('trip_to_counter', 'id', 'trip_id', 'trips')
                        ->innerJoin('counters', 'counter_id', 'id', 'trip_to_counter')
                        ->where('counters.id', $data->id)
                        ->w_and('trips.task_id', $data->taskId)
                        ->find();
        $this->view()->json($trip);
    }

    public function addTask($data) {
        $response->success = true;
        $task = $data->requestBody;
        $task->created_at = date("Y-m-d H:i:s");
        if($insertedId = $this->task->save($task)) {
            $response->success = true;
            $notification = "New Task Added";
            $this->sendNotification($notification);
        } else {
            Response::setStatusCode(412);
            $error = array();
            $response->success = false;
            $response->error = $error;
        }
        $this->view()->json($response);
    }

    public function getTask($data) {
        $task = $this->task->where('id', $data->id)->find();
        usort($task->tripEntity,function($first,$second){
            return $first->order_number > $second->order_number;
        });
        $distance = 0;
        foreach ($task->tripEntity as $key => $value) {
            if($key>0) {
                $distance += $this->gmaps->distanceMatrix($task->tripEntity[$key-1]->tripToCounterEntity[0]->title, $value->tripToCounterEntity[0]->title)
                              ['rows'][0]['elements'][0]['distance']['value'];
            }
            $value->tripToCounterEntity[0]->location = $this->gmaps->geocode($value->tripToCounterEntity[0]->title)[0]['geometry']['location'];
        }
        $task->distance = round($distance/1000);
        $this->view()->json($task);
    }

    public function confirmTrip($data) {
        $trip = new \StdClass;
        $trip->id = $data->id;
        $trip->created_at = date("Y-m-d H:i:s");
        $this->trip->sync($trip);
        $this->task = new Task();
        $this->trip = new Trip();

        $trip1 = $this->trip->where('id', $data->id)->find();

        if($trip1->tripToCounterEntity[0]->id==$this->task->where('id', $trip1->task_id)->find()->counterEndEntity->id) {
            $task = new \StdClass;
            $this->task = new Task();
            $this->trip = new Trip();
            $task->id = $trip1->task_id;
            $task->completed = 1;
            $this->task->sync($task);


            $this->task = new Task();
            $task = $this->task->where('id', $trip1->task_id)->find();
            $vehicle = $this->vehicle->where('id', $task->vehicle_id)->find();
            $distance = 0;
            foreach ($task->tripEntity as $key => $value) {
                if($key>0) {
                    $distance += $this->gmaps->distanceMatrix($task->tripEntity[$key-1]->tripToCounterEntity[0]->title, $value->tripToCounterEntity[0]->title)
                                    ['rows'][0]['elements'][0]['distance']['value'];
                }
            }
            if($vehicle->distance == null) {
                $vehicle->distance = round($distance/1000);
            } else {
                $vehicle->distance = $vehicle->distance + round($distance/1000);
            }
            $this->vehicle = new Vehicle();
            $this->vehicle->sync($vehicle);

            $v = $trip1->tripVehicleEntity[0]->title;
            $notification = "Task Ended for Vehicle #$v";
            $this->sendNotification($notification);
        }
        $this->task = new Task();
        $this->trip = new Trip();
        $task = $this->task->where('id', $this->trip->where('id', $data->id)->find()->task_id)->find();
        usort($task->tripEntity,function($first,$second){
            return $first->order_number > $second->order_number;
        });
        $v = $task->taskVehicleEntity->title;
        $d = $trip1->tripToCounterEntity[0]->title;
        $notification = "Vehicle #$v Reached #$d";
        $this->sendNotification($notification);

        $distance = 0;
        foreach ($task->tripEntity as $key => $value) {
            if($key>0) {
                $distance += $this->gmaps->distanceMatrix($task->tripEntity[$key-1]->tripToCounterEntity[0]->title, $value->tripToCounterEntity[0]->title)
                              ['rows'][0]['elements'][0]['distance']['value'];
            }
            $value->tripToCounterEntity[0]->location = $this->gmaps->geocode($value->tripToCounterEntity[0]->title)[0]['geometry']['location'];
        }
        $task->distance = round($distance/1000);
        $this->view()->json($task);
    }

    public function leftConfirm($data) {
        $trip = new \StdClass;
        $trip->id = $data->id;
        $trip->left_at = date("Y-m-d H:i:s");
        $this->trip->sync($trip);
        $this->trip = new Trip();
        $trip1 = $this->trip->where('id', $data->id)->find();

        $this->task = new Task();
        $this->trip = new Trip();
        $task = $this->task->where('id', $this->trip->where('id', $data->id)->find()->task_id)->find();
        usort($task->tripEntity,function($first,$second){
            return $first->order_number > $second->order_number;
        });
        $v = $task->taskVehicleEntity->title;
        $d = $trip1->tripToCounterEntity[0]->title;
        $notification = "Vehicle #$v left #$d";
        $this->sendNotification($notification);

        $distance = 0;
        foreach ($task->tripEntity as $key => $value) {
            if($key>0) {
                $distance += $this->gmaps->distanceMatrix($task->tripEntity[$key-1]->tripToCounterEntity[0]->title, $value->tripToCounterEntity[0]->title)
                              ['rows'][0]['elements'][0]['distance']['value'];
            }
            $value->tripToCounterEntity[0]->location = $this->gmaps->geocode($value->tripToCounterEntity[0]->title)[0]['geometry']['location'];
        }
        $task->distance = round($distance/1000);
        $this->view()->json($task);
    }

    public function addTripToTask($data) {
        $task = $this->task->where('id', $data->requestBody->task_id)->find();
        usort($task->tripEntity,function($first,$second){
            return $first->order_number > $second->order_number;
        });

        $index = 0;
        foreach($task->tripEntity as $tripToUpdate) {
            $this->trip = new Trip();
            $updatedTripOrder = new \StdClass;
            $updatedTripOrder->id = $tripToUpdate->id;
            if($index==($data->requestBody->order_number*1+1)) {
                $index++;
            }
            $updatedTripOrder->order_number = $index;
            $this->trip->sync($updatedTripOrder);
            $index++;
        }

        $response->success = true;
        $trip = $data->requestBody;
        $trip->order_number = ($data->requestBody->order_number*1+1);
        $trip->created_at = date("Y-m-d H:i:s");
        if($insertedId = $this->trip->save($trip)) {
            $this->task = new Task();
            $response->success = true;
            $response->task = $this->task->where('id', $trip->task_id)->find();
            usort($response->task->tripEntity,function($first,$second){
                return $first->order_number > $second->order_number;
            });
            $this->trip = new Trip();
            $trip1 = $this->trip->where('id', $insertedId)->find();
            $v = $response->task->taskVehicleEntity->title;
            $d = $trip1->tripToCounterEntity[0]->title;
            $notification = "Vehicle #$v Reached #$d";
            $this->sendNotification($notification);

            $distance = 0;
            foreach ($response->task->tripEntity as $key => $value) {
                if($key>0) {
                    $distance += $this->gmaps->distanceMatrix($response->task->tripEntity[$key-1]->tripToCounterEntity[0]->title, $value->tripToCounterEntity[0]->title)
                                ['rows'][0]['elements'][0]['distance']['value'];
                }
                $value->tripToCounterEntity[0]->location = $this->gmaps->geocode($value->tripToCounterEntity[0]->title)[0]['geometry']['location'];
            }
            $response->task->distance = round($distance/1000);
        } else {
            Response::setStatusCode(412);
            $error = array();
            $response->success = false;
            $response->error = $error;
        }
        $this->view()->json($response);
    }

    public function sendNotification($body) {
        $expo = \ExponentPhpSDK\Expo::normalSetup();

        // Build the notification data
        $notification = ['body' => $body];

        foreach($this->user->findAll() as $user) {
            if($user->device_uid!=null) {
                $interestDetails = [$user->device_uid, $user->device_uid];
                // Subscribe the recipient to the server
                $expo->subscribe($interestDetails[0], $interestDetails[1]);
                // Notify an interest with a notification
                $expo->notify($interestDetails[0], $notification);
            }
        }

    }

}
?>
