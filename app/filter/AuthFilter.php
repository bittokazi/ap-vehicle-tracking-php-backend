<?php
namespace App\Filters;

use Core\Filter;
use Core\Response;
use Core\URL;
use Core\Request;
// use App\Controllers\Backend\Menu;
// use App\Models\User;
use \Firebase\JWT\JWT;

class AuthFilter extends Filter {
    public $role;
    public $access=false;
    public $title='Not Found';
    public function index($data) {
        header("Access-Control-Allow-Origin: *");
        $decoded = null;
        foreach (getallheaders() as $name => $value) { 
            if($name=="auth-token") {
                $key = "example_key";
                try {
                    $decoded = JWT::decode($value, $key, array('HS256'));
                } catch(\Exception $e) {
                }
            }
        }
        if($decoded==null) {
            Response::setStatusCode(401);
            $response->error = "Authentication Failed";
            echo json_encode($response);
            exit;
        }
        return $data;
    }
    function check_access($menu) {
        // foreach($menu as $m) {
        //     if($m['link']==URL::current_url()){
        //         $this->title=$m['title'];
        //         break;
        //     }
        //     if(isset($m['submenu'])) {
        //         $this->check_access($m['submenu']);
        //     }
        // }
    }
}
?>