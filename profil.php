<?php 
    session_start();

    require_once "connect.php";

    if (!isset($_SESSION['user'])) {
        header("location: connexion.php");
        exit("Veillez vous connecter ou vous inscrire");
    }

    if (isset($_POST['logout'])) {
        session_destroy();
        header("location: connexion.php");
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>profil</title>
</head>
<body>
    <h2>Bienveu dans votre compte <?php echo $_SESSION['user']['nom'] ; ?></h2>
    <ul>
        <li>Nom : <?php echo $_SESSION['user']['nom'] ?></p></li>
        <li>Email: <?php echo $_SESSION['user']['email'] ?></p></li>
    </ul>
    <form method="post">
        <button type="submit" name="logout">Se déconnecter</button>
    </form>
</body>
</html>