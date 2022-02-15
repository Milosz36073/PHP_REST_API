<?php 
    // Headers
    header('Acces-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once('../../config/Database.php');
    include_once('../../models/Category.php');

    //Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    //Instatiate blog category object
    $category = new Category($db);

    $result = $category->read();
    $num = $result->rowCount();

    if($num>0){
        $cat_arr = array();
        $cat_arr['data']= array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $cat_item = array(
                'id' => $id,
                'name' => $name,
                'created_at' => $created_at
            );
            array_push($cat_arr['data'], $cat_item);
        }
        echo json_encode($cat_arr['data']);

    }else{
        echo "There is no data";
    }

    
?>
