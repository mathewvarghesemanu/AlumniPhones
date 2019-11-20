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
    !empty($data->alumniname) &&
    !empty($data->alumnibatch) &&
    !empty($data->alumniphone) &&
    !empty($data->assignflag) &&
    !empty($data->callcompleteflag) &&
    !empty($data->volunteername) &&
    !empty($data->volunteermailid) &&
    !empty($data->volunteerbatch) &&
    !empty($data->ID)
)
{
    $alumniphones->alumniname = $data->alumniname;
    $alumniphones->alumnibatch = $data->alumnibatch;
    $alumniphones->alumniphone = $data->alumniphone;
    $alumniphones->assignflag = $data->assignflag;
    $alumniphones->callcompleteflag = $data->callcompleteflag;
    $alumniphones->volunteername = $data->volunteername;
    $alumniphones->volunteermailid = $data->volunteermailid;
    $alumniphones->volunteerbatch = $data->volunteerbatch;
    $alumniphones->ID = $data->ID;
// echo json_encode($alumniphones_arr);
    // create the product
    if($alumniphones->create()){

        // set response code - 201 created
        http_response_code(201);

        // tell the user
        echo json_encode(array("message" => "alumni was created."));
    }

    // if unable to create the product, tell the user
    else{

        // set response code - 503 service unavailable
        http_response_code(503);

        // tell the user
        echo json_encode(array("message" => "Unable to create product."));
    }
}

// tell the user data is incomplete
else{

    // set response code - 400 bad request
    http_response_code(400);

    // tell the user
    echo json_encode(array("message" => "Unable to create product. Data is incomplete."));
}


?>



