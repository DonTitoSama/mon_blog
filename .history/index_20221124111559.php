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

    <section class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-9">
                <p>Derniers billets du blog :</p>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-9">

                <?php
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

                // On récupère les 5 derniers billets
                $req = $db->query(
                        'SELECT 
                            id, 
                            titre, 
                            contenu, 
                            DATE_FORMAT(date_creation, \'%d/%m/%Y à %Hh%imin%ss\') AS date_creation_fr 
                        FROM billets 
                        ORDER BY date_creation 
                        DESC LIMIT 0, 5'
                );

                while ($donnees = $req->fetch()) {
                ?>
                    <div class="card mt-5">
                        <div class="card-header">
                            <em>publié le <?php echo $donnees['date_creation_fr']; ?></em>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($donnees['titre']); ?></h5>
                            <p class="card-text"><?php echo nl2br(htmlspecialchars($donnees['contenu'])); ?></p>
                            <a href="commentaires.php?billet=<?php echo $donnees['id']; ?>" class="btn btn-primary">Commentaires</a>
                        </div>
                    </div>
                <?php
                } // Fin de la boucle des billets
                $req->closeCursor();
                ?>
            </div>
        </div>
    </section>
</body>
</html>