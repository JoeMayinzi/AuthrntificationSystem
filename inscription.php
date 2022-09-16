<?php 
    session_start();
    require_once "connect.php";

    @$subscribe = $_POST['subscribe'];
    @$name = $_POST['name'];
    @$email = $_POST['email'];
    @$passsword = $_POST['password'];

    if(isset($subscribe)) {
        if(isset($name, $email, $passsword) && !empty($name) && !empty($email) && !empty($passsword)) {
            $name = strip_tags($name);
            $email = strip_tags($email);
            $passsword = strip_tags($passsword);

            $_SESSION['error'] = [];

            if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                 $_SESSION['error'][] = "Adresse email invalide";
            }

            $select = "SELECT * FROM `utilisateurs` WHERE `email` = '$email'";
            $query = $dataBase->query($select);
            $utilisateur =  $query->fetch(PDO::FETCH_ASSOC);

            if ($utilisateur) {

                $_SESSION['error'][] = "Ce compte existe dèja";
            } 

            if ($_SESSION['error'] == []) {

                $passsword = password_hash($passsword, PASSWORD_BCRYPT);
                $insert = "INSERT INTO `utilisateurs`(`username`,`email`,`password`, `role`)
                    VALUES(:username, :email, :password, 'admin')";

                $prepare = $dataBase->prepare($insert);
                $execute = $prepare->execute(array(":username"=>$name, ":email"=>$email, ":password"=>$passsword));
                
                $userId = $dataBase->lastInsertId();

                $_SESSION['user'] = [
                        "id" => $userId,
                        "nom" => $name,
                        "email" => $email
                ];

                header("location: profil.php");
            }
           
        } else {
    
            $_SESSION['error'] = ["Veillez remplir tous les champs Svp !"];
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
    
        <h2>Inscrivez-vous</h2>
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
        <div class="name">
            <label for="name">Nom d'utilisateur</label>
            <input type="text" id="name" name="name" placeholder="Entrez votre nom d'utilisateur">
        </div>
        <div class="email">
            <label for="email">Email</label>
            <input type="text" id="email" name="email" placeholder="Entrez votre adresse email">
        </div>
        <div class="email">
            <label for="password">Mot de passe</label>
            <input type="text" id="password" name="password" placeholder="Entrez un mot de passe">
        </div>
        <div class="subscribe">
            <button type="submit" id="subscribe" name="subscribe">S'inscrire</button><br>
            <a href="connexion.php">Connectez-vous</a>
        </div>
        
    </form>
</body>
</html>