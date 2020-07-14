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
            
                <h1>Listes des items
                    <a href="insert.php" class="btn btn-success btn-lg">
                
                        <span class="glyphicon glyphicon-plus"></span>
                        Ajouter 
                
                    </a>
                </h1>
                
                <table class="table table-striped table-bordered">
                
                    <thead>
                    
                        <tr>
                            
                            <th>Nom</th>
                            <th>Description</th>
                            <th>Prix</th>
                            <th>Categories</th>
                            <th>Actions</th>
                        
                        </tr>
                        
                    </thead>
                    
                    <tbody>
                        
                        <?php
                        
                            require 'database.php';
                            $db = Database::connect();
                            $statement = $db->query('SELECT items.id, items.name, items.description, items.price, categories.name AS category FROM items LEFT JOIN categories ON items.category = categories.id ORDER BY items.id DESC
                            ');
                            
                            while ($item = $statement->fetch()){
                                
                                echo '<tr>';
                                echo '<td>'.$item['name'].'</td>';
                                echo '<td>'.$item['description'].'</td>';
                                echo '<td>'.number_format((float)$item['price'], 2, '.', '').'</td>';
                                echo '<td>'.$item['category'].'</td>';
                                echo '<td width=300>';
                                echo '<a class="btn btn-default" href="view.php?id='.$item['id'].'">

                                <span class="glyphicon glyphicon-eye-open"></span>
                                            Voir

                                        </a>  ';

                                echo '<a class="btn btn-primary" href="update.php?id='.$item['id'].'">

                                            <span class="glyphicon glyphicon-pencil"></span>
                                            Modifier

                                        </a>  ';

                                echo '<a class="btn btn-danger" href="delete.php?id='.$item['id'].'">

                                            <span class="glyphicon glyphicon-remove"></span>
                                            Supprimer

                                        </a>';

                                echo '</td>';
                                echo '</tr>';
                                
                            }
                        
                        ?>
                        
                    
                    
                    </tbody>
                
                </table>
            
            </div>
        
        </div>
        
    </body>
</html>