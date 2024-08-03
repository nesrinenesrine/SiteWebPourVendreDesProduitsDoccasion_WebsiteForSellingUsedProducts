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

$id=$_SESSION['userId'];
$err_image_vide="";
$err="";
$err_type="";
$err_name="";
$err_cat="";
$err_prix="";
$err_etat="";
$err_discription="";
$image="";
$name="";
$prix="";
$etat="";
$discription="";

if(isset($_POST['telechcharger']))
{
    $extention_valide =array("png","jpeg","jpg","jfif");
    $exteention_telechrger = strtolower(substr(strrchr($_FILES ["image"]['name'] ,'.') ,1 ));

    if((empty($_FILES ["image"]['name'])) or (empty($_FILES ["image"]['type'])) 
    or (empty($_FILES ["image"]['tmp_name'])) or (empty($_FILES ["image"]['size']))) 
    {
        $err_image_vide= "vous devez saisire une image";
    }
    elseif( $_FILES ["image"]['error'] > 0)
    {
        $err= "err";
    }elseif(!(in_array($exteention_telechrger,$extention_valide)))
    {
        $err_type= "type de fichie incirecte ";
    }else
    {
        $sql="SELECT * FROM `produit` ORDER BY id_produit ";
        if (mysqli_query($conn,$sql))
        {
            $result = mysqli_query($conn,$sql);
            $produits = mysqli_fetch_all($result, MYSQLI_ASSOC);
            $last_id=$produits[count($produits)-1]['id_produit'] + 1;
            $chemain="produit_pic/".$last_id.".".$exteention_telechrger;
            $image_file = move_uploaded_file($_FILES ["image"]['tmp_name'], $chemain);
            if($image_file)
            {
                $image = $last_id.".".$exteention_telechrger;
            }
            else
            {
                echo "err";
            }
        }
        else
        {
            echo ("error" . mysqli_error($conn));
        }
    }
}


if(isset($_POST['submit']))
{
    $image_telechrger=$_POST['submit'];
    $last_id_insert=strstr($_POST['submit'] ,".", true);
    $name=htmlspecialchars($_POST['nom']);
    $prix=htmlspecialchars($_POST['prix']);
    $discription=htmlspecialchars($_POST['discription']);
    $categorie=$_POST['categirie'];
    if(empty($image_telechrger))
    {
        $err_image_vide= "vous devez saisire une image";
    }
    elseif(empty($name))
    {
        $err_name= "vous devez saisir le nom";
    }elseif(empty($categorie))
    {
        $err_cat="vous devez saisir la cat";
    }
    elseif(empty($prix))
    {
        $err_prix="vous devez saisir le prix";
    }elseif(empty($_POST['etat']))
    {
        $err_etat= "chek your etet";
    }
    elseif(empty($discription))
    {
        $err_discription="disc";
    }
    else
    {
        $etat=test_input($_POST['etat']);
        echo $etat;
        $date=date('y-m-d');
        $sql_ajouter_produit="INSERT INTO `produit`(`id_produit`, `id_user`, `nom_produit`, `id_categorie`, `prix_produit`, `etat_produit`, `discription`, `photo`, `date_de_publication`, `etat`)
                VALUES ('$last_id_insert','$id','$name','$categorie','$prix','$etat','$discription','$image_telechrger','$date','0')";
        if(mysqli_query($conn , $sql_ajouter_produit))
        {
            header("location:profile.php");
            exit();
        }
        else
        {
            echo ("error" . mysqli_error($conn));
        }
    }
}

function test_input($data) 
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="png" href=".\images\log_pweb.png">
    <link rel="stylesheet" href="./styles_pub.css">
    <title>Publie produit</title>
</head>
<body class="form">
<legend style="text-align: center;"> INFORMATIONS SUR LE PRODUIT  </legend>
<div class="pub">
    <form  action="publie_produit.php" method="POST"  enctype="multipart/form-data" >
    <table >
      
        <?php if(empty($image)):?>
            <tr>
              <td><label for="image"> Image de produit :  </label></td>
              <td colspan="2">  <input type="file" name="image" id="image" class="input_file" > </td>
           </tr>
           <tr>
              <td> <button type = "submit" name="telechcharger"   > Télécharger </button> <td>
             <span> <?php echo $err_image_vide ;  echo $err_type ;  echo $err ; ?> </span> 
          </tr>
       <?php endif;?>
     
        <?php if(!empty($image)):?>
            <tr>
               <td > <img src="./produit_pic/<?php echo $image ;?>" width="200" height="150" ></td>
           </tr>
        <?php endif;?>
        <tr>
          <td><label for="nom"> Le nom :</label></td> 
          <td><input type="text" name="nom" id="nom" value="" placeholder="entrer le nom du produit"></td>
           <span> <?php echo $err_name ;  ?> </span> 
       </tr>
       <tr>
         <td> <label for="categirie"> Catégorie : </label></td>
         <td> <select name="categirie" id="categirie" onchange="javascript:submit(this);" >
            <option></option>
            <?php foreach($categories as $categorie):?>
                <option value="<?php echo $categorie['id_categorie']?>"> <?php echo $categorie['nom_categorie'] ?> </option>
            <?php endforeach;?>
          </select> </td>
          <span> <?php echo $err_cat ;  ?> </span>
      </tr>
      <tr>   
         <td><label for="prix"> Le prix :</label></td>
         <td><input type="text" name="prix" id="prix" placeholder="entrer le prix du produit"></td>
         <span> <?php echo $err_prix ;  ?> </span> 
     </tr>
      <tr>
          <td> <label for="etat"> L'état :</label></td>
          <td> <input type="radio" name="etat" id="etat" value="neuf"> neuf
          <input type="radio" name="etat" id="etat" value="abime"> abimé 
          <input type="radio" name="etat" id="etat" value="tres abime">  tres abimé </td>
          <span> <?php echo $err_etat ;  ?> </span> 
     </tr> 
    <tr>
       <td> <label for="discription"> Une description :</label></td>
       <td> <input type="text" name="discription" id="discription" placeholder="ajouter une description .."></td>
        <span> <?php echo $err_discription ;  ?> </span> 
   </tr>
   <tr>
      <td><button type ="submit" name="submit" value="<?php  if(isset($_POST['telechcharger'])) { echo $image; }?>" > Publier</button></td>
   </tr>
    
    </form>
    </div>

</body>
</html>