<!DOCTYPE html>
<html lang="fr">
<?php
        //Hounkpevi Jean-Pierre musee football
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
        <title>Sellection</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Font Awesome icons (free version)-->
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700" rel="stylesheet" type="text/css" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    </head>
    <body id="page-top">
    

        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
            <div class="container">
                <a class="navbar-brand" href="#page-top" style="font-size: 0.75rem; max-width: 40%; white-space: normal; line-height: 1.2;">
                    <?php echo ($structure['pst_nom_structure']); ?>
                </a>
                <img class="logo" src="ressources/<?php echo ($structure['pst_logo']); ?>" alt="goat cr7">
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    Menu
                    <i class="fas fa-bars ms-1"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav text-uppercase ms-auto py-4 py-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="./connexion/session.php" style="font-size:0.9rem;"><i class="fas fa-right-to-bracket me-1"></i>Connexion</a>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="inscription/inscription.php" style="font-size:0.9rem;"> <i class="bi bi-person-plus me-1"></i> Inscription</a></li>
                        <li class="nav-item"><a class="nav-link" href="vitrine/selection.php" style="font-size:0.9rem;"> <i class="bi bi-bank me-1"></i>Sélections</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Masthead    
         6 champs -->
        <header class="masthead">
            <div class="container">
                <div class="masthead-subheading">Bienvenue sur la plateforme officielle</div>
                <div class="masthead-heading text-uppercase">
                    <?php echo ($structure['pst_nom_structure']);?>
                    
                </div>
                <a class="btn btn-primary btn-xl text-uppercase" href="#actualites">Découvrir</a>
            </div>   
        </header>

        <!-- Actualités-->
        <section class="page-section" id="actualites">
            <div class="container">

                <!-- Texte de bienvenue -->
                <div id="txtBienv" class="alert alert-info text-center mb-4" role="alert">
                    <?php 
                        echo ($structure['pst_bivenue']);
                       
                    ?>
                </div>

                <div class="text-center mb-4">
                    <h2 class="section-heading text-uppercase">Actualités</h2>
                </div>

                <?php
                    $requete = "SELECT * FROM t_actualite_act WHERE act_etat='en ligne' ORDER BY act_date_publication DESC LIMIT 5 ;";
                    $result1 = $mysqli->query($requete);

                    if ($result1 == false) {
                        echo "Erreur : " . $mysqli->error." Errno: " . $mysqli->errno ;
                        exit();
                    }

                    if ($result1->num_rows == 0) {
                        echo "<p class='text-center text-muted'>Aucune actualité disponible pour le moment.</p>";
                        
                    } else {
                        $requete2="SELECT COUNT(*) AS nbActu FROM t_actualite_act  ;";
                        $result2 = $mysqli->query($requete2);
                        if ($result1 == false) {
                             echo "Erreur : " . $mysqli->error." Errno: " . $mysqli->errno ;
                        exit();
                            }else{
                        $ligne = $result2->fetch_assoc();
                        $nombre = $ligne['nbActu'];
                        echo" Nombre ligne actualite total ".$nombre ."<br/> <br/>";
                    }



                        echo "<table class='table table-striped table-hover table-bordered border-dark'>
                        <thead>
                        <tr>
                            <th scope='col'>Titre</th>
                            <th scope='col'>Texte</th>
                            <th scope='col'>Publié par</th>
                            <th scope='col'>Date de publication</th>
                        </tr>
                        </thead>
                        <tbody>";
                        while ($actu = $result1->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . ($actu['act_titre']) . "</td>";
                            echo "<td>" . ($actu['act_texte']) . "</td>";
                            echo "<td>" . ($actu['cpt_id']) . "</td>";
                            echo "<td>" . ($actu['act_date_publication']) . "</td>";
                            echo "</tr>";
                        }
                        echo "</tbody></table>";
                    }

                    
                ?>
            </div>
        </section>

        <!-- Sélections -->
        <section class="page-section bg-light" id="selections">
            <div class="container">
                <div class="text-center">
                    <h2 class="section-heading text-uppercase"></h2>
                </div>
                <!-- Les sélections dynamiques seront ajoutées ici -->
            </div>
        </section>

        <!-- Contact-->
        <section class="page-section" id="contact">
            <div class="container">
                <div class="text-center">
                    <h2 class="section-heading text-uppercase">Contact</h2>
                </div>
                <div class="row text-center mt-4">
                    <div class="col-md-4">
                        <i class="fas fa-map-marker-alt fa-2x text-primary mb-2"></i>
                        <p><?php echo ($structure['pst_adresse']); ?></p>
                    </div>
                    <div class="col-md-4">
                        <i class="fas fa-envelope fa-2x text-primary mb-2"></i>
                        <p>
                            <a href="mailto:<?php echo ($structure['pst_mail']); ?>">
                                <?php echo ($structure['pst_mail']); ?>
                            </a>
                        </p>
                    </div>
                    <div class="col-md-4">
                        <i class="fas fa-phone fa-2x text-primary mb-2"></i>
                        <p><?php echo ($structure['pst_telephone']); ?></p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer-->
        <footer class="footer py-4">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-4 text-lg-start">
                        <strong><?php echo ($structure['pst_nom_structure']); ?></strong><br />
                        &copy; <?php echo date('Y'); ?>
                    </div>
                    <div class="col-lg-4 my-3 my-lg-0 text-center">
                        <i class="fas fa-map-marker-alt me-1"></i> <?php echo ($structure['pst_adresse']); ?><br />
                        <i class="fas fa-clock me-1"></i> Ouverture : <?php echo ($structure['pst_heure_ouverture']); ?>
                    </div>
                    <div class="col-lg-4 text-lg-end">
                        <i class="fas fa-envelope me-1"></i>
                        <a class="link-dark text-decoration-none" href="mailto:<?php echo ($structure['pst_mail']); ?>">
                            <?php echo ($structure['pst_mail']); ?>
                        </a><br />
                        <i class="fas fa-phone me-1"></i> <?php echo ($structure['pst_telephone']); ?>
                    </div>
                </div>
            </div>
        </footer>

        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
        <?php
            $mysqli->close();

        ?>
    </body>
</html>
