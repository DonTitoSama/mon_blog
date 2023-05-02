<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mon blog</title>
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet" />
</head>

<body>

    <header>
        <div class="row justify-content-center">
            <div class="col-10">
                <h1>Mon super blog !</h1>
            </div>
            <div class="col-2">
                <a href="createUserStep1.php" class="btn btn-primary">Créer mon compte</a>
            </div>
        </div>
    </header>

    <?php
    session_start();
    // Connexion à la base de données
    try
    {
        $db = new PDO('mysql:host=localhost:3306;dbname=diego;charset=utf8', 'root', '');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING); // On émet une alerte à chaque fois qu'une
    }
    catch(Exception $e)
    {
        die('Erreur : '.$e->getMessage());
    }


    $strInfo = '';
    $isThumbOk = false;
    $photoName = false;
    if( isset( $_FILES['photo'] ) && $_FILES['photo']['error'] == 0 ) {
        if( $_FILES['photo']['size'] < 128000 ) {
            $infoFichier = pathinfo( $_FILES['photo']['name'] );
            $extension_upload = $infoFichier['extension'];
            $extension_autorisees = [ 'jpg', 'jpeg', 'png' ];
            if( in_array( $extension_upload, $extension_autorisees ) ) {
                $photoName = basename( $_FILES['photo']['name'] );
                move_uploaded_file( $_FILES['photo']['tmp_name'], 'images/' . $photoName );
                $strInfo = "La photo a bien été envoyé";
                $isThumbO4k = true;
            } else {
                $strInfo = "Erreur ! Le format de la photo n'est pas autorisé";
            }
        } else {
            $strInfo = "La photo ne doit pas dépasser les 128Ko";
        }
    } else {
        $strInfo = "Erreur lors du tranfert de la photo";
    }


    if( isset( $_SESSION['pseudo'] ) ) {
        $misc = fopen( '.misc', 'r+' );
        $nonceAndSecret = fgets( $misc );
        $tmp = explode( '#', $nonceAndSecret );
        $nonce = $tmp[0];
        $secretKey = $tmp[1];
        fclose( $misc );
        unlink( '.misc' );
        $pseudo = $_SESSION['pseudo'];
        $pseudoDecript = sodium_crypto_secretbox_open($pseudo, hex2bin($nonce), hex2bin($secretKey));

        $strRequestResult = '';
        $isInsertOk = false;
        $req = $db->prepare(
                'INSERT INTO users( pseudo, mdp, photo) VALUE  ( :pseudo, :mdp, :photo )'
        );
        $data = [
                ':pseudo'   => $pseudoDecript,
                ':mdp'      => $_SESSION['mdp'],
                ':photo'    => $isThumbOk ? $photoName : ''
        ];
        if( $isInsertOk = $req->execute( $data ) ) {
            $strRequestResult = 'Votre compte a bien été créé';
        } else {
            $strRequestResult = 'Erreur ! La requête n\'a pas fonctionné';
        }
    }


    ?>

    <section class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-10 align-content-center">
                <h4 class="text-center">Création de mon compte utilisateur (finalisation)</h4>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-12">
                <?php
                echo '<p class="alert-info">' . $strInfo . '</p>';
                echo '<p class="alert-info">' . $strRequestResult . '</p>';
                if( $isInsertOk ) {
                    echo '<p> Votre pseudo : <b>' . $pseudoDecript . '</b></p>';
                    echo '<p> Votre photo de profil : <img src="images/' . $photoName . '" /></p>';
                }

                ?>
            </div>
        </div>
    </section>


</body>
</html>
