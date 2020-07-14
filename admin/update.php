<?php

    require 'database.php';

    if(!empty($_GET['id'])){
        
        $id = checkInput($_GET['id']);
        
    }

    $name = $description = $price = $category = $image = $nameError = $descriptionError = $priceError = $imageError = "";
    function checkInput($data){
        
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
        
    }

    if(!empty($_POST)){
        
        $name =  checkInput($_POST['name']);
        $description = checkInput($_POST['description']);
        $price = checkInput($_POST['price']);
        $category = $_POST['category'];
        $image = checkInput($_FILES['image']['name']);
        $imagePath = '../images'. basename($image);
        $imageExtension = pathinfo($imagePath, PATHINFO_EXTENSION);
        $isSuccess = true;
        $isUploadSuccess = false;
        
        if(empty($name)){
            
            $nameError = 'Ce champ ne peut pas être vide';
            $isSuccess = false;
        }
        
        if(empty($description)){
            
            $descriptionError = 'Ce champ ne peut pas être vide';
            $isSuccess = false;
        }
        
        if(empty($price)){
            
            $priceError = 'Ce champ ne peut pas être vide';
            $isSuccess = false;
        }
        
        if(empty($image)){
            
            $isImageUploaded = false;
        }
        else{
            
            $isImageUploaded = true;
            $isUploadSuccess = true;
            
            if($imageExtension != "jpg" && $imageExtension != "jpeg" && $imageExtension != "gif" && $imageExtension != "png"){
                
                $imageError = "Les fichiers autorisés sont: .jpg, .jpeg, .png, gif";
                $isUploadSuccess = false;
            }
            
            if(file_exists($imagePath)){
                
                $imageError = "Le fichier existe déjà";
                $isUploadSuccess = false;
                
            }
            
            if($_FILES["image"]["size"] > 500000){
                
                $imageError = "Le fichier ne doit pas dépasser 500KB";
                $isUploadSuccess = false;  
            }
            
            if($isUploadSuccess){
                
                if(!move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath)){
                    
                    $imageError = "Il y a une erreur lors du chargement";
                    $isUploadSuccess = false;
                    
                }
            }
            
        }
       
        if(($isSuccess && $isImageUploaded && $isUploadSuccess) || ($isSuccess && !$isImageUploaded)){
            
            $db = Database::connect();
            
            if($isImageUploaded){
                $statement = $db->prepare("UPDATE items set name = ?, description = ?, price = ?, category = ?, image = ? WHERE id = ?");
                $statement->execute(array($name, $description, $price, $category, $image, $id));  
            }
            else{
                $statement = $db->prepare("UPDATE items set name = ?, description = ?, price = ?, category = ?, WHERE id = ?");
                $statement->execute(array($name, $description, $price, $category, $id));
            }
           
            Database::disconnect();
            header("Location: index.php");
            
        }
        
        else if($isImageUploaded && !$isUploadSuccess ){
            
            $db = Database::connect();
            $statement = $db->prepare("SELECT image FROM items WHERE id = ?");
            $statement->execute(array($id));
            $item = $statement->fetch();
            $image = $item['image'];
            Database::disconnect();
        }
            
    }
    else{
        
        $db = Database::connect();
        $statement = $db->prepare("SELECT * FROM items WHERE id = ?");
        $statement->execute(array($id));
        $item = $statement->fetch();
        
        $name = $item['name'];
        $description = $item['description'];
        $price = $item['price'];
        $category = $item['category'];
        $image = $item['image'];
        
        Database::disconnect();
    }

?>


<!DOCTYPE html>
<html>
    
    <head>
        
        <title>Menu Burger</title>  
        
        <!-- Encodage -->
        <meta charset="utf-8">

        <!-- Responsive   -->
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!--lien bootstrap-->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <!--<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">-->

        <!--lien pour la police qui sera utilisée ici LATO-->
        <link href="https://fonts.googleapis.com/css?family=Holtwood+One+SC" rel="stylesheet">

        <!--lien vers notre fichier css-->
        <link rel="stylesheet" href="../css/style.css">

        <!--lien javascript-->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

        <!--lien javascrippt pour bootstrap-->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <!--<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>-->
    
    </head>
    
    <body>
        
            
        <h1 class="text-logo">
            <span class="glyphicon glyphicon-cutlery"></span>
            <span>Burger Code</span>
            <span class="glyphicon glyphicon-cutlery"></span>
        </h1>
        
        
        <div class="container admin">
            
            <div class="row">
            
                <div class="col-sm-6">
                    <h1><strong>Modifer un item</strong></h1>
                    <br>
                    
                    <form class="form" role="form" action="update.php?id=<?php echo $id?>" method="post" enctype="multipart/form-data">

                        <div class="form-group" >

                            <label for="name">Nom:</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Nom" value="<?php echo $name; ?>">
                            <span class="help-inline"><?php echo $nameError; ?></span>

                        </div>

                        <div class="form-group">

                            <label for="description">Description:</label>
                            <input type="text" class="form-control" id="description" name="description" placeholder="Description" value="<?php echo $description; ?>">
                            <span class="help-inline"><?php echo $descriptionError; ?></span>

                        </div>

                        <div class="form-group">

                            <label for="price">Prix: (en €)</label>
                            <input type="number" step="0.01" class="form-control" id="price" name="price" placeholder="Prix" value="<?php echo $price; ?>">
                            <span class="help-inline"><?php echo $priceError; ?></span>

                        </div>

                        <div class="form-group">

                            <label for="category">Catégorie: </label>
                            <select class="form-control" id="category" name="category">
                            
                                <?php
                                
                                    $db = Database::connect();
                                    foreach($db->query('SELECT * FROM categories') as $row){
                                        if($row['id'] == $category){
                                            echo '<option selected value="'.$row['id'].'">'.$row['name'].'</option>';
                                        }
                                        else{
                                            
                                            echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
                                        }
                                        
                                    }
                                
                                    Database::disconnect();
                                
                                ?>
                            
                            </select>

                        </div>

                        <div class="form-group">
                            <label>Image: </label>
                            <p><?php echo $image; ?></p>
                            <label for="image">Sélectionner une nouvelle image: </label>
                            <input type="file" id="image" name="image">
                            <span class="help-inline"><?php echo $imageError; ?></span>

                        </div>

                        <br>

                        <div class="form-action">

                            <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-pencil"></span>  Modifer</button>
                            <a class="btn btn-primary" href="index.php"><span class="glyphicon glyphicon-arrow-left"></span>  Retour</a>

                        </div>
                    </form>    
                </div>
                
                <div class="col-sm-6">
                    <div class="thumbnail">
                                
                        <img src="<?php echo '../images/'.$image;?>">
                        <div class="price"><?php echo number_format((float)$price, 2, '.', '').' €';?></div>
                        <!-- caption pour mettre tous les elements du thumbnail en dessous de limage -->
                        <div class="caption site">
                                
                            <h4><?php echo $name;?></h4>
                            <p><?php echo $description;?></p>
                            <a href="#" role="button" class="btn btn-order">
                                <span class="glyphicon glyphicon-shopping-cart"></span>
                                Commander
                            </a>
                                    
                        </div>
                            
                    </div>
                </div>
            </div>
        
            
        
        </div>
    </body>
</html>
