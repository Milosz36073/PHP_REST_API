<?php 
    // Headers
    header('Acces-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once('../../config/Database.php');
    include_once('../../models/Post.php');

    //Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    //Instatiate blog post object
    $post = new Post($db);

    //get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    $post->id = $data->id;

    if($post->delete()){
        echo json_encode(
                array('message' => 'Post Deleted')
            );
    }else{
        echo json_encode(
            array('message' => 'Post Not Deleted')
        );
    }

?>