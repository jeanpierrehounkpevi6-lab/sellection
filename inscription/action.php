<!DOCTYPE html>
<html lang="fr">
<head>

    <style>
        body {
            background-image: url('../ressources/img2.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 100vh;
            margin: 0;
        }
    </style>
    <?php 
$mysqli = new mysqli('localhost', 'root', '', 'sellection');        if ($mysqli->connect_errno)
                {
                // Affichage d'un message d'erreur
                echo "Error: Problème de connexion à la BDD \n";
                echo "Errno: " . $mysqli->connect_errno . "\n";
                echo "Error: " . $mysqli->connect_error . "\n";
                // Arrêt du chargement de la page
                exit();
                }
               
                mysqli_report(MYSQLI_REPORT_OFF);
                //echo ("Connexion BDD réussie !");
                // Instructions PHP à ajouter pour l'encodage utf8 du jeu de caractères
                if (!$mysqli->set_charset("utf8")) {
                printf("Pb de chargement du jeu de car. utf8 : %s\n", $mysqli->error);
                exit();
                }

        $requetePresentation = "SELECT pst_nom_structure, pst_bivenue, pst_adresse, pst_mail, pst_telephone, pst_heure_ouverture,pst_logo,pst_code FROM t_presentation_pst ;";
        $resultPresentation = $mysqli->query($requetePresentation);
        if ($resultPresentation == false) {
            echo "Erreur requête présentation : " . $mysqli->error;
            exit();
        }
        $structure = $resultPresentation->fetch_assoc();

        $requeteCompte = "SELECT * FROM t_compte_cpt ;";
        $resultCompte = $mysqli->query($requeteCompte);
        if ($resultCompte == false) {
            echo "Erreur requête présentation : " . $mysqli->error;
            exit();
        }
        $Compte_Exis = $resultCompte->fetch_assoc();

     ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome (pour les icônes) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <title>Ma Page</title>
</head>
<body>

    <header>
        <nav>
            <!-- Menu de navigation -->
        </nav>
    </header>

    <main>
        <section>
           <!--  Bonjour, <?php //echo htmlspecialchars($_POST['pseudo']); ?>. -->
        


        <?php

            $id=$mysqli->real_escape_string($_POST['pseudo']);
            $mdp=$mysqli->real_escape_string($_POST['mdp']);

            $nom=$mysqli->real_escape_string($_POST['nom']);
            $prenom=$mysqli->real_escape_string($_POST['prenom']);
            $mdp_verif=$mysqli->real_escape_string($_POST['mdp_confirm']);
            $code=$mysqli->real_escape_string($_POST['code']);

            $real_code=$mysqli->real_escape_string($structure['pst_code']);

            function afficherErreur($message) {
                echo '
                <div class="container min-vh-200 d-flex align-items-start justify-content-center mt-5">
                    <div class="col-10 col-lg-5">
                        <div class="card border-danger shadow-sm">
                            <div class="card-header bg-danger text-white text-center">
                                <h5 class="mb-0">Erreur</h5>
                            </div>
                            <div class="card-body text-center">
                                <p class="card-text">' . $message . '</p>
                                <a href="inscription.php" class="btn btn-danger">Retour à l\'inscription</a>
                            </div>
                        </div>
                    </div>
                </div>';
    }

    function afficherSucces($id,$nom,$prenom) {
                echo '
                <div class="container min-vh-100 d-flex align-items-start justify-content-center mt-5">
                    <div class="col-md-6 col-lg-5">
                        <div class="card border-success shadow-sm">
                            <div class="card-header bg-success text-white text-center">
                                <h5 class="mb-0">Inscription réussie !</h5>
                            </div>
                            <div class="card-body text-center">
                                <p class="card-text">Bienvenue  <strong>' . stripslashes($nom ).' '.stripslashes($prenom).  '</strong>, votre compte a bien été créé sous le pseudo <strong>'.
                                stripslashes($id) .'</strong></p>
                                <a href="../connexion/session.php" class="btn btn-success">Se connecter</a>
                            </div>
                        </div>
                    </div>
                </div>';
    }

            if (empty($id) || empty($mdp)||empty($mdp_verif)||empty($nom)||empty($mdp_verif)||empty($code)) { 
                afficherErreur( "Tous les champs sont obligatoires.<br>");
                exit(); // On arrête tout si un champ est vide
            }
            if(strcmp($code,$real_code)!=0){
                afficherErreur("Erreur:Code saisi non valide<br>");
                exit();
            }

            if(strcmp($mdp,$mdp_verif)!=0){
                afficherErreur("Erreur:Non conformité des mots de passes saisis<br>");
                exit();

            }



            while($personne=$resultCompte->fetch_assoc()){
                if(strcmp($personne['cpt_id'],$id)==0){
                    afficherErreur("Pseudo existant veuillez changez de pseudo<br>");
                    exit();

                }

                if(strcmp($personne['cpt_mot_de_passe'],MD5($mdp))==0){
                    afficherErreur(" veuillez changez de Mot de passe car deja Present dans la base<br>");
                    exit();

                }

            }
                //Préparation de la requête à partir des chaînes saisies => concaténation
                //(avec le point) des différents éléments composant la requête
                $sql="INSERT INTO t_compte_cpt VALUES('" .$id. "',MD5('" .$mdp. "'));";
                // Affichage de la requête constituée pour vérification
                //Exécution de la requête d'ajout d'un compte dans la table des comptes
                $result3 = $mysqli->query($sql);
                if ($result3 == false) //Erreur lors de l’exécution de la requête
                {
                /*
                echo "Error: La requête a échoué d'insertion du compte";
                echo "Query: " . $sql . "\<br>";
                echo "Errno: " . $mysqli->errno . "\<br>";
                echo "Error: " . $mysqli->error . "<br>";
                */
                afficherErreur("Erreur lors de la création du compte : " . $mysqli->error);
                exit();
                

                }
                else //Requête réussie
                {
                //afficherSucces("Inscription réussie partiellement pour le compte!" );
                }
                $prof="INSERT INTO t_profil_pfl VALUES ('".$id."','".$nom."','".$prenom."','D','R',CURDATE())";
                
                if ($mysqli->query($prof) == false) //Erreur lors de l’exécution de la requête
                {
                // La requête a echoué
                afficherErreur("Error: La requête d'insertion d'un profil  a échoué ".$mysqli->error);
                /*
                echo "Query: " . $prof . "<br>";
                echo "Errno: " . $mysqli->errno . "<br>";
                echo "Error: " . $mysqli->error . "<br>";
                */

                $del="DELETE FROM t_compte_cpt WHERE cpt_id='".$id."' ";
                if ($mysqli->query($del) == false) {
                    afficherErreur(" Erreur: compte créé mais profil échoué ET suppression impossible.".$mysqli->error);
                    exit();
                }
                afficherErreur(" Suppression du compte effectué pour cause Erreur d'insertion du profil");

                }
                else //Requête réussie
                {
                
                afficherSucces($id,$nom,$prenom);
                exit();
                }
                ?>
        </section>
    </main>

    <footer>
        <!-- Pied de page -->
    </footer>

    <script src="script.js"></script>
    <?php 
        $mysqli->close();
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>














