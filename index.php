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
        <link rel="stylesheet" href="css/style.css">

        <!--lien javascript-->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

        <!--lien javascrippt pour bootstrap-->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <!--<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>-->
    
    </head>
    
    <body>
        
        <div class="container site">
            
            <h1 class="text-logo">
                <span class="glyphicon glyphicon-cutlery"></span>
                <span>Burger Code</span>
                <span class="glyphicon glyphicon-cutlery"></span>
            </h1>
            <?php
            
                require 'admin/database.php';
                $db = Database::connect();
                $statement = $db->query("SELECT * FROM categories");
                $categories = $statement->fetchAll();
                echo '<nav>

                        <ul class="nav nav-pills">';

                foreach($categories as $category){
                    if($category['id'] == 1){

                        echo '<li role="presentation" class="active"><a  data-toggle="tab" href="#'.$category['id'].'">'.$category['name'].'</a></li>';

                    }
                    else{

                        echo '<li role="presentation"><a  data-toggle="tab" href="#'.$category['id'].'">'.$category['name'].'</a></li>';
                    }
                }
                echo '  </ul>

                    </nav>';

                echo '<div class="tab-content">';

                foreach($categories as $category){
                    if ($category['id'] == 1){
                        echo '<div class="tab-pane active" id='.$category['id'].'>';
                    }
                    else{
                        echo '<div class="tab-pane" id='.$category['id'].'>';
                    }
                    echo '<div class="row">';

                    $statement = $db->prepare("SELECT * FROM items WHERE items.category = ?");
                    $statement -> execute(array($category['id']));

                    while($item = $statement->fetch()){
                        echo '<div class="col-sm-6 col-md-4">

                                <div class="thumbnail">
                                    <img src="images/'.$item['image'].'">
                                    <div class="price">'.number_format($item['price'], 2, '.', '').'€</div>
                                    <div class="caption">

                                        <h4>'.$item['name'].'</h4>
                                        <p>'.$item['description'].'</p>
                                        <a href="#" role="button" class="btn btn-order">
                                            <span class="glyphicon glyphicon-shopping-cart"></span>
                                            Commander
                                        </a>

                                    </div>
                                </div>
                             </div>';
                    }

                    echo '</div>
                        </div>';
                }
                echo '</div>';                              
                
            ?>      
        
        </div>
    
    </body>
    
</html>