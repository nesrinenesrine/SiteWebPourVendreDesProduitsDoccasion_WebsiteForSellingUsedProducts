<?php 
session_start();
include "./inc/conn.php";

$sql="SELECT * FROM categorie";
if (mysqli_query($conn,$sql))
{
    $result = mysqli_query($conn,$sql);
    $categories=mysqli_fetch_all($result, MYSQLI_ASSOC);
}else 
{ 
    echo ("error" . mysqli_error($conn) );
}


$id_categorie= $_SESSION['id_cat'];

$sql_produit="SELECT * FROM `produit`JOIN user ON produit.id_user = user.id_user and produit.id_categorie='$id_categorie' and produit.etat = 0 ORDER BY date_de_publication";
if (mysqli_query($conn,$sql_produit))
{
    $result = mysqli_query($conn,$sql_produit);
    $produits = mysqli_fetch_all($result, MYSQLI_ASSOC);
}
else
{
    echo ("error" . mysqli_error($conn));
}


if(isset($_POST['cat']))
{
    $id_cat=$_POST['cat'];
    
    $_SESSION['id_cat']= $id_cat;
    $sql_produit="SELECT * FROM `produit`JOIN user ON produit.id_user = user.id_user and produit.id_categorie='$id_categorie' and produit.etat = 0 ORDER BY date_de_publication";
    if (mysqli_query($conn,$sql_produit))
    {
        $result = mysqli_query($conn,$sql_produit);
        $produits = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    else
    {
        echo ("error" . mysqli_error($conn));
    }
    header("location:les_produit.php");
    
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="png" href=".\images\log_pweb.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lilita+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./styles_produits.css">
    <link rel="icon" type="png" href=".\images\log_pweb.png">
    <title>AHL STORE Produits</title>
</head>
<body>
    <form action="les_produit.php" method="post">
    <div class="main">
          
          <div class="navbar">
             <div class="imglogo"><img src=".\images\log_pweb.png" alt="logo" style="width:50px;height:50px;"></div>
               <div class="logo" > AHL  STORE  </div>
                <div class="liste">
                   <ul>
                      <li><a href="index.php">Home</a></li>
                      <li><a href="#">Catégories</a>
                     <div class="categories">
                         <ul>
                            <?php foreach($categories as $cat):?>
                                <li ><button type="submit" name="cat" value="<?php echo $cat['id_categorie'] ;?> " class="b" > <?php echo $cat['nom_categorie'] ?></button></li><br>
                             <?php endforeach;?>
                         </ul>   
                     </div>  
                  </li>
                   </ul>
                </div>
             </div>
          </div>
    </div>  
         <div class="les_produits"  >  
            <?php foreach($produits as $produit) : ?>
               <div class="le_produit"  >   
                    <img src= "./produit_pic/<?php echo $produit['photo']; ?> " class="image"  width="250" height="150">
                    <div class="info">
                        <p> <?php   echo "Nom : " .$produit ['nom_produit'];  echo "<br>";?> </p>
                        <p>  <?php  echo  "Prix : ".$produit ['prix_produit']; echo "<br>";?> </p>
                        <p>  <?php echo "Etat : ".$produit ['etat_produit'];  echo "<br>"; ?> </p>
                        <p>  <?php echo "Discription : ".$produit ['discription'];  echo "<br>"; ?> </p>
                        <p>  <?php echo "Publié le : ".$produit ['date_de_publication']; echo "<br>" ;?> </p>
                        <p>  <?php echo "Téléphone : " . $produit['tel'] ;echo "<br>" ;?> </p>
                        <p> Email : <a href="https://www.gmail.com" title="Envoyer un email " target="blank">
                                   <?php      echo " ". $produit['email'] ;?>   </a></p> 
                    </div>
               </div>       
           <?php endforeach;?>
        </div>   
    </form>
</body>
</html>
