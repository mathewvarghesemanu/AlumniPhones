<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/alumniphones.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$alumniphones = new alumniphones($db);
 
// query products
$stmt = $alumniphones->read();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // alumniphones array
    $alumniphones_arr=array();
    $alumniphones_arr["alumni"]=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $alumniphones_item=array(
            "alumniname" => $alumniname,
            "alumnibatch" => $alumnibatch,
            "alumniphone" => $alumniphone,
            "assignflag" => $assignflag,
            "callcompleteflag" => $callcompleteflag,
            "volunteername" => $volunteername,
            "volunteermailid" => $volunteermailid,
            "volunteerbatch" => $volunteerbatch,
            "ID" => $ID,

        );
 
        array_push($alumniphones_arr["alumni"], $alumniphones_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show products data in json format
    echo json_encode($alumniphones_arr);
}
 
else{
 
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no products found
    echo json_encode(
        array("message" => "No entries found.")
    );
}