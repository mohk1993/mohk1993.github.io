<?php
require_once 'dbh.inc.php';
require_once 'functions.inc.php';

if(isset($_POST['add'])){
    // // ----------------------- File Information ------------------------
    $fileName = $_FILES["imge"]['name'];
    $productTitle = $_POST["title"];
    $productPrice = $_POST["price"];
    $productDate = date("Y-m-d H:i:s"); 
    $productCategory = $_POST["category"];
    $productDescription = $_POST["description"];
    $productQuantity = $_POST["quantity"];
    $customerFk = $_POST["fk"];

    if(file_exists("images/".$_FILES["imge"]["name"]))
    {
        $store = $_FILES["imge"]["name"];
        $_SESSION['status']="Image already exists.'.$store.'";
        header('location:add-product.php');
    }else
    {
        $query = "INSERT INTO products (product_img, product_name, product_price, product_date, product_category, product_description, product_quantity, customer_Fk) 
        VALUES ('$fileName','$productTitle','$productPrice','$productDate','$productCategory','$productDescription','$productQuantity','$customerFk')";
        $res = mysqli_query($conn,$query);
        
        if($res){
            move_uploaded_file($_FILES['imge']['tmp_name'],"../images/".$_FILES["imge"]["name"]);
            header('location:../add-product.php');
            echo "Success";
        }
        else{
            echo "Fail";
        }
    }
}
    
else{
    header("location: ../add-product.php?error=isset");
}

    // if(emptyInputProduct($productImg,$productTitle,$productPrice,$productDate,$productCategory,$productDescription,$productQuantity)!==false){
    // header("location: ../add-product.php?error=emptyinput");
    //     return;
    // }
    
    // creatProduct($conn,$productImg,$productTitle,$productPrice,$productDate,$productCategory,$productDescription,$productQuantity);


# ---- DELETE -----

if(isset($_POST['delete'])){
    $horse_id = $_POST['delete'];

    $sql = "DELETE FROM horses WHERE horse_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i',$horse_id);
    if($stmt->execute()){
        $_SESSION['msg'] = "Deleted successfully";
    }
    $stmt->close();
    $conn->close();
    header("location: ../horses/horses.php");
}

