<?php

// get ID of the product to be read
$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');
 
// include database and object files
include_once 'config/database.php';
include_once 'objects/product.php';
include_once 'objects/category.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare objects

$category = new Category($db);
 
// set ID property of product to be read
$category->id = $id;
 
// read the details of product to be read
$category->readOne();


$page_title = "Read One Product";
include_once "layout_header.php";
 



// read products button
echo "<div class='right-button-margin'>";
    echo "<a href='index_cat.php' class='btn btn-primary pull-right'>";
        echo "<span class='glyphicon glyphicon-list'></span> Read Categorie";
    echo "</a>";
echo "</div>";


// HTML table for displaying a product details
echo "<table class='table table-hover table-responsive table-bordered'>";
 
    echo "<tr>";
        echo "<td>Name</td>";
        echo "<td>{$category->name}</td>";
        echo "<td>{$category->description}</td>";
        
    echo "</tr>";
 
   
echo "</table>";

// set footer
include_once "layout_footer.php";
?>