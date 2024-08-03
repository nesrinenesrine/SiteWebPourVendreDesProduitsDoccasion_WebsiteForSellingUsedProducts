<?php 
session_start();
if(empty($_SESSION['userId']))
{
    header("location:login.php");
}else
{
    include "./inc/conn.php";
    $id_peoduit=$_SESSION['id_produit'];
    $sql="SELECT * FROM `produit` WHERE produit.id_produit='$id_peoduit'";
    if (mysqli_query($conn,$sql))
    {
        $result = mysqli_query($conn,$sql);
        $produit=mysqli_fetch_all($result, MYSQLI_ASSOC);
    }else 
    { 
        echo ("error" . mysqli_error($conn));
    }

    $id=$produit[0]['id_produit'];
    $image_prdduit=$produit[0]['photo'];
    $nom=$produit[0]['nom_produit'];
    $prix=$produit[0]['prix_produit'];
    $discription =$produit[0]['discription'];
    $nv_image="";

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

    if(isset($_POST['telechcharger']))
    {
        $extention_valide =array("png","jpeg","jpg","jfif");
        $nv_exteention_telechrger = strtolower(substr(strrchr($_FILES ["image"]['name'] ,'.') ,1 ));
        //print_r($_FILES ["image"]);
        if((empty($_FILES ["image"]['name'])) or (empty($_FILES ["image"]['type'])) 
        or (empty($_FILES ["image"]['tmp_name'])) or (empty($_FILES ["image"]['size']))) 
        {
            $err_image_vide= "vous devez saisire une image";
        }
        elseif( $_FILES ["image"]['error'] > 0)
        {
            $err= "err";
        }elseif(!(in_array($nv_exteention_telechrger,$extention_valide)))
        {
            $err_type= "type de fichie incorecte ";
        }else
        {
            $chemain="produit_modif/".$produit[0]['id_produit'].".".$nv_exteention_telechrger;
            $image_file = move_uploaded_file($_FILES ["image"]['tmp_name'], $chemain);
            if($image_file)
            {
                $nv_image = $produit[0]['id_produit'].".".$nv_exteention_telechrger;
            }
            else
            {
                echo "err";
            }
        }
    }

    if(isset($_POST['submit']))
    {
        if(!empty($_POST['submit']))
        {
            $nom_image=$_POST['submit'];
            $exteention_telechrger = strtolower(substr(strrchr($nom_image ,'.') ,1 ));
            unlink('./produit_pic/'. $image_prdduit);
            $chemain="./produit_pic/".$produit[0]['id_produit'].".".$exteention_telechrger;
            $image_file = rename('./produit_modif/'.$produit[0]['id_produit'].".".$exteention_telechrger, $chemain);
            if($image_file)
            {
                $nv_image = $produit[0]['id_produit'].".".$exteention_telechrger;
            }else
            {
                echo "err";
            }
        }
        else
        {
            $nv_image=$image_prdduit;
        }

        $nom=htmlspecialchars($_POST['nom']);
        $prix=htmlspecialchars($_POST['prix']);
        $discription=htmlspecialchars($_POST['discription']);
        $categorie=$_POST['categirie'];
        $etat=test_input($_POST['etat']);
        
        

        $sql_modif="UPDATE produit SET nom_produit ='$nom' , id_categorie ='$categorie',
        prix_produit='$prix',etat_produit ='$etat' , discription ='$discription', photo ='$nv_image' WHERE produit.id_produit='$id'";

        if(mysqli_query($conn,$sql_modif))
        {           
            header("location:profile.php");
            exit();
        }
        else
        {
            echo 'ERROR' . mysqli_error($conn);
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
    <title>Modifier Produit</title>
</head>
<body class="form">
<legend style="text-align: center;"> INFORMATIONS SUR LE PRODUIT  </legend>
    <form  action="modifier_produit.php" method="POST"  enctype="multipart/form-data" >
    <table >
      
        <!-- LA PHOTO DE PRODUIT -->
           <?php if(!isset($_POST['telechcharger'])):?>
                <tr>
                    <td><label for="image"> Image de produit :  </label></td>
                    <td > <img src="./produit_pic/<?php echo $produit[0]['photo']; ?>" width="200" height="150" ></td>
                </tr>
                <tr>
                    <td><label for="image">  choisire la nouelle Image de produit si vous voulez:  </label></td>
                    <td colspan="2">  <input type="file" name="image" id="image" class="input_file" > </td>
                </tr>
            <?php  endif;?>

            <?php if(isset($_POST['telechcharger'])): ?>
                <tr>
                    <td><label for="image"> Image de produit :  </label></td>
                    <td > <img src="produit_modif/<?php echo $nv_image;?>" width="200" height="150" ></td>
                </tr>
            <?php endif; ?>
           <tr>
              <td> <button type = "submit" name="telechcharger"> Télécharger</button> <td>
          </tr>
        
        <tr>

            <!-- LE NOM DE PRODUIT -->
          <?php if(!isset($_POST['nom'])) { $nom = $produit[0]['nom_produit'];}?>
          <td><label for="nom"> Le nom :</label></td> 
          <td><input type="text" name="nom" id="nom" value="<?php echo $nom ?>" placeholder="entrer le nom du produit"></td>
           
       </tr>
       <tr>

         <!-- LA CATEGORIE DE PRODUIT -->
         
         <td> <label for="categirie"> Catégorie : </label></td>
         <td> <select name="categirie" id="categirie" onchange="javascript:submit(this);" >
            <option></option>
            <?php foreach($categories as $categorie):?>
                <option value="<?php echo $categorie['id_categorie'] ; ?>" <?php if($categorie['id_categorie'] == $produit[0]['id_categorie']) {echo "selected";} ?> > <?php echo $categorie['nom_categorie'] ?> </option>
            <?php endforeach;?>
          </select> </td>

          
      </tr>
      <tr>   
          <!-- LE PRIX DE PRODUIT -->
          <?php if(!isset($_POST['nom'])){ $prix = $produit[0]['prix_produit'];}?>
         <td><label for="prix"> Le prix :</label></td>
         <td><input type="text" name="prix" id="prix" value="<?php echo $prix?>" placeholder="entrer le prix du produit"></td>
         
     </tr>
      <tr>
          <!-- L'ETAT DE PRODUIT -->
          <td> <label for="etat"> L'état :</label></td>
          <td> <input type="radio" name="etat" id="etat" value="neuf" <?php if($produit[0]['etat_produit'] =="neuf")  {echo "checked";}?>> neuf
          <input type="radio" name="etat" id="etat" value="abime" <?php if($produit[0]['etat_produit'] =="abime")  {echo "checked";}?>> abimé 
          <input type="radio" name="etat" id="etat" value="tres abime" <?php if($produit[0]['etat_produit'] =="tres abime")  {echo "checked";}?>>  tres abimé </td>
          
     </tr> 
    <tr>
        <!-- LA DISCRIPTION DE PRODUIT -->
        <?php if(!isset($_POST['discription'])){ $discription = $produit[0]['discription'];}?>
       <td> <label for="discription"> Une description :</label></td>
       <td> <input type="text"  name="discription"  id="discription" value="<?php echo $discription ; ?> " placeholder="ajouter une description .."> </td>
   </tr>

   <tr>
      <td><button type ="submit" name="submit" value="<?php  if(isset($_POST['telechcharger'])) { echo $_FILES["image"]['name'];}?>" >Enregister les modifications</button></td>
   </tr>
    
    </form>
</body>
</html>