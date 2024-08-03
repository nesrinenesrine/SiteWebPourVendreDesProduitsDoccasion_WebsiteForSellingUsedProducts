<?php
include "./inc/conn.php";
$err_nom="";
$err_prenom="";
$err_username="";
$err_tel="";
$err_email="";
$err_pass="";


if (isset($_POST['submit'])) 
{
    $nom        =htmlspecialchars($_POST['nom']);
    $prenom     =htmlspecialchars($_POST['prenom']);
    $username   =htmlspecialchars($_POST['username']);
    $telephone  =htmlspecialchars($_POST['telephone']);
    $email      =htmlspecialchars($_POST['email']);
    $password1  =htmlspecialchars($_POST['password1']);
    $password2 =htmlspecialchars($_POST['password2']);
    $password_code  =password_hash($_POST['password2'],PASSWORD_DEFAULT);

    
    if(empty($nom)) 
    { 
        $err_nom="vous devez saisir votre nom";
    }elseif (!preg_match("/^[a-zA-Z-' '-']*$/",$nom))
    {
        $err_nom='syntaxe invalide';
    }elseif(empty($prenom))
    {
        $err_prenom= "vous devez saisir votre prénom";
    }elseif (!preg_match("/^[a-zA-Z-' '-']*$/",$prenom))
    {
        $err_prenom = 'syntaxe invalide';
    }elseif(empty($username))
    {
        $err_username='veuillez introduisez votre nom d utilisatuer ';
    
    }elseif (!preg_match("/^[a-zA-Z1-9-' '-']*$/",$username))
    {
        $err_username='la syntex valable du username est des lettre etles chifre et des espace blac';
    }
    elseif(empty($email))
    {
        $err_email="vous devez saisire un email";
    }
    elseif(!filter_var($email,FILTER_VALIDATE_EMAIL))
    {
        $err_email="ERROR:format invalide d'email ";
    }elseif(email_existe($email,$conn))
    {
        $err_email= "vous avar deja un compte";
    }
    elseif(empty($telephone))
    {
        $err_tel="NUM VIDE";   
    }elseif(!preg_match("/[0-9]*/",$telephone))
    {
        $err_tel="FORMA INCORET";
    }
    elseif(strlen($telephone)<>10)
    {
        $err_tel="FORMA INCORET2";
    }
    elseif(empty($password1))
    {
        $err_pass='ERROR:veuillez introduisez un mot de passe';
    }
    elseif(empty($password2))
    {
        $err_pass='ERROR:veuillez confirmer votre mot de passe';
    }elseif ($password1<>$password2) 
    {
        $err_pass= 'ERROR:reconfirmer votre mot de passe';
    }
    elseif(empty($password1))
    {
        $err_pass='ERROR:veuillez introduisez un mot de passe';
    }
    elseif(empty($password2))
    {
        $err_pass='ERROR:veuillez confirmer votre mot de passe';
    }elseif ($password1<>$password2) 
    {
        $err_pass= 'ERROR:reconfirmer votre mot de passe';
    }else { 
        $sql="INSERT INTO user( `nom`, `prenom`, `user_name`, `mdp`, `email`, `tel`) 
            VALUES('$nom','$prenom','$username','$password_code','$email','$telephone')";
            if(mysqli_query($conn,$sql))
            {
                header("location:login.php");
                exit();
            }
            else
            {
                echo 'ERROR' . mysqli_error($conn);
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
    <link rel="stylesheet" href="style-creer-compte2.css">
    <link rel="stylesheet" href="style-Home.css">
    <title>Cree compte</title>

</head>
<body>

<div class="form-login">
    <form action="signin.php" method="POST">
        <h2>creer compte</h2>
        <div class="input-nom">

           <input type="text" name="nom" placeholder="saisissez votre nom" id="nom" 
           value="<?php if (isset($_POST['submit'])){ echo  $nom ;}?>"> <br>
           <span><?php echo $err_nom ;?> </span> <br>

           <input type="text" name="prenom" placeholder="saisissez votre prenom" id="prenom"
           value="<?php if (isset($_POST['submit'])){ echo  $prenom ;}?>" > <br>
           <span><?php echo $err_prenom ;?> </span> <br>
        </div>

        <input type="text" name="username" placeholder="saisissez votre nom d'utilisateur"  id="username" 
        value="<?php if (isset($_POST['submit'])){ echo  $username;} ?>"> <br>

        <span><?php echo $err_username ;?> </span><br>

        <input type="email" name="email" placeholder="saisissez votre email" id="email" 
          value="<?php if (isset($_POST['submit'])){echo $email ;}?>"> <br>
        <span><?php echo $err_email ;?> </span><br>

        <input type="text" name="telephone" placeholder="saisissez votre téléphone" id="telephone" 
         value="<?php if (isset($_POST['submit'])){echo $telephone ;}?>"> <br>
         <span><?php echo $err_tel ;?> </span><br>
        <div class="input-nom">
           <input type="password" name="password1" placeholder="saisissez un mot de passe" id="password1" 
            value="<?php if(isset($_POST['submit'])){echo  $password1;}?>">
           <input type="password" name="password2" placeholder="confirmer le mot de passe"  id="password2" 
           value="<?php if(isset($_POST['submit'])){ echo $password2;}?>"> <br>
           <span><?php echo $err_pass ;?> </span><br>
        </div>

       
        <p class="link">j'ai  un compte <br><a href="login.php">se connecter</a></p>
        <button type="submit" name="submit">creer compte</button>
        
       
    </form>
    
  </div>
</html>