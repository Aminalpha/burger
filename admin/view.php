<?php

    require 'database.php';

    function checkInput($data){
        
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
        
    }

    if(!empty($_GET['id'])){
        
        $id = checkInput($_GET['id']);
        
    }

    $db = Database::connect();
    $statement = $db->prepare('SELECT items.id, items.name, items.description, items.price, items.image, categories.name AS category FROM items LEFT JOIN categories ON items.category = categories.id WHERE items.id = ?');
    $statement -> execute(array($id));
    $item = $statement->fetch();
    Database::disconnect();
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
                
                    <h1><strong>Voir un item</strong></h1>
                    <br>
                    
                    <form>

                        <div class="form-group">

                            <label>Nom:</label><?php echo ' '.$item['name']; ?>

                        </div>

                        <div class="form-group">

                            <label>Description: </label><?php echo ' '.$item['description']; ?>

                        </div>

                        <div class="form-group">

                            <label>Prix: </label><?php echo ' '.number_format((float)$item['price'], 2, '.', ''); ?>

                        </div>

                        <div class="form-group">

                            <label>Catégorie: </label><?php echo ' '.$item['category']; ?>

                        </div>

                        <div class="form-group">

                            <label>Image: </label><?php echo ' '.$item['image']; ?>

                        </div>

                    </form>
                    
                    <br>
                    
                    <div class="form-action">
                    
                        <a class="btn btn-primary" href="index.php"><span class="glyphicon glyphicon-arrow-left"></span>  Retour</a>
                    
                    </div>
                
                </div>
                
                <div class="col-sm-6">
                            
                    <div class="thumbnail">
                                
                        <img src="<?php echo '../images/'.$item['image'];?>">
                        <div class="price"><?php echo number_format((float)$item['price'], 2, '.', '').' €';?></div>
                        <!-- caption pour mettre tous les elements du thumbnail en dessous de limage -->
                        <div class="caption site">
                                
                            <h4><?php echo $item['name'];?></h4>
                            <p><?php echo $item['description'];?></p>
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
































