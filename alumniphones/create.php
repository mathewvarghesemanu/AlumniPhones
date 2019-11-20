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
include_once '../objects/product.php';

$database = new Database();
$db = $database->getConnection();

$alumniphones = new alumniphones($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));

// make sure data is not empty
if(
    !empty($data->ID) &&
    !empty($data->assignflag) &&
    !empty($data->callcompleteflag) &&
    !empty($data->volunteermailid) &&
    !empty($data->volunteerbatch) &&
    !empty($data->operation)
){

 if ($data->operation=="getinitiallist")   
 {
    $count=0;
    $times=0;
    while($count<10 && $times<18000)
    {

        $stmt = $alumniphones->read();
        if ($alumniphones->assignflag==0 && $alumniphones->callcompleteflag==0)
        {
            $alumniphones->assignflag==1;
            $alumniphones->update();
            $count=$count+1;
            $times=$times+1;
        }
    }
}
elseif ($data->operation=="updatecallstatus") 
{
  $alumniphones->callcompleteflag==1;
  $alumniphones->callcompleted();
}
elseif ($data->operation=="getcompletedlist") 
{
    $stmt = $alumniphones->read();
    if ($alumniphones->assignflag==1 && $alumniphones->callcompleteflag==1 && $alumniphones->volunteermailid==$data->volunteermailid)
    {
        $stmt = $alumniphones->read();
        $num = $stmt->rowCount();
        
// check if more than 0 record found
        if($num>0){
           
    // alumniphones array
            $alumniphones_arr=array();
            $alumniphones_arr["records"]=array();
            
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
                );
                
                array_push($alumniphones_arr["records"], $alumniphones_item);
            }
            
    // set response code - 200 OK
            http_response_code(200);
            
    // show products data in json format
            echo json_encode($alumniphones_arr);
        }
    }




    $product->name = $data->name;
    $product->price = $data->price;
    $product->description = $data->description;
    $product->category_id = $data->category_id;
    $product->created = date('Y-m-d H:i:s');

    // create the product
    if($product->create()){

        // set response code - 201 created
        http_response_code(201);

        // tell the user
        echo json_encode(array("message" => "Product was created."));
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