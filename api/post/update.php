<?php 
    // Headers
    header('Acces-Control-Allow-Origin: *');
    header('Content-Type: application/json'); 
    header('Access-Control-Allow_Methods: PUT'); 
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow_Methods, Authorization, X-Requested-With'); 

    include_once('../../config/Database.php');
    include_once('../../models/Post.php');

    //Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    //Instatiate blog post object
    $post = new Post($db);

    //get raw posted data
    $data = json_decode(file_get_contents("php://input"));


    $post->title = $data->title;
    $post->body = $data->body;
    $post->author = $data->author;
    $post->category_id = $data->category_id;
    $post->id = $data->id;
    //update Post
    if($post->update()){
        echo json_encode(
                array('message' => 'Post Updated')
            );
    }else{
        echo json_encode(
            array('message' => 'Post Not Updated')
        );
    }
?>