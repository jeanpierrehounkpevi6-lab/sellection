<!DOCTYPE html>
<html lang="fr">
<head>
    <style>
    #mainNav {
        background-color: #1a1a1a;
        padding: 10px 0;
    }

    #mainNav .navbar-brand {
        color: #f4c430 !important;
        font-size: 0.75rem;
        max-width: 40%;
        white-space: normal;
        line-height: 1.2;
        font-weight: bold;
        text-transform: uppercase;
    }

    body {
    padding-top: 80px;
}


.logo {
    width: 80px;
    height: 80px;
    border-radius: 12px;  /* coins légèrement arrondis */
    object-fit: cover;
    object-position: center ;

}

    #mainNav .nav-link {
        color: #ffffff !important;
        font-weight: 600;
        letter-spacing: 1px;
        padding: 0 15px !important;
        transition: color 0.2s ease;
    }

    #mainNav .nav-link:hover {
        color: #f4c430 !important;
    }

    /* Lien actif aussi en jaune */
    #mainNav .nav-link.active {
        color: #f4c430 !important;
    }
</style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>mes selections</title>
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

        $requetePresentation = "SELECT pst_nom_structure, pst_bivenue, pst_adresse, pst_mail, pst_telephone, pst_heure_ouverture,pst_logo FROM t_presentation_pst ;";
        $resultPresentation = $mysqli->query($requetePresentation);
        if ($resultPresentation == false) {
            echo "Erreur requête présentation : " . $mysqli->error;
            exit();
        }
        $structure = $resultPresentation->fetch_assoc();
    ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href=""rel="stylesheet">
    
</head>
<body>

    <header>
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
                        <li class="nav-item"><a class="nav-link" href="../index.php"> <i class="bi bi-house me-1"></i>Accueil</a></li>
                        <li class="nav-item"><a class="nav-link" href="../inscription/inscription.php"> <i class="bi bi-person-plus me-1"></i> Inscription</a></li>
                        <li class="nav-item"><a class="nav-link" href="./selection.php"> <i class="bi bi-bank me-1"></i>Sélections</a></li>
                    </ul>
                </div>
            </div>
        </nav>

    </header>

    <main class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <?php
                    $requetesel="SELECT * FROM t_selection_slt WHERE slt_etat='A' ";
                    $resSel=$mysqli->query($requetesel);
                    if ($resSel == false) {
                        echo "Erreur requête présentation : " . $mysqli->error;
                        exit();
                    }
                    if($resSel->num_rows == 0){

                        echo" <p class='text-center text-muted'>Acune sélection activé désolé!!!! </p> ";
                        exit();
                    }
                    
                    echo "<table class='table table-striped table-hover table-bordered border-dark shadow-4'>
                    <thead class='table-dark'>
                    <tr>
                        <th scope='col'>Selection</th>
                        <th scope='col'>Description</th>
                        <th scope='col'>Publié par</th>
                        <th scope='col'>Elements</th>
                    </tr>
                    </thead>
                    <tbody>";
                    while($sel=$resSel->fetch_assoc()){
                        $sqlId="SELECT elt_id FROM t_regroupement_rgp JOIN t_element_elt USING (elt_id) WHERE slt_id=".$sel['slt_id']."
                        AND elt_id >0 AND elt_etat='publié' LIMIT 1;";
                        

                        $resId=$mysqli->query($sqlId);
                        if ($resId == false) {
                        echo "Erreur requête Id first element : " . $mysqli->error;
                    }

                    
                    if ($resId->num_rows == 0) {
                       // echo "<p class='text-center text-muted'>Aucun element present dans la  sélection d'ID".$sel['slt_id']."</p>";
                       $id=0;

                    }else{
                        $id=$resId->fetch_assoc()['elt_id'];
                    }

                        echo "<tr>"; 
                            echo "<td>" . ($sel['slt_intitule']) . "</td>";
                            echo "<td>" . ($sel['slt_text_intro']) . "</td>";
                            echo "<td>" . ($sel['cpt_id']) . "</td>";
                            echo "<td>" . " 
                                            <a href='./affichagesel.php?sel_id=".$sel['slt_id']."&elt_id=".$id."' 
                                                class='btn btn-sm' 
                                                style='background:#1a1a1a; color:#c9a84c; border:1px solid #c9a84c; border-radius:8px;'
                                                onmouseover=\"this.style.background='#c9a84c';this.style.color='#1a1a1a';\"
                                                onmouseout=\"this.style.background='#1a1a1a';this.style.color='#c9a84c';\">
                                                <i class='bi bi-eye-fill me-1'></i>Voir
                                            </a>
                                </td>";
                            echo "</tr>";
                        
                    }
                    echo "</tbody></table>";
                ?>
            </div>
        </div>
    </main>

    <footer>
        <!-- Pied de page -->
    </footer>
            <?php
            $mysqli->close();

        ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
   
</body>
</html>