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
        $db = new PDO('mysql:host=localhost:3306;dbname=blog;charset=utf8', 'root', '');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING); // On émet une alerte à chaque fois qu'une
    }
    catch(Exception $e)
    {
        die('Erreur : '.$e->getMessage());
    }


    // Application test et nettoyage sécurité
    $pseudo =  htmlspecialchars( $_REQUEST['pseudo'] );
    $mdp = htmlspecialchars( $_REQUEST['password'] );
    $pseudo = filter_var( $pseudo, FILTER_SANITIZE_STRING );

    $req = $db->prepare( 'SELECT * FROM  users WHERE pseudo=:pseudo' );
    $req->execute( [':pseudo'=> $pseudo] );
    if( $req->rowCount() )  {
        header('Location: createUserStep1.php?pseudo=1');
        exit;
    }


    // Hasher le mdp et le pseudo
    $secretKey = random_bytes(SODIUM_CRYPTO_SECRETBOX_KEYBYTES);
    $nonce = random_bytes(SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);
    $pseudoHash = sodium_crypto_secretbox( $pseudo, $nonce, $secretKey );
    $mdpHash = sodium_crypto_pwhash_str( $mdp, SODIUM_CRYPTO_PWHASH_OPSLIMIT_INTERACTIVE,
        SODIUM_CRYPTO_PWHASH_MEMLIMIT_INTERACTIVE );


    $misc = fopen( '.misc', 'a+' );
    fputs( $misc, bin2hex($nonce) . '#' . bin2hex($secretKey) );
    fclose( $misc );
    $_SESSION['pseudo'] = $pseudoHash;
    $_SESSION['mdp'] = $mdpHash;

    ?>

    <section class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-10 align-content-center">
                <h4 class="text-center">Création de mon compte utilisateur (étape 2)</h4>
            </div>
        </div>
        <div class="row justify-content-center mt-5">
            <div class="col-9">
                <form action="validUser.php" method="post" name="formStep2" enctype="multipart/form-data">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                        </div>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="photo" name="photo">
                            <label class="custom-file-label" for="photo">Choisissez votre photo de profil</label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Valider</button>
                </form>
            </div>
        </div>
    </section>


</body>
</html>