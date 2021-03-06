<?php
class Post{
    //DB stuff
    private $conn;
    private $table = 'posts';

    //Post properties
    public $id;
    public $category_id;
    public $category_name;
    public $title;
    public $body;
    public $author;
    public $created_at;

    public function __construct($db){
        $this->conn=$db;
    }

    public function read(){
        //create query
        $query = 'SELECT
                c.name as category_name,
                p.id,
                p.category_id,
                p.title,
                p.body,
                p.author,
                p.created_at
            FROM
            '. $this->table . ' p
            LEFT JOIN 
                categories c ON p.category_id = c.id
            ORDER BY 
                p.created_at DESC';

        // prepare statemnet
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function read_single(){
        $query = 'SELECT
                c.name as category_name,
                p.id,
                p.category_id,
                p.title,
                p.body,
                p.author,
                p.created_at
            FROM
            '. $this->table . ' p
            LEFT JOIN 
                categories c ON p.category_id = c.id
            WHERE 
                p.id=?';

        $stmt = $this->conn->prepare($query);

        //Bind id
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        // return $stmt;
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        //set properties
        $this->title = $row['title'];
        $this->body = $row['body'];
        $this->author = $row['author'];
        $this->category_id = $row['category_id'];
        $this->category_name = $row['category_name'];
    }

    //create Post
    public function create(){
        $query = 'INSERT INTO ' . $this->table .'(title, body, author, category_id)
        VALUES (?, ?, ?, ?)';
        $stmt = $this->conn->prepare($query);

        //clean data
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->body = htmlspecialchars(strip_tags($this->body));
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));

        // bind data
        $stmt->bindParam(1, $this->title);
        $stmt->bindParam(2, $this->body);
        $stmt->bindParam(3, $this->author);
        $stmt->bindParam(4, $this->category_id);

        //execute query
        // if($stmt->execute([$this->title, $this->body, $this->author, $this->category_id])){
        if($stmt->execute()){
            return true;
        }

        // print error if somethnig wrong
        printf("Error: %s.\n", $stmt->error);
        return false;

    }

    public function update(){
        $query = 'UPDATE ' . $this->table . ' SET title= :title, body= :body, author= :author, category_id = :category_id WHERE id= :id';
        $stmt = $this->conn->prepare($query);

        //clean data
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->body = htmlspecialchars(strip_tags($this->body));
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':body', $this->body);
        $stmt->bindParam(':author', $this->author);
        $stmt->bindParam(':category_id', $this->category_id);
        $stmt->bindParam(':id', $this->id);

        if($stmt->execute()){
            return true;
        }

        //print error
        printf("error: %s%.\n", $stmt->error);
        return false;
    }

    public function delete(){
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = ?';
        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));
        
        $stmt->bindParam(1, $this->id);
        
        if($stmt->execute()){
            return true;
        }

        // print error if somethnig wrong
        printf("Error: %s.\n", $stmt->error);
        return false;
    }
}

?>