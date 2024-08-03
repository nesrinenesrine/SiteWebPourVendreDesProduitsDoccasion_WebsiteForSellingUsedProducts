<?php
session_start();
if(empty($_SESSION['userId']))
{
    header("location:login.php");
}else
{
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

    $id=$_SESSION['userId'];
    $sql_user="SELECT * FROM user WHERE user.id_user='$id'";
    if (mysqli_query($conn,$sql_user))
    {
        $result = mysqli_query($conn,$sql_user);
        $user=mysqli_fetch_all($result, MYSQLI_ASSOC);
    }else 
    { 
        echo ("error" . mysqli_error($conn));
    }
    
    $nom =$user[0]['nom'];
    $prenom=$user[0]['prenom'];

    $sql="SELECT * FROM produit WHERE (produit.id_user='$id' and produit.etat=0) ORDER BY date_de_publication ";
    if (mysqli_query($conn,$sql))
    {
        $result = mysqli_query($conn,$sql);
        $produits=mysqli_fetch_all($result, MYSQLI_ASSOC);
    }else 
    { 
        echo ("error" . mysqli_error($conn));
    }


    if(isset($_POST['suprimer_oui']))
    {
        $id_produit=$_POST['suprimer_oui'];
        echo $id_produit;
        $sql_suprime=" DELETE FROM `produit` WHERE id_produit='$id_produit'";
        if(mysqli_query($conn,$sql_suprime))
        {
            header("location:profile.php");
            exit();
        }else
        {
            echo ("error" . mysqli_error($conn));
        }
    }

    if(isset($_POST['produit_vendu']))
    {
        $id_produit=$_POST['produit_vendu'];
        $sql_vendu="UPDATE `produit` SET `etat`=1 WHERE id_produit='$id_produit'";
        if(mysqli_query($conn, $sql_vendu))
        {
            header("location:profile.php");
            exit();
        }else
        {
            echo ("error" . mysqli_error($conn));
        }
    }

    if(isset($_POST['modifie']))
    {
        $_SESSION['id_produit']= $_POST['modifie'];
        header("location:modifier_produit.php");
    }

    if(isset($_POST['modifie_info']))
    {
        $_SESSION['user']=$_POST['modifie_info'];
        header("location:modifie_les_info.php");
    }

    if(isset($_POST['cat']))
    {
        $id_cat=$_POST['cat'];
        $_SESSION['id_cat']= $id_cat;
        header("location:les_produit.php");
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lilita+One&display=swap" rel="stylesheet">
    <link rel="icon" type="png" href=".\images\log_pweb.png">
    <link rel="stylesheet" href="./styles_profil.css">
    <title>Profile</title>
</head>
<body >
    <script src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons.js"></script>
    <form action="profile.php" method="post" >
        
       <!------------------ navigation bar------------------> 
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
                             <li ><button type="submit" name="cat" value="<?php echo $cat['id_categorie']?>" class="b"> <?php echo $cat['nom_categorie'] ?></button></li><br>
                             <?php endforeach;?>
                         </ul>   
                     </div>  
                  </li>
               </ul>
             </div>
          </div>
       </div>

        <!-------------------- NOM et PRENOM de user)-----------------------> 
        <p class="nom_prenom"> <?php echo $nom; ?> 
            <?php echo $prenom;?> </p>
        
        <!---  logout ------>
        <a href="logout.php" class="Logout" title="logout">
                 <!-- icon logout -->
                 <span class="button__icon_logout">
                   <ion-icon name="exit"></ion-icon>
                  </span>
        </a> 
       <!-- pubiler produit / modifier profile-->
      <div class="deux_btn">
          <button type="submit" name="modifie_info" value="<?php echo $id;?>" class="button__modp"> Modifier Profile</button>
    
          <div class="publie_produit">    
              <a href="publie_produit.php" >Publier Produit</a> <br> <br>
          </div>
     </div>
         <!------------------------------------ les produit li publiyahom deja user  --------------------------------------->
     <div class="les_produits" >

        <?php foreach($produits as $produit) : ?>
        <div class="le_produit" >
         
        <img src= "./produit_pic/<?php echo $produit['photo']; ?> "  class="image" width="250" height="150">
            
                 <div class="info">
                <p><?php   echo "Nom : " .$produit ['nom_produit']; ?></p> 
                 <p> <?php  echo "Etat : ".$produit ['etat_produit'];?>  </p>
                 <p><?php echo "Prix : ".$produit ['prix_produit'];?> </p>
                 <p><?php echo "Publié le : ".$produit ['date_de_publication']; ?>  </p>
                   

             </div> 

                  <button type= "submit"  name="suprimer"      value="<?php  echo $produit['id_produit'];?>" class="button__pub"> Suprimer
                   <!-- icon trash -->
                   <span class="button__icon_trash">
                      <ion-icon name="trash"></ion-icon> 
                    </span>
                   </button>
                  <button type= "submit"  name="produit_vendu" value="<?php  echo $produit['id_produit'];?>" class="button__pub"> Vendu
                     <!-- icon cart -->
                      <span class="button__icon_cart">
                         <ion-icon name="cart"></ion-icon>
                      </span> 
                  </button>
                  <button type= "submit"  name="modifie"       value="<?php  echo $produit['id_produit'];?>" class="button__pub"> Modifier
                   <!-- icon modification -->
                   <span class="button__icon_modification">
                      <ion-icon name="create"></ion-icon>
                    </span> 
                  </button> <br>
            
                  <?php if((isset($_POST['suprimer'])) and ($produit['id_produit']== $_POST['suprimer'])):?>
                      <div class="supprimer">
                         <p>vous voulez vraiment suprimer le produit</p>
                         <button type= "submit"  name="suprimer_oui" value="<?php  echo $_POST['suprimer']?>" > oui</button>
                         <button type= "submit"  name="suprimer_non" value="<?php  echo $produit['id_produit'];?>" > non</button>
                      </div>
                   <?php endif?>
                
                  </div> 

                    
                    
                  <?php endforeach?>
         </div>
       </form>
</body>
</html>