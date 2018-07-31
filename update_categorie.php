<?php
// get ID of the product to be edited
$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');
 
// include database and object files
include_once 'config/database.php';
include_once 'objects/category.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare objects
$category = new Category($db);
 
// set ID property of product to be edited
$category->id = $id;
 
// read the details of product to be edited
$category->readOne();
 
?>
<?php 


 
// set page header
$page_title = "Update Product";
include_once "layout_header.php";
 
echo "<div class='right-button-margin'>";
    echo "<a href='index_cat.php' class='btn btn-default pull-right'>Read Products</a>";
echo "</div>";

// if the form was submitted
if($_POST){
 
    // set product property values
    $category->name = $_POST['name'];
    $category->description = $_POST['description'];
   
 
    // update the product
    if($category->update()){
       //  echo $category->uploadPhoto();
        echo "<div class='alert alert-success alert-dismissable'>";
        echo "Product was updated.";
        echo "</div>";
        
      
    }
 
    // if unable to update the product, tell the user
    else{
        echo "<div class='alert alert-danger alert-dismissable'>";
            echo "Unable to update product.";
        echo "</div>";
    }
}


?>


<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}");?>" method="post">
    <table class='table table-hover table-responsive table-bordered'>
 
        <tr>
            <td>Name</td>
            <td><input type='text' name='name' value='<?php echo $category->name; ?>' class='form-control' /></td>
        </tr>
 
        <tr>
            <td>Description</td>
            <td><textarea name='description' class='form-control'><?php echo $category->description; ?></textarea></td>
        </tr>
        <tr>
            <td></td>
            <td>
                <button type="submit" class="btn btn-primary">Update</button>
            </td>
        </tr>
 
    </table>
</form>
<?php


// set page footer
include_once "layout_footer.php";
?>