<?php 
session_start();
if(!empty($_SESSION['userId']))
{
    header("location:profile.php");
}
else
{
include "./inc/conn.php";
$err="";
$err_username="";
$err_password="";
$err_username_inco ="";
if (isset($_POST['submit']))
{
    $username=htmlspecialchars($_POST['username']);
    $password=htmlspecialchars($_POST['password']);
    if(empty($username))
    {
        $err_username="vous devez saisir votre nom d'utilisateur ou email";
    }elseif(empty($password))
    {
        $err_password = "vous devez saisir votre mot de passe";
    }else
    {
        $sql="SELECT * FROM user WHERE user_name = '$username' OR email = '$username';";

        if(mysqli_query($conn , $sql))
        {
            $result =mysqli_query($conn , $sql);
            $row =mysqli_num_rows ($result);
            if ($row==1)
            {
                $userData=mysqli_fetch_assoc($result);
                if(password_verify($password,$userData['mdp']))
                {
                    
                    $id=$userData["id_user"];
                    $_SESSION['userId']=$id;
                    header ("location:profile.php");
                    exit();
                }
                else{
                    $err=' mot de pass incorect ';
                }
            }
            else
            {
                $err_username_inco ="nom d'utilisateur incorrect";
            }
        }else
        {
            echo ("error" . mysqli_error($conn));
        }
    }
}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="png" href=".\images\log_pweb.png">
    <link rel="stylesheet" href="style-se-connecter2.css">
    <link rel="stylesheet" href="style-Home.css">
    <title>Se connecter</title>
</head>
<body>
<div class="form-login">
       <form action="login.php" method="POST">
        <h2>Se connecter</h2>

        <input type="text" name="username" placeholder="nom d'utilisateur/email"  id="username"
        value="<?php if (isset($_POST['submit'])){ echo  $username;} ?>">
        <span ><?php $err_username; ?></span>

        <input type="password" name="password" placeholder="mot de passe" id="password"
         value="<?php if(isset($_POST['submit'])){ echo $password;}?>">
        <span ><?php echo $err_password;?> </span>
        <span ><?php echo $err_username_inco; ?> </span>
        <span> <?php echo $err;?> </span>

        <button type="submit" name="submit"> se connecter</button>
        <p class="link">je n'ai pas un compte <br><a href="signin.php">creer compte</a></p>
       
       </form>
   </div>
</body>
</html>