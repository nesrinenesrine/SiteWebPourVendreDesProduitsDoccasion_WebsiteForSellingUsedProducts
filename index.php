
<?php
session_start();
include "./inc/conn.php";

$sql_categorie="SELECT * FROM `categorie`";
if (mysqli_query($conn,$sql_categorie))
{
    $result = mysqli_query($conn,$sql_categorie);
    $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
}
else
{
    echo ("error" . mysqli_error($conn));
}

if(isset($_POST['categorie']))
{
    $id_cat=$_POST['categorie'];
    $_SESSION['id_cat']=$id_cat;
    header("location:les_produit.php");
}

if(isset($_POST['se_connecter']))
{
    header("location:login.php");
}

if(isset($_POST['cree_compte']))
{
    header("location:signin.php");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style-Home.css">
    <link rel="icon" type="png" href=".\images\log_pweb.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lilita+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    
    <title> AHL STORE </title>
</head>
<body>
    <form action="index.php" method="post">
    <nav>
        <div class="nav-list">
           <div class="imglogo"><img src="images/log_pweb.png" alt="logo" style="width:50px;height:50px;"></div>
           <div class="logo" > AHL  STORE  </div>
              
              
            
            <ul class="list-item">
                  <li><a href="index.php">Accuiel</a></li>
                  <li><a href="#categories">Catégories</a>
 
                  </li>
                      
                  <li><a href="#footer">A propos </a></li>
                  <li>  <button type="submit" name="se_connecter">Se connecter</button> </a></li>
                  <li>  <button type="submit" name="cree_compte">Creer compte</button> </a></li>
             </ul>
        </div>
        
    </nav>
    <section >
      <div class="section-contaire">
          <div class="left-side">
            <h1>AHL STORE</h1>
             <p>Plus que la simple volonté de faire des économies, acheter des produits d’occasion
                est un véritable art de vivre. Un mode de consommation responsable qui permet de 
                réduire le gaspillage en offrant une seconde vie à des objets qui ont encore de beaux 
                jours devant eux.notre site n'est qu'un support en ligne dont l'objet est de permettre à n'importe qui, 
                n'importe où et n'importe quand,de vendre ou d'acheter pratiquement 
                tout ce qu'il ou elle souhaite et qui est conforme à la loi.
            </p>
             <a href="login.php">Se connecter</a>
         
          </div>
         
         <div class="img-side">
             <div class="img">
                 <img src="images/header-pic.jpg" alt="">
             </div>
           
       </div>

        
    </section>

    <div class="categories" id="categories">
        <div class="categories-list">
            <div class="categories-left">
               <h1>categories</h1>
                <p>Notre site AHL STORE offre différentes catégories,choisissez 
                    la catégorie qui vous convient en cliquant sur les bouttons <br> ci-dessus:  </p>

                <?php foreach($categories as $categorie):?>
                    <button type="submit" name="categorie" value="<?php echo $categorie['id_categorie'] ;?>"  class="button_cat"> <?php echo $categorie['nom_categorie'] ;?> </button>
                <?php endforeach?>
            </div>

            <div class="categories-right">
               <?php foreach($categories as $categorie):?>
                 <article class="category">
                   <h5> <?php echo $categorie['nom_categorie'] ?> </h5>

                        <?php if($categorie['id_categorie']==1):?>
                            <p>Dénichez votre voiture d'occasion au meilleur prix et  assurez-vous de faire le bon choix</p>
                        <?php endif;?>
                        
                        <?php if($categorie['id_categorie']==2):?>
                            <p>Plongez dans notre rubrique telephone pour vous équiper de qualité à prix promo</p>
                        <?php endif;?>

                        <?php if($categorie['id_categorie']==3):?>
                            <p>Plongez dans notre rubrique PC pour vous équiper de qualité à prix promo</p>
                        <?php endif;?>

                        <?php if($categorie['id_categorie']==4):?>
                            <p> Découvrez pièces détachés ici !</p>
                        <?php endif;?>

                        <?php if($categorie['id_categorie']==5):?>
                            <p>Découvrez l'électroménager en ligne sur notre site pour profiter à des prix imbattable </p>
                        <?php endif;?>

                        <?php if($categorie['id_categorie']==6):?>
                            <p>Trouvez d'autres catégories !</p>
                        <?php endif;?>
                </article>
              <?php endforeach;?>
            </div>
        </div>

    </div>

    <footer>
        <div class="footer-list" id="footer">
            <h3> AHL STORE</h3>
            <p>Sur AHL STORE, des milliers d'articles sont disponibles à prix bas,
                 que votre choix se porte sur de l'occasion.</p>
            <ul class="social">
                <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                <li><a href="#"><i class="fa fa-linkedin-square"></i></a></li>
            </ul>
        </div>
        <div class="footer-bottom">
            <p>copyright &copy ; 2022 AHL STORE designed <span>KNN</span></p>
        </div>
    </footer>
    </form>
</body>
</html>
