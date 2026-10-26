<!DOCTYPE html>
<html lang="fr">
<?php
        // Connexion à la base de données
        // EN LOCAL (XAMPP + VPN) : utiliser 'obiwan.univ-brest.fr'
        // SUR LE SERVEUR DE L'ECOLE : utiliser 'localhost'
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

        // Récupération des informations de la structure (unique requête)
        $requetePresentation = "SELECT pst_nom_structure, pst_bivenue, pst_adresse, pst_mail, pst_telephone, pst_heure_ouverture,pst_logo FROM t_presentation_pst ;";
        $resultPresentation = $mysqli->query($requetePresentation);
        if ($resultPresentation == false) {
            echo "Erreur requête présentation : " . $mysqli->error;
            exit();
        }
        $structure = $resultPresentation->fetch_assoc();
    ?>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Inscription</title>
        <!-- Bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Font Awesome -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Font Awesome icons (free version)-->
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700" rel="stylesheet" type="text/css" />
        <!-- Core theme CSS (includes Bootstrap)-->
      <!--  <link href="../css/styles.css" rel="stylesheet" />-->
        <link href="../css/sytle_inscription.css" rel="stylesheet" />
    </head>
    <body id="page-top">
    

        <!-- Navigation
        -->


        <!-- Masthead    
         6 champs -->
        <header class="masthead">
        <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
            <div class="container">
                <a class="navbar-brand" href="#page-top" style="font-size: 0.75rem; max-width: 40%; white-space: normal; line-height: 1.2;">
                    <?php echo ($structure['pst_nom_structure']); ?>
                </a>
                <img class="logo" src="../ressources/<?php echo ($structure['pst_logo']); ?>" alt="goat cr7">
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    Menu
                    <i class="fas fa-bars ms-1"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav text-uppercase ms-auto py-4 py-lg-0">
                        <li class="nav-item"><a class="nav-link" href="../index.php"> <i class="bi bi-house me-1"></i> Accueil</a></li>
                        <li class="nav-item">
                            <a class="nav-link" href="../connexion/session.php"><i class="fas fa-right-to-bracket me-1"></i>Connexion</a>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="../vitrine/selection.php"> <i class="bi bi-trophy me-1"></i>Sélections</a></li>
                    </ul>
                </div>
            </div>
        </nav>    

        </header>

        <!-- Actualités-->
        <section class="page-section" id="inscription">
        
            <div class="container ">

                <div id="id1" class=" row justify-content-center">
                    

                        <div class=" col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5 form-inscription ">
                            <h2 class="titre-inscription">Inscription</h2>
                            <p class="sous-titre-inscription">Créez votre compte</p>
                            <form action="action.php" method="post" >

                                <!-- Ligne Nom / Prénom -->
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <label class="form-label">Nom</label>
                                        <input type="text" class="form-control" name="nom" placeholder="Dupont" >
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label">Prénom</label>
                                        <input type="text" class="form-control" name="prenom" placeholder="Jean" >
                                    </div>
                                </div>

                                <!-- Ligne Pseudo -->
                                <div class="mb-3">
                                    <label class="form-label">Pseudo</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        <input type="text" class="form-control" name="pseudo" placeholder="Votre pseudo" >
                                    </div>
                                </div>

                                

                                <div class="divider"></div>

                                <!-- Mot de passe -->
                                <div class="mb-3">
                                    <label class="form-label">Mot de passe</label>
                                    <div class="input-group">
                                        <span class="input-group-text" ><i class="fas fa-lock"></i></span>
                                        <input id="mdp" type="password" class="form-control" name="mdp" placeholder=""  >
                                        <span class="input-group-text" onclick="ChangeVoire('mdp','iconMdp')">
                                            <i class="fas fa-eye" id="iconMdp"></i>
                                        </span>

                                    </div>
                                </div>

                                <!-- Confirmation mot de passe -->
                                <div class="mb-3">
                                    <label class="form-label">Confirmation mot de passe</label>
                                    <div class="input-group">

                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                        <input id="mdpC" type="password" class="form-control" name="mdp_confirm" placeholder="" >
                                        <span class="input-group-text" onclick="ChangeVoire('mdpC','iconMdpC')">
                                            <i class="fas fa-eye" id="iconMdpC"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="divider"></div>

                                <!-- Code d'inscription -->
                                <div class="mb-4">
                                    <label class="form-label">Code d'inscription</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                                        <input type="text" class="form-control" name="code" placeholder="Code fourni par l'administrateur" >
                                    </div>
                                </div>

                                <!-- Bouton -->
                                <div class="row justify-content-center">
                                <button type="submit" class=" col-6 btn-gold">
                                    <i class="fas fa-user-plus me-2"></i> Créer mon compte
                                </button>
                                </div>
                            </form>
                        </div>
                    
                </div>
            </div>
                
            <span></span>
        </section>




        <!-- Sélections 
        <section class="page-section bg-light" id="selections">
            
        </section>

        
        <section class="page-section" id="contact">
            <div class="container">
                <div class="text-center">
                    <h2 class="section-heading text-uppercase">Contact</h2>
                </div>
                <div class="row text-center mt-4">
                    <div class="col-md-4">
                        <i class="fas fa-map-marker-alt fa-2x text-primary mb-2"></i>
                        <p><?php //echo ($structure['pst_adresse']); ?></p>
                    </div>
                    <div class="col-md-4">
                        <i class="fas fa-envelope fa-2x text-primary mb-2"></i>
                        <p>
                            <a href="mailto:<?php echo ($structure['pst_mail']); ?>">
                                <?php //echo ($structure['pst_mail']); ?>
                            </a>
                        </p>
                    </div>
                    <div class="col-md-4">
                        <i class="fas fa-phone fa-2x text-primary mb-2"></i>
                        <p><?php //echo ($structure['pst_telephone']); ?></p>
                    </div>
                </div>
            </div>
        </section>

        
        <footer class="footer py-4">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-4 text-lg-start">
                        <strong><?php //echo ($structure['pst_nom_structure']); ?></strong><br />
                        &copy; <?php //echo date('Y'); ?>
                    </div>
                    <div class="col-lg-4 my-3 my-lg-0 text-center">
                        <i class="fas fa-map-marker-alt me-1"></i> <?php echo ($structure['pst_adresse']); ?><br />
                        <i class="fas fa-clock me-1"></i> Ouverture : <?php echo ($structure['pst_heure_ouverture']); ?>
                    </div>
                    <div class="col-lg-4 text-lg-end">
                        <i class="fas fa-envelope me-1"></i>
                        <a class="link-dark text-decoration-none" href="mailto:<?php echo ($structure['pst_mail']); ?>">
                            <?php // echo ($structure['pst_mail']); ?>
                        </a><br />
                        <i class="fas fa-phone me-1"></i> <?php echo ($structure['pst_telephone']); ?>
                    </div>
                </div>
            </div>
        </footer>-->

        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="../js/script_inscription.js"></script>
        <?php
            $mysqli->close();

        ?>
    </body>
</html>
