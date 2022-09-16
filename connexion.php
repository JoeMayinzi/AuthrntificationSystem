<?php
    session_start();

    @$connectBtn = $_POST['connect'];
    @$mail = $_POST['email'];
    @$pass = $_POST['pass'];

    if(isset($connectBtn)) {
      if (isset($mail, $pass) && !empty($mail) && !empty($pass)) {
        $_SESSION['error'] = [];
        if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {

            $_SESSION['error'][] = "Veillez entrer un email valide";
        }

        if ($_SESSION['error'] === []) {

            require_once "connect.php";

            $select = "SELECT * FROM `utilisateurs` WHERE `email` = '$mail'";
            $query = $dataBase->query($select);
            $user =  $query->fetch(PDO::FETCH_ASSOC);
            
            if (!$user) {

                $_SESSION['error'] = "utilisateur n'existe pas";
            } 

            if (!password_verify($_POST['pass'], $user['password'])) {
                $_SESSION['error'][] = "Mot de passe Incorrect";
            }

            $_SESSION['user'] = [
                "id" => $user['id'],
                "nom"=> $user['username'],
                "email" => $user['email'],
            ];

            header("location: profil.php");
        }
    
      } else {
        $_SESSION['error'] = ['Veillez remplir tous les champs'];
      } 
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="style.css">
    <title>Connexion</title>
</head>
<body>
    <form method="post">
        <h2>Connexion</h2>
        <?php
           if(isset($_SESSION['error'])) {
            foreach ($_SESSION['error'] as $error) {
                ?>
                    <span class="error"><?php echo $error ?></span>
                <?php
            }
            unset($_SESSION);
           };
        ?>
        <div class="email">
            <label for="email">Email</label>
            <input type="text" name="email" for="email" placeholder="Entrez votre adresse email">
            
        </div>
        <div class="password">
            <label for="pass">Mot de passe</label>
            <input type="password" name="pass" placeholder="Entrez votre mot de passe">
        </div>
        <div>
            
        <button type="submit" name="connect">Se connctez</button><br>
        <a href="inscription.php">Creez un compte</a>
        </div>
        
    </form>
</body>
</html>