

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <style>
        body {
            min-height: 100vh;
            background-color: #eef2f7;
            background-image: radial-gradient(circle, #c5d3e8 1px, transparent 1px);
            background-size: 28px 28px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
  </style>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="bg-light">
<?php
        //Ouverture d'une session
        session_start();
        function afficherErreurConnexion() {
            echo '
            <div class="container mt-4">
                <div class="card border-danger shadow-sm" style="max-width: 450px; margin: auto;">
                    <div class="card-body text-center py-4">
                        <i class="fas fa-circle-exclamation text-danger fs-1 mb-3"></i>
                        <h5 class="card-title text-danger">Connexion échouée</h5>
                        <p class="card-text text-muted">Pseudo / mot de passe incorrect(s) ou profil inconnu.</p>
                        <a href="./session.php" class="btn btn-outline-danger btn-sm mt-1">
                            <i class="fas fa-arrow-left me-1"></i>Réessayer
                        </a>
                    </div>
                </div>
            </div>';
        }
        
        if (!empty($_POST["pseudo"]) &&!empty($_POST["mdp"])){
                
                $mysqli = new mysqli('localhost', 'root', '', 'sellection');               
                if ($mysqli->connect_errno) {
                    // Affichage d'un message d'erreur
                    echo "Error: Problème de connexion à la BDD ".$mysqli->error;
                    // Arrêt du chargement de la page
                    exit();
                }
                // Instruction à rajouter depuis PHP 8.1
                mysqli_report(MYSQLI_REPORT_OFF);

                $id= $mysqli->real_escape_string($_POST["pseudo"]);
                $motdepasse=$mysqli->real_escape_string($_POST["mdp"]);

                $sql="SELECT cpt_id,cpt_mot_de_passe,pfl_statut FROM t_compte_cpt LEFT JOIN t_profil_pfl USING (cpt_id) WHERE
                cpt_id='".$id."' AND cpt_mot_de_passe=MD5('".$motdepasse."') AND (pfl_valide='A' OR cpt_id='gEstionnaire1@yahoo.com' );";
                //echo($sql);
               
                $resultat = $mysqli->query($sql);
                if ($resultat==false) {
                    // La requête a echoué
                    echo "Error: Problème d'accès à la base ".$mysqli->error;
                    exit();
                }
                else {
                
                $ligne=$resultat->fetch_assoc();
                if($resultat->num_rows == 1) {
                    //Mise à jour des données de la session
                    $_SESSION['login']=$id;
                    if(strcmp($_SESSION['login'] , 'gEstionnaire1@yahoo.com')==0){
                        $_SESSION['role']='A';
                    }else{
                        $_SESSION['role']=$ligne['pfl_statut'];
                    }
                    $_SESSION['app'] = 'musee_football';
                   
                    header("Location:admin_accueil.php");
                }
                else{
                    // aucune ligne retournée
                    // => le compte n'existe pas ou n'est pas valide
                    afficherErreurConnexion();
                }
                }
                //Fermeture de la communication avec la base MariaDB
                $mysqli->close();
        }
        else{

            echo '
            <div class="container min-vh-200 d-flex align-items-start justify-content-center mt-5">
                <div class="col-10 col-lg-5">
                    <div class="card border-danger shadow-sm">
                        <div class="card-header bg-danger text-white text-center">
                            <h5 class="mb-0">Erreur</h5>
                        </div>
                        <div class="card-body text-center">
                            <p class="card-text">Tous les champs sont obligatoires!!</p>
                            <a href="session.php" class="btn btn-danger">Retour à la connexion</a>
                        </div>
                    </div>
                </div>
            </div>';
        }
?>

<!-- Bootstrap JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
</body>
</html>

