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
                <a href="index.php"> <h1>Mon blog</h1></a>
            </div>
            <div class="col-2">
                <a href="createUserStep1.php" class="btn btn-primary">Créer mon compte</a>
            </div>
        </div>
    </header>

    <?php
    $strMessError = '';
    if( isset( $_GET['pseudo']) && $_GET['pseudo'] ) {
        $strMessError = "Pseudo déjà utilisé. Merci de modifier votre pseudo";
    }
    ?>


    <section class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-10 align-content-center">
                <h4 class="text-center">Création de mon compte utilisateur (étape 1)</h4>
            </div>
        </div>
        <div class="row">
            <?php
            if( !empty( $strMessError ) ) {
                echo '<p class="col-9 ml-4 col alert alert-danger">' . $strMessError .'</p>';
            }
            ?>
        </div>
        <div class="row justify-content-center">
            <div class="form-row col-9">
                <form class="needs-validation"  action="createUserStep2.php" method="post" name="formStep1">
                    <div class="form-group">
                        <label for="pseudo">Entrez un pseudonyme</label>
                        <input type="text" value="" class="form-control" id="pseudo" aria-describedby="pseudoHelp" placeholder="votre pseudo" name="pseudo" required>
                        <div class="invalid-feedback">
                           Champ obligatoire.
                        </div>
                        <small id="pseudoHelp" class="form-text text-muted">Ne pas dépasser les 20 caractères.</small>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" value="" class="form-control" name="password" id="password" placeholder="Password" required>
                        <div class="invalid-feedback">
                            Champ obligatoire.
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Valider</button>
                </form>
            </div>
        </div>
    </section>
</body>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</html>