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

    if(!empty($_POST)){
        
        $id = checkInput($_POST['id']);
        $db = Database::connect();
        $statement = $db->prepare("DELETE FROM items WHERE id = ?");
        $statement -> execute(array($id));
        Database::disconnect();
        header("Location: index.php");
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
            
                <h1><strong>Supprimer un item</strong></h1>
                <br>

                <form class="form" role="form" action="delete.php" method="post">
                    <br>

                    <input type="hidden" name="id" value="<?php echo $id ; ?>">
                    <p class="alert alert-warning">Etes vous sur de vouloir supprimer?</p>
                    <div class="form-action">

                        <button type="submit" class="btn btn-warning">Oui</button>
                        <a class="btn btn-default" href="index.php">Non</a>

                    </div>

                </form>    
            
            </div>
        
            
        
        </div>
    </body>
</html>
