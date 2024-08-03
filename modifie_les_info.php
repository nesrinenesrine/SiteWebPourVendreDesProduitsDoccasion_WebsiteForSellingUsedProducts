<?php 
session_start();
if(empty($_SESSION['userId']))
{
    header("location:login.php");
}else
{
    include "./inc/conn.php";
    $id=$_SESSION['user'];
    $sql_user="SELECT * FROM `user` WHERE user.id_user='$id'";
    if (mysqli_query($conn,$sql_user))
    {
        $result = mysqli_query($conn,$sql_user);
        $user=mysqli_fetch_all($result, MYSQLI_ASSOC);
    }else 
    { 
        echo ("error" . mysqli_error($conn));
    }
    
    $id=$user[0]['id_user'];
    $nom=$user[0]['nom'];
    $prenom=$user[0]['prenom'];
    $username=$user[0]['user_name'];
    $tel=$user[0]['tel'];
    $email=$user[0]['email'];
    $err_nom="";
    $err_prenom="";
    $err_username="";
    $err_tel="";
    $err_email="";
    if(isset($_POST['submit']))
    {
        $nom=htmlspecialchars($_POST['nom']);
        $prenom=htmlspecialchars($_POST['prenom']);
        $username=htmlspecialchars($_POST['username']);
        $tel=htmlspecialchars($_POST['telephone']);
        $email=htmlspecialchars($_POST['email']);

        if (!preg_match("/^[a-zA-Z-' '-']*$/",$nom))
        {
            $err_nom='syntaxe invalide';
        }elseif(!preg_match("/^[a-zA-Z-' '-']*$/",$prenom))
        {
            $err_prenom="syntaxe invalide";
        }
        elseif (!preg_match("/^[a-zA-Z1-9-' '-']*$/",$username))
        {
            $err_username='la syntaxe valable du username est des lettres et des chiffres et des espaces blanc';
        }
        elseif(!preg_match("/[0-9]*/",$tel))
        {
            $err_tel="format de numéro du téléphone incorrect";
        }
        elseif(!filter_var($email,FILTER_VALIDATE_EMAIL))
        {
            $err_email="ERROR:format invalide d'email ";
        }else
        {
            $sql_modif="UPDATE `user` SET `nom`='$nom',`prenom`='$prenom',
            `user_name`='$username',`email`='$email',`tel`='$tel' WHERE user.id_user='$id'";
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
}

function email_existe($email,$conn)
{
    $sql_verfie_emial="SELECT * FROM `user` WHERE user.email='$email'";
    if(mysqli_query($conn , $sql_verfie_emial))
    {
        $result =mysqli_query($conn,$sql_verfie_emial);
        $row =mysqli_num_rows ($result);
        if($row>1)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    else
    {
        echo 'ERROR' . mysqli_error($conn);
    }
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="png" href=".\images\log_pweb.png">
    <link rel="stylesheet" href="modif_info.css">
    <link rel="stylesheet" href="style-Home.css">
    <title>Modifier les informations</title>
</head>
<body>
    <div class="form-login">
    <form action="modifie_les_info.php" method="post">
        <?php if(!isset($_POST['nom'])){ $nom =$user[0]['nom'];}?>
        <label for="nom">Nom:</label>
        <input type="text"      name="nom"               id="nom"              
        placeholder="saisissez votre nom"  value="<?php  echo  $nom ;?>"> <br>
        <span><?php  echo $err_nom;?></span> <br>
        
        <?php if(!isset($_POST['prenom'])){ $prenom=$user[0]['prenom'];}?>
        <label for="prenom">Prénom:</label>
        <input type="text"      name="prenom"            id="prenom"    
        placeholder="saisissez votre prenom"  value="<?php  echo  $prenom ;?>" > <br>
        <span><?php  echo $err_prenom;?></span> <br>
        
        <?php if(!isset($_POST['username'])){ $username=$user[0]['user_name'];}?>
        <label for="username">Nom d'utilisatuer:</label>
        <input type="text"      name="username"          id="username"  
        placeholder="saisissez votre nom d'utilisateur"  value="<?php echo  $username; ?>"> <br>
        <span><?php  echo $err_username;?></span> <br>

        <?php if(!isset($_POST['telephone'])){ $tel=$user[0]['tel'];}?>
        <label for="tel">Téléphone:</label>
        <input type="tel"       name="telephone"   id="telephone"  
        placeholder="saisissez votre téléphone"    value="<?php  echo $tel ;?>"><br>
        <span><?php  echo $err_tel;?></span> <br>

        <?php if(!isset($_POST['email'])){ $email=$user[0]['email'];}?>
        <label for="email">Email:</label>
        <input type="email"     name="email"       id="email"      
        placeholder="saisissez votre email"        value="<?php echo $email;?>"><br>
        <span><?php  echo $err_email;?></span> <br>
        
        <button type="submit" name="submit" class="button_modif"> Enregistrer les modifications</button>
    </form>
    </div>
</body>
</html>