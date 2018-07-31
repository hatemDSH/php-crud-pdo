
<?php
class Category{
 
    // database connection and table name
    private $conn;
    private $table_name = "categories";
 
    // object properties
    public $id;
    public $name;
    public $description;
 
    public function __construct($db){
        $this->conn = $db;
    }
 
    // used by select drop-down list
    function read(){
        //select all data
        $query = "SELECT
                    id, name,description
                FROM
                    " . $this->table_name . "
                ORDER BY
                    name";  
 
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
 
        return $stmt;
    }

    // used to read category name by its ID
    function readName(){
     
    $query = "SELECT name,description FROM " . $this->table_name . " WHERE id = ? limit 0,1";
 
    $stmt = $this->conn->prepare( $query );
    $stmt->bindParam(1, $this->id);
    $stmt->execute();
 
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
     
     return $this->name = $row['name'];
}
 

function create(){
    
    // insert query
     $query = "INSERT INTO 
                " . $this->table_name . "
            SET
                name=:name, description=:description, created=:created";

    $stmt = $this->conn->prepare($query);

    // posted values
    $this->name=htmlspecialchars(strip_tags($this->name));
    $this->description=htmlspecialchars(strip_tags($this->description));


    // to get time-stamp for 'created' field
    $this->timestamp = date('Y-m-d H:i:s');

    // bind values 
    $stmt->bindParam(":name", $this->name);
    $stmt->bindParam(":created", $this->timestamp);
    $stmt->bindParam(":description", $this->description);

    if($stmt->execute()){
        return true;
    }else{
        return false;
    }

}

function readAll($from_record_num, $records_per_page){

    $query = "SELECT
                id, name,description
            FROM
                " . $this->table_name . "
            ORDER BY
                name ASC
            LIMIT
                {$from_record_num}, {$records_per_page}";
 
    $stmt = $this->conn->prepare( $query );
    $stmt->execute();
 
    return $stmt;
} 

// used for paging products
public function countAll(){

    $query = "SELECT id FROM " . $this->table_name . "";

   $stmt = $this->conn->prepare( $query );
   $stmt->execute();

   $num = $stmt->rowCount();

   return $num;

}

function readOne(){

     $query = "SELECT
            name,description
        FROM
            " . $this->table_name . "
        WHERE
            id = ?
        LIMIT
            0,1";

    $stmt = $this->conn->prepare( $query );
    $stmt->bindParam(1, $this->id);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

   $this->name = $row['name'];
   $this->description = $row['description'];


}
 

function update(){

    $query = "UPDATE
                " . $this->table_name . "
            SET
                name = :name,
                description = :description
            WHERE
                id = :id";
 
    $stmt = $this->conn->prepare($query);
 
    // posted values
    $this->name=htmlspecialchars(strip_tags($this->name));
    $this->name=htmlspecialchars(strip_tags($this->description));
    $this->id=htmlspecialchars(strip_tags($this->id));

 
    // bind parameters
    $stmt->bindParam(':name', $this->name);
    $stmt->bindParam(':description', $this->description);
    $stmt->bindParam(':id', $this->id);
 
    // execute the query
    if($stmt->execute()){
        return true;
    }
 
    return false;
     
}

// delete the product
 function delete(){

     $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
 
     $stmt = $this->conn->prepare($query);
     $stmt->bindParam(1, $this->id);

     if($result = $stmt->execute()){
        return true;
     }else{
      return false;
  }
}

// read products by search term
public function search($search_term, $from_record_num, $records_per_page){

   // select query
    $query = "SELECT
            name, description 
        FROM
            " . $this->table_name . " p
           
        WHERE
            name LIKE ? 
        ORDER BY
            name ASC
        LIMIT
            ?, ?";

    // prepare query statement
    $stmt = $this->conn->prepare( $query );

    // bind variable values
    $search_term = "%{$search_term}%";
    $stmt->bindParam(1, $search_term);
    $stmt->bindParam(2, $from_record_num, PDO::PARAM_INT);
    $stmt->bindParam(3, $records_per_page, PDO::PARAM_INT);

    // execute query
    $stmt->execute();

   // return values from database
   return $stmt;
}

public function countAll_BySearch($search_term){

// select query
$query = "SELECT
            COUNT(*) as total_rows
        FROM
            " . $this->table_name . " 
        WHERE
            c.name LIKE ?";

// prepare query statement
$stmt = $this->conn->prepare( $query );

// bind variable values
$search_term = "%{$search_term}%";
$stmt->bindParam(1, $search_term);

$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

return $row['total_rows'];
} 

}
?>