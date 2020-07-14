<?php

    require 'database.php';
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
            
            $imageError = 'Ce champ ne peut pas être vide';
            $isSuccess = false;
        }
        else{
            
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
       
        if($isSuccess && $isUploadSuccess){
            
            $db = Database::connect();
            $statement = $db->prepare("INSERT INTO items (name, description, price, category, image) values (?, ?, ?, ?, ?)");
            $statement->execute(array($name, $description, $price, $category, $image));
            Database::disconnect();
            header("Location: index.php");
            
        }    
            
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
            
                
                
                    <h1><strong>Ajouter un item</strong></h1>
                    <br>
                    
                    <form class="form" role="form" action="insert.php" method="post" enctype="multipart/form-data">

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
                                        
                                        echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
                                    }
                                
                                    Database::disconnect();
                                
                                ?>
                            
                            </select>

                        </div>

                        <div class="form-group">

                            <label for="image">Sélectionner une image: </label>
                            <input type="file" id="image" name="image">
                            <span class="help-inline"><?php echo $imageError; ?></span>

                        </div>

                        <br>

                        <div class="form-action">

                            <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-pencil"></span>  Ajouter</button>
                            <a class="btn btn-primary" href="index.php"><span class="glyphicon glyphicon-arrow-left"></span>  Retour</a>

                        </div>
                    </form>
                
              
                
            
            </div>
        
            
        
        </div>
    </body>
</html>
