<?php date_default_timezone_set('Europe/Paris'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            font-family: sans-serif;
        }

        .user{
            display: block;
            justify-content: center;
            text-align: center;
            padding: 15px;
            background-color: rgb(240,240,240);
            width: 40%;
            margin: 0 35%;
        }
    </style>
</head>

<body>


    <?php
    // connect DB
    try {
        $host = 'localhost';
        $db_name = 'dwwm_20_10_23';
        $login = 'root';
        $pass = '';

        $connection = new PDO("mysql:host=$host;dbname=$db_name", $login, $pass);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (Exception $e) {
        die($erreur_sql = 'Erreur connect bd: ' . $e->getMessage());
    }
    ?>

    <?php

    if (isset($_POST['modifier'])) {
        $new_firstname = strip_tags($_POST['firstname']);
        $new_name = strip_tags($_POST['name']);
        $new_mail = strip_tags($_POST['mail']);

        try {
            $sql = "UPDATE users SET firstname=?, name=?, mail=? WHERE id = ?";
            $stmt = $connection->prepare($sql);

            $stmt->execute(array($new_firstname, $new_name, $new_mail, $_GET['id']));

            
        } catch (Exception $e) {
            $sqlError = $e->getMessage();
        }

        header("Location: user.php?id=".$_GET['id']);
    exit;
    }


    //requete update

    try {
        $sql = "UPDATE users SET dateUpdate=? WHERE id =?";
        $stmt = $connection->prepare($sql);

        $stmt->execute(array(
            date('Y-m-d H:i:s'),
            $_GET['id']
        ));
    } catch (Exception $e) {
        $sqlError = $e->getMessage();
    }
    //  if error
    if (isset($sqlError)) {
        echo $sqlError;
    }


    // requete Select
    try {
        $sql = "SELECT * FROM users WHERE id =?";
        $stmt = $connection->prepare($sql);
        $stmt->execute(array($_GET['id']));
    } catch (Exception $e) {
        $sqlError = $e->getMessage();
    }
    //  if error
    if (isset($sqlError)) {
        echo $sqlError;
    }

    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    $jourSemaine = date_format(date_create($user['dateCreate']), 'w');
    $month = array('Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sept', 'Oct', 'Nov', 'Déc');
    $week = array('Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche');
    $dateCreate = explode(' ', $user['dateCreate']);
    $dateReverse = explode('-', $dateCreate[0]);
    $dateFormat = $week[$jourSemaine] . ' ' . $dateReverse[2] . ' ' . $month[($dateReverse[1] - 1)] . ' ' . $dateReverse[0];

    $dateUser = new DateTime($user['dateCreate']);
    $dateActuelle = new DateTime();
    $interval = $dateActuelle->diff($dateUser);
    $compteurJour = $interval->format('%a');

    ?>
<div class="user">
    <h1>Utilisateur n° <?= $user['id']; ?></h1>
    <p>Créé le <?= $dateFormat; ?> à <?= $dateCreate[1]; ?></p>
 <p>Inscrit depuis : <?= $compteurJour; ?> jours</p>

    <form method="POST">
        <label for="firstname">Votre prénom</label><br>
        <input type="text" name="firstname" value="<?= $user['firstname']; ?>"><br><br>

        <label for="name">Votre nom</label><br>
        <input type="text" name="name" value="<?= $user['name']; ?>"><br><br>

        <label for="mail">Votre E-mail</label><br>
        <input type="text" name="mail" value="<?= $user['mail']; ?>"><br><br>
        <input type="submit" name="modifier" value="modifier">
    </form>
    
    <p>MaJ le : <?= $user['dateUpdate']; ?></p>
</div>
    <a href="index.php">Revenir à l'accueil</a>

</body>

</html>