<!DOCTYPE html>
<html lang="fr">
<head>
    <?php 
        //Hounkpevi Jean-Pierre musee football
        // Connexion à la base de données
        // EN LOCAL (XAMPP + VPN) : utiliser 'obiwan.univ-brest.fr'
        // SUR LE SERVEUR DE L'ECOLE : utiliser 'localhost'
        session_start();
        if(!isset($_SESSION['login']) || $_SESSION['app'] != 'musee_football') { //A COMPLETER pour tester aussi le rôle...
        //Si la session n'est pas ouverte, redirection vers la page du formulaire
        header("Location:../connexion/session.php"); 
        }

        if(strcmp($_SESSION['role'] ,'A')!=0){
            header("Location:../connexion/session.php"); 
        }
        $mysqli = new mysqli('localhost', 'root', '', 'sellection');
        /** ATTENTION ATTION ADMIN gestionnaire 1 DOIT SA PLACE DANS LE TABLEAU  */
        if ($mysqli->connect_errno) {
            echo "Erreur de connexion à la BDD : " . $mysqli->connect_error;
            exit();
        }
        if (!$mysqli->set_charset("utf8")) {
            echo "Erreur encodage utf8 : " . $mysqli->error;
            exit();
        }
        mysqli_report(MYSQLI_REPORT_OFF);
        
        $sqlPRO="SELECT * FROM t_profil_pfl";
        $res1=$mysqli->query($sqlPRO);
        if ($res1 == false) {
            echo "Erreur requête selection des profils : " . $mysqli->error;
            exit();
        }


     ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion profil</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

     <style>
        :root {
        --noir: #1a1a1a;
        --or:   #c9a84c;
        }
        body {
            min-height: 100vh;
            background-color: #eef2f7;
            background-image: radial-gradient(circle, #c5d3e8 1px, transparent 1px);
            background-size: 28px 28px;
        }

        h2 {
            color: #1a1a1a;
            font-weight: 700;
            letter-spacing: .05em;
        }

        h2 i {
            color: #c9a84c;
        }

        /* En-tête tableau noir/or */
        .table thead tr {
            background-color: #1a1a1a;
            color: #c9a84c;
        }

        .table thead th {
            border-color: #c9a84c !important;
            font-weight: 600;
            letter-spacing: .04em;
        }

        /* Lignes */
        .table tbody tr:hover {
            background-color: #fdf6e3;
        }

        .table {
            border-color: #1a1a1a !important;
        }

        .badge-valide {
            background-color: #c9a84c;
            color: #1a1a1a;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 20px;
        }

        .badge-invalide {
            background-color: #1a1a1a;
            color: #c9a84c;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 20px;
        }
    </style>

</head>
<body>

    <div class="d-flex justify-content-end mt-3 mx-3" >
        <a href="../connexion/admin_accueil.php" 
            style="display:inline-flex; align-items:center; gap:8px; background-color:var(--noir); color:var(--or); border:2px solid var(--or); border-radius:10px; padding:8px 20px; font-weight:700; letter-spacing:.05em; text-decoration:none; transition: background .2s, color .2s;"
            onmouseover="this.style.background='var(--or)';this.style.color='var(--noir)';"
            onmouseout="this.style.background='var(--noir)';this.style.color='var(--or)';">
            <i class="fas fa-house"></i> Accueil
        </a>
    </div>

    <div class="container ">
    <div class="row justify-content-center "> 
    <div class="col-9  mt-5">

    
    <?php 
        if ($res1->num_rows == 0) {
            echo "<p class='text-center text-muted'>Aucune profil disponible pour le moment.</p>";
            exit();
                        
         }

         while($personne=$res1->fetch_assoc()){

                 echo "<div class='table-responsive'>
                  <table class='table table-striped table-hover table-bordered border-dark'>
                    <thead>
                      <tr>
                        <th scope='col'><i class='fas fa-hashtag me-1'></i>ID Compte</th>
                        <th scope='col'><i class='fas fa-user me-1'></i>Nom</th>
                        <th scope='col'><i class='fas fa-user me-1'></i>Prénom</th>
                        <th scope='col'><i class='fas fa-tag me-1'></i>Statut</th>
                        <th scope='col'><i class='fas fa-circle-check me-1'></i>Validé</th>
                      </tr>
                    </thead>
                    <tbody>";

            while ($personne = $res1->fetch_assoc()) {
                if(strcmp($personne['pfl_valide'],'A')==0){
                    $badgeValide="<span class='badge-valide'>Oui</span>" ;
                }else{
                    $badgeValide="<span class='badge-invalide'>Non</span>";
                }
                

                echo "<tr>";
                echo "<td>" . $personne['cpt_id']    . "</td>";
                echo "<td>" . $personne['pfl_nom']    . "</td>";
                echo "<td>" . $personne['pfl_prenom'] . "</td>";
                echo "<td>" . $personne['pfl_statut'] . "</td>";
                echo "<td>" . $badgeValide            . "</td>";
                echo "</tr>";
            }

            echo "<tr>";
                echo "<td>" . "gEstionnaire1@yahoo.com"  . "</td>";
                echo "<td> </td>";
                echo "<td>" ."". "</td>";
                echo "<td>" . 'A' . "</td>";
                echo "<td>" . "<span class='badge-valide'>Oui</span>"  . "</td>";
            echo "</tr>";


            echo "</tbody></table></div>";
        }

         
    ?>
    </div>
    </div>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
        <?php
            $mysqli->close();

        ?>
</body>
</html>