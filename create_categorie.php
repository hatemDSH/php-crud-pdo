<?php
// set page headers
// include database and object files
include_once 'config/database.php';
// include_once 'objects/product.php';
include_once 'objects/category.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// pass connection to objects

$category = new Category($db);



$page_title = "Create Categorie";
include_once "layout_header.php";
 
echo "<div class='right-button-margin'>";
    echo "<a href='index_cat.php' class='btn btn-default pull-right'>Read Categories</a>";
echo "</div>";
 
?>

<?php 
// if the form was submitted - PHP OOP CRUD Tutorial
if($_POST){
 
    // set product property values
    $category->name = $_POST['name'];
    $category->description = $_POST['description'];
   
 
    // create the product
    if($category->create()){

         // product was created in database
        echo "<div class='alert alert-success'>Categorie was created.</div>";
        
        // try to upload the submitted file
        // uploadPhoto() method will return an error message, if any.
       //  echo $product->uploadPhoto();
       
    }

    // if unable to create the product, tell the user
    else{
        echo "<div class='alert alert-danger'>Unable to create categorie.</div>";
    }
}
?>
 
<!-- HTML form for creating a product -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">

 
    <table class='table table-hover table-responsive table-bordered'>
 
        <tr>
            <td>Name</td>
            <td><input type='text' name='name' class='form-control' /></td>
        </tr>

          <tr>
            <td>Description</td>
            <td><textarea name='description' class='form-control'></textarea></td>
        </tr>
 
        
        <tr>
            <td></td>
            <td>
                <button type="submit" class="btn btn-primary">Create</button>
            </td>
        </tr>
 
    </table>
</form>

<?php
 
// footer
include_once "layout_footer.php";
?>