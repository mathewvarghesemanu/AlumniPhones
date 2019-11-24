<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// get database connection
include_once '../config/database.php';

// instantiate product object
include_once '../objects/alumniphones.php';

$database = new Database();
$db = $database->getConnection();

$alumniphones = new alumniphones($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));
echo json_encode($data);
// make sure data is not empty
if(
    
    !empty($data->ID)
)
{
   
    $alumniphones->callcompleteflag = $data->callcompleteflag;
    $alumniphones->ID = $data->ID;
// echo json_encode($alumniphones_arr);
    // updatecallstatus the product
    if($alumniphones->updatecallstatus()){

        // set response code - 201 updatecallstatusd
        http_response_code(201);

        // tell the user
        echo json_encode(array("message" => "alumni was updatecallstatusd."));
    }

    // if unable to updatecallstatus the product, tell the user
    else{

        // set response code - 503 service unavailable
        http_response_code(503);

        // tell the user
        echo json_encode(array("message" => "Unable to updatecallstatus product."));
    }
}

// tell the user data is incomplete
else{

    // set response code - 400 bad request
    http_response_code(400);

    // tell the user
    echo json_encode(array("message" => "Unable to updatecallstatus product. Data is incomplete."));
}


?>



