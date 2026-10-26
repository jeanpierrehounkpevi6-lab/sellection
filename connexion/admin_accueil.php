

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ma Page</title>
    <link rel="stylesheet" href="../css/admin_acceuil.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <?php
        /* Vérification ci-dessous à faire sur toutes les pages dont l'accès est
        autorisé à un utilisateur connecté. */
        session_start();
        if(!isset($_SESSION['login']) || $_SESSION['app'] != 'musee_football') { 
        //Si la session n'est pas ouverte, redirection vers la page du formulaire
        header("Location:session.php"); 
        }
        if(strcmp($_SESSION['login'] , 'gEstionnaire1@yahoo.com')==0){
            $satut='A';
        }
        else{
            $satut=$_SESSION['role'];
        }

        if(strcmp($satut ,'A')==0){
            $role='administrateur';
        }else if(strcmp($satut ,'R')==0){
            $role='responsable';
        }


        $mysqli = new mysqli('localhost', 'root', '', 'sellection');
        if ($mysqli->connect_errno) {
            echo "Erreur de connexion à la BDD : " . $mysqli->connect_error;
            exit();
        }
        if (!$mysqli->set_charset("utf8")) {
            echo "Erreur encodage utf8 : " . $mysqli->error;
            exit();
        }
        mysqli_report(MYSQLI_REPORT_OFF);
        $sqlPRO="SELECT * FROM t_compte_cpt LEFT JOIN t_profil_pfl USING (cpt_id) WHERE cpt_id= '".$_SESSION['login']."' ";
        $res1=$mysqli->query($sqlPRO);
        if ($res1 == false) {
            echo "Erreur requête selection du profil de l'utilisateur : " . $mysqli->error;
            exit();
        }
        $resPro=$res1->fetch_assoc();

    ?>

    
    
</head>
<body>

    <!-- ======== NAVBAR ======== -->
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="#">
            <i class="fas fa-shield-halved me-2"></i>Espace Administration
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu"
                style="border-color:var(--or)">
            <i class="fas fa-bars" style="color:var(--or)"></i>
        </button>

        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-3">

                <!-- Gestion sélection : visible par tous -->
                <li class="nav-item">
                    <a class="nav-link" href="../back/admin_selection.php">
                        <i class="fas fa-list-check me-1"></i>Gestion des sélections
                    </a>
                </li>

                <!-- Gestion profil : admin seulement -->
                <?php 
                if(strcmp($satut,'A')==0){
                
                 echo("
                    <li class='nav-item'>
                        <a class='nav-link' href='../back/gestion_profil.php'>
                            <i class='fas fa-users-gear me-1'></i>Gestion des profils
                        </a>
                    </li> ");
                }
                ?>
                

            </ul>

            <!-- Déconnexion -->
            <a href="./deconnexion.php" class="btn-deconnexion text-decoration-none">
                <i class="fas fa-right-from-bracket me-1"></i>Déconnexion
            </a>

        </div>
    </div>
</nav>

<!-- ======== CONTENU ======== -->
<div class="container py-5">
    <?php 
        if(strcmp($_SESSION['login'] , 'gEstionnaire1@yahoo.com')==0){
    ?>

        <div class="d-flex align-items-center gap-3 mb-4">
            <h2 class="page-title mb-0">Tableau de <span>bord</span></h2>
            <span class="badge-role"><i class="fas fa-user-tie me-1"></i> Administrateur </span>
        </div>

        <div class="card card-profil" style="max-width:520px;">

            <div class="card-header">
                <i class="fas fa-id-card me-2"></i>Mon profil
            </div>

            <div class="card-body px-4 py-3">
            
                <div class="info-row">
                    <span class="info-label"><i class="fas fa-hashtag me-1"></i>ID compte</span>
                    <span class="info-value"><?php echo htmlspecialchars($resPro['cpt_id']); ?></span>
                </div>
            
            </div>
        </div>

    <?php } else{ ?>
    
    <!-- Titre + badge rôle -->
    <div class="d-flex align-items-center gap-3 mb-4">
        <h2 class="page-title mb-0">Tableau de <span>bord</span></h2>
        <span class="badge-role"><i class="fas fa-user-tie me-1"></i><?php echo ($role); ?></span>
    </div>

    <!-- Card profil -->
    <div class="card card-profil" style="max-width:520px;">
        <div class="card-header">
            <i class="fas fa-id-card me-2"></i>Mon profil
        </div>
        <div class="card-body px-4 py-3">
            

            <div class="info-row">
                <span class="info-label"><i class="fas fa-hashtag me-1"></i>ID compte</span>
                <span class="info-value"><?php echo htmlspecialchars($resPro['cpt_id']); ?></span>
            </div>
            <div class="info-row">
                <span class="info-label"><i class="fas fa-user me-1"></i>Nom</span>
                <span class="info-value"><?php echo htmlspecialchars($resPro['pfl_nom']); ?></span>
            </div>
            <div class="info-row">
                <span class="info-label"><i class="fas fa-user me-1"></i>Prénom</span>
                <span class="info-value"><?php echo htmlspecialchars($resPro['pfl_prenom']); ?></span>
            </div>
            <div class="info-row">
                <span class="info-label"><i class="fas fa-circle-check me-1"></i>Validé</span>
                <span class="info-value">
                    <?php 
                        if($resPro['pfl_valide']=='A'){
                            echo"<span class='badge-valide'>Oui</span>";
                        }else{
                            echo"<span class='badge-invalide'>Non</span>";
                        }
                    
                    ?>
                        
            </div>
            <div class="info-row">
                <span class="info-label"><i class="fas fa-calendar me-1"></i>Membre depuis</span>
                <span class="info-value"><?php echo htmlspecialchars($resPro['pfl_date_creation']); ?></span>
            </div>

               <!-- <p class="text-muted text-center my-3">Profil introuvable.</p>-->
        </div>
    </div>
    <?php } ?>
</div>



<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
<?php $mysqli->close(); ?>

<!--
    <h1>ESPACE ADMINISTRATION</h1>
    <?php
        //echo"<p> Bonjour ".$_SESSION['login']." vous etes connecter en tant que <strong>".$role." </strong> </p>";
        /**affichage desv info du profil  */
        /*
        if( strcmp($_SESSION['role'],'A') ==0){
        //voir ca seulement si admin
            echo("
                  <a href='../back/gestion_profil.php' class='btn btn-outline-success me-5'>gestion profil
                  </a>
                 ");
        }
*/
    ?>
    <a href='../back/admin_selection.php' class='btn btn-outline-success me-5'>gestion des selections
    </a>

    <a href='./deconnexion.php' class='btn btn-outline-success me-5'>deconnexion
    </a>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
    <script>
        // ton JS ici
    </script>
    -->
</body>
</html>