<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=7, initial-scale=1.0">
    <title>Document</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style type="text/css">
        body {
            background-color: #333;
            color: #777;
            text-align: center;
            font-family: sans-serif;
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
// Formulaire d'ajout d'user

    $msgMail = '';
    $alert = '';
    $mailOk = false;
    $mailVerif = false;

    if (isset($_POST['valider'])) {
        $firstname = strip_tags($_POST['firstname']);
        $name = strip_tags($_POST['name']);
        $mail = strip_tags($_POST['mail']);
        $pass = strip_tags($_POST['pass']);


        if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {
            $mailOk = true;
        } else {
            $msgMail = ' : Mail invalide';
            $mailOk = false;
            $alert = 'red';
        }

        try {
            $sql = "SELECT mail FROM users WHERE mail=?";
            $stmt = $connection->prepare($sql);
            $stmt->execute(array($mail));
        } catch (Exception $e) {
            $sqlError = $e->getMessage();
        }

        $mailData = $stmt->rowCount();
        if ($mailData > 0) {
            $mailVerif = false;
            $msgMail = ' : mail existant';
            $alert = 'red';
        } else {
            $mailVerif = true;
        }


        if ($mailOk && $mailVerif) {
            try {
                $sql = $connection->prepare('INSERT INTO users (firstname, name, mail, pass) VALUES (?, ?, ?, ?)');
                $sql->execute(array($firstname, $name, $mail, $pass));
            } catch (PDOException $e) {
                echo "Erreur : " . $e->getMessage();
            }
        }
    }


    ?>
<!-- Formualaire d'ajout -->
    <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#newUser">Ajouter un utilisateur</button>

    <form method="POST" class="collapse" id="newUser">
        <label for="firstname">Prénom</label><br>
        <input type="text" name="firstname" required><br><br>

        <label for="name">Nom</label><br>
        <input type="text" name="name" required><br><br>

        <label for="mail" style="color:<?= $alert ?>">E-mail<?= $msgMail; ?></label><br>
        <input type="text" name="mail" required><br><br>

        <label for="pass">Mot de Passe</label><br>
        <input type="text" name="pass" required><br><br>

        <input type="submit" name="valider" value="Valider">
    </form>
    <?php
    try {
        $sql = "SELECT * FROM users";
        $stmt = $connection->prepare($sql);
        $stmt->execute(array());
        $userData = $stmt->rowCount();
 
    } catch (Exception $e) {
        $sqlError = $e->getMessage();
    } ?>
   <p>Il y a <?= $userData; ?> utilisateur</p>

  
    <hr>

    <?php
    // Suppression d'utilisateur 
    if(isset($_POST['confirm'])){
        $userId = strip_tags($_POST['id']);

        try {
            $sql = "DELETE FROM users WHERE id = ?";
            $stmt = $connection->prepare($sql);
            $stmt->bindParam(1, $userId, PDO::PARAM_INT);
            $stmt->execute();
            header("Location: index.php");
            exit();
    } catch (Exception $e) {
        $sqlError = $e->getMessage();
    }}


    // requete
    try {
        $sql = "SELECT * FROM users";
        $stmt = $connection->prepare($sql);
        $stmt->execute(array());
        $userData = $stmt->rowCount();
 
    } catch (Exception $e) {
        $sqlError = $e->getMessage();
    }
    //  if error
    if (isset($sqlError)) {
        echo $sqlError;
    }
    //  loop results
    while ($users = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
        <h3>
            <?= $users['firstname'] . " " . $users['name']  ?>
        </h3>
        <a href="user.php?id=<?= $users['id'] ?>" class="btn btn-primary">voir les détailles</a>


        <form method="POST">
            <input type="hidden" name="id" id="<?= $users['id'] ?>" value="<?= $users['id'] ?>">
            <button type="button" name="supprimer" class="btn btn-danger"  data-bs-toggle="collapse" data-bs-target="#confirm<?= $users['id'] ?>">supprimer</button>
            <button  name="confirm" class="btn btn-warning collapse" id="confirm<?= $users['id'] ?>">confirmer</button>

        </form>
        <hr>
    <?php } ?>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>