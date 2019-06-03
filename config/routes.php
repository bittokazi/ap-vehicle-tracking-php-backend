<?php
Routes::get('Frontend/FrontPageController', '/');

//User Controller
Routes::get('Backend/UserController', '/user', 'AuthFilter');
Routes::post('Backend/UserController#addUserResource', '/user', 'AuthFilter');

//Role Controller
Routes::get('Backend/RoleController', '/role', 'AuthFilter');

//UserStatus Controller
Routes::get('Backend/UserStatusController', '/user-status', 'AuthFilter');

//CounterController Controller
Routes::get('Backend/CounterController', '/counter', 'AuthFilter');
Routes::post('Backend/CounterController#addCounter', '/counter', 'AuthFilter');

//VehicleController Controller
Routes::get('Backend/VehicleController', '/vehicle', 'AuthFilter');
Routes::post('Backend/VehicleController#addVehicle', '/vehicle', 'AuthFilter');
Routes::get('Backend/VehicleController#vehicleWithOnGoingTrips', '/vehicle/and/task', 'AuthFilter');

//TripController Controller
Routes::get('Backend/TripController', '/trip', 'AuthFilter');
Routes::post('Backend/TripController#addTrip', '/trip', 'AuthFilter');
Routes::get('Backend/TripController#fromCounter', '/trip/from/counter/?id', 'AuthFilter');
Routes::get('Backend/TripController#toCounter', '/trip/to/counter/?id', 'AuthFilter');
Routes::get('Backend/TripController#counterTraffic', '/trip/traffic/counter/?id', 'AuthFilter');

//TaskController Controller
Routes::get('Backend/TaskController', '/task', 'AuthFilter');
Routes::get('Backend/TaskController#allTaskPage', '/task/page/?p', 'AuthFilter');
Routes::post('Backend/TaskController#addTask', '/task', 'AuthFilter');
Routes::get('Backend/TaskController#taskWithCounterId', '/task/counter/?id', 'AuthFilter');
Routes::get('Backend/TaskController#taskWithCounterIdPage', '/task/counter/?id/page/?p', 'AuthFilter');
Routes::get('Backend/TaskController#findByTaskIdAndCounterId', '/task/?taskId/counter/?id', 'AuthFilter');
Routes::get('Backend/TaskController#getTask', '/task/?id', 'AuthFilter');
Routes::get('Backend/TaskController#confirmTrip', '/task/confirm/trip/?id', 'AuthFilter');
Routes::get('Backend/TaskController#leftConfirm', '/task/confirm/left/trip/?id', 'AuthFilter');
Routes::post('Backend/TaskController#addTripToTask', '/task/add/trip', 'AuthFilter');

//LoginController Controller
Routes::post('Backend/LoginController#index', '/login');

//Driver Controller
Routes::get('Backend/DriverController#addDriver', '/driver', 'AuthFilter');
Routes::post('Backend/DriverController#addDriver', '/driver', 'AuthFilter');
?>
