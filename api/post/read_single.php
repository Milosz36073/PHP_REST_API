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

    //get ID from URL
    $post->id = isset($_GET['id']) ? $_GET['id'] : die();

    $post->read_single();

    //create array
    $post_item = array(
        'id' => $post->id,
        'title' => $post->title,
        'body' => html_entity_decode($post->body),
        'author' => $post->author,
        'category_id' => $post->category_id,
        'category_name' => $post->category_name
    );

    //Make JSON
    print_r(json_encode($post_item));

?>