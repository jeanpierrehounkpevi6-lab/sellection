

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ma Page</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">


    <style>
            body {
            background-color: #1a1a1a;
            background-image: radial-gradient(circle, #c9a84c 1px, transparent 1px);
            background-size: 28px 28px;
        }
    </style>
    <?php 
    session_start();
        if(!isset($_SESSION['login'])) { 
        //Si la session n'est pas ouverte, redirection vers la page du formulaire
        header("Location:session.php"); 
        }
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
        function afficherErreur($message) {
              echo "
              <div style='width:70%; margin:30px auto; background:#1a1a1a; border:2px solid #c9a84c; border-radius:12px; padding:20px 24px; display:flex; align-items:center; gap:16px; box-shadow: 0 4px 20px rgba(0,0,0,.2);'>
                  <i class='bi bi-exclamation-triangle-fill' style='color:#c9a84c; font-size:1.8rem;'></i>
                  <div>
                      <p class='mb-0 fw-bold' style='color:#c9a84c; font-size:.75rem; letter-spacing:.1em; text-transform:uppercase;'>Erreur</p>
                      <p class='mb-0' style='color:#fff;'>" . $message . "</p>
                  </div>
              </div>";
          }

    if( isset($_POST['SelId'])  ){
        $idSelSupp=intval($_POST['SelId']);

        $mysqli->query("DELETE FROM t_regroupement_rgp WHERE slt_id=" . $idSelSupp);
        $mysqli->query("DELETE FROM t_selection_slt WHERE slt_id=" . $idSelSupp);
    }else

    if( isset($_POST['intitule']) && isset($_POST['description']) ){
        $titre=$mysqli->real_escape_string($_POST['intitule']);
        $des=$mysqli->real_escape_string($_POST['description']);
        if(empty($titre)|| empty($des) ){
            afficherErreur(" Tous les champs obligatoires");
            exit();
        }

        $id=$_SESSION['login'];
        $sqlIN="INSERT INTO t_selection_slt VALUES (
        NULL, 
        '$id', 
        '$titre', 
        '$des', 
        CURDATE(), 
        'A'
            );";
        $res=$mysqli->query($sqlIN);
        if($res==false){
            echo "Erreur requête d'ajout" . $mysqli->error;
            exit();
        }
    }
    $mysqli->close();
    header("Location: ./admin_selection.php");
?>
</head>
<body>
 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
</body>
</html>