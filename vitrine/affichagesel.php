

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Affichage élément</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <style>
        body {
    background-color: #eef2f7;
    background-image: radial-gradient(circle, #c5d3e8 1px, transparent 1px);
    background-size: 28px 28px;
  }
  </style>
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

        function afficherErreur($message) {
              echo "
              <div style='width:70%; margin:30px auto; background:#1a1a1a; border:2px solid #c9a84c; border-radius:12px; padding:20px 24px; display:flex; align-items:center; gap:16px; box-shadow: 0 4px 20px rgba(0,0,0,.2);'>
                  <i class='bi bi-exclamation-triangle-fill' style='color:#c9a84c; font-size:1.8rem;'></i>
                  <div>
                      <p class='mb-0 fw-bold' style='color:#c9a84c; font-size:.75rem; letter-spacing:.1em; text-transform:uppercase;'>Erreur</p>
                      <p class='mb-0' style='color:#fff;'>" . $message . "</p>
                  </div>
              </div>
              
              <div class='mbt-3 d-flex justify-content-center ' >
            <div >
            <a  href='./sel.php'
              style='display:inline-flex; align-items:center; gap:8px; background:transparent; color:#4a6fa5; border:2px solid #4a6fa5; border-radius:50px; padding:8px 22px; font-weight:700; letter-spacing:.05em; text-decoration:none; transition: all .2s;'
              onmouseover='this.style.background='#4a6fa5';this.style.color='#fff';'
              onmouseout='this.style.background='transparent';this.style.color='#4a6fa5';'>
              <i class='bi bi-arrow-left '></i> Retour aux sélections
                </a>
            </div>
      </div>
              
              ";
          }

    if(isset($_GET['sel_id']) && isset($_GET['elt_id']) && $_GET['elt_id']>0 ){
        $sel=$_GET['sel_id'];
        $fid=$_GET['elt_id'];
    }else{
            if(!isset($_GET['sel_id'])){
          afficherErreur("Identifiant de la selection manquante ");
          exit();
        }
        if(!isset($_GET['elt_id'])){
          afficherErreur("Identifiant de élément manquant");
          exit();
        }
        afficherErreur("Aucun élements present dans cette sélection");
        exit();
    }

    if(!ctype_digit($_GET['sel_id']) || !ctype_digit($_GET['elt_id'])  ){
      afficherErreur(" valeur fournir en parametre ne sont pas des entiers");
      exit();
    }

    $SQLid="SELECT * FROM t_regroupement_rgp JOIN t_selection_slt USING (slt_id) JOIN  t_element_elt USING (elt_id) WHERE elt_etat='publié' AND slt_etat='A' AND slt_id=".$sel."  AND elt_id=".$fid."; ";
    $resID=$mysqli->query($SQLid);
    if($resID==false){
      echo "Erreur verification de la valadité des identifiants de la selection et des éléments qui la compose!! " . $mysqli->error;
      exit();
    }
    if($resID->num_rows == 0){
      afficherErreur("Aucun élément correspondant a l'id fournit et a la selection");
      exit();
    }

    $sql="SELECT * FROM t_element_elt WHERE elt_id='".$fid."' AND elt_etat='publié'";
    $resSQL=$mysqli->query($sql);
    if($resSQL==false){
        echo "Erreur requête recueil des info du first element : " . $mysqli->error;
        exit();
    }
    /** Attention pas fini traiter le cas ou l'element est brouillon */

    $first_elt=$resSQL->fetch_assoc();

    $next="SELECT elt_id AS next_id FROM t_regroupement_rgp JOIN t_element_elt USING (elt_id)  WHERE slt_id=".$sel." AND elt_id>=".$fid." AND elt_etat='publié';";

    //$prev="SELECT MAX(elt_id) AS prev_id FROM t_regroupement_rgp   WHERE slt_id=".$sel." AND elt_id<".$fid."";
    $res1=$mysqli->query($next);
    //$res2=$mysqli->query($prev);
    if($res1==false ){
      echo" Erreur requete du choix de l'id de l'element suivant ou precedent ".$mysqli->error;
      exit();
    }
    
   // $IdPrev=$res2->fetch_assoc();

?>

</head>

<body>

  
<div class="container py-5">

    <?php 
    while($IdNext = $res1->fetch_assoc()) {
        $sql3 = "SELECT * FROM t_element_elt WHERE elt_id='" . $IdNext['next_id'] . "' AND elt_etat='publié'";
        $elt = $mysqli->query($sql3)->fetch_assoc();
    ?>

    <div style="width:70%; margin:0 auto 30px auto; background:#fff; padding:24px; border-radius:12px; box-shadow: 0 4px 20px rgba(0,0,0,.1);">

        <?php if(!empty($elt['elt_fichier_image'])) { ?>
            <img src="../ressources/<?php echo $elt['elt_fichier_image']; ?>"
                 alt="Image élément"
                 class="img-fluid rounded"
                 style="object-fit:cover; aspect-ratio:4/3; max-width:450px;">
        <?php } else { ?>
            <div class="bg-secondary rounded d-flex align-items-center justify-content-center"
                 style="aspect-ratio:4/3; max-width:450px;">
                <i class="bi bi-image text-white" style="font-size:3rem;"></i>
            </div>
        <?php } ?>

        <div class="mt-3">
            <label class="text-uppercase text-muted" style="font-size:11px; letter-spacing:0.05em;">Intitulé</label>
            <div class="p-3 rounded border mt-1">
                <h2 class="mb-0" style="color:#FFD700;"><?php echo $elt['elt_intitule']; ?></h2>
            </div>
        </div>

        <div class="mt-3">
            <label class="text-uppercase text-muted" style="font-size:11px; letter-spacing:0.05em;">Date d'ajout</label>
            <div class="p-3 rounded border d-flex align-items-center gap-2 mt-1">
                <i class="bi bi-calendar3" style="color:#FFD700;"></i>
                <span><?php echo $elt['elt_date_ajout']; ?></span>
            </div>
        </div>

        <div class="mt-3">
            <label class="text-uppercase text-muted" style="font-size:11px; letter-spacing:0.05em;">Descriptif</label>
            <div class="p-4 rounded border mt-1">
                <p class="mb-0" style="line-height:1.7;"><?php echo $elt['elt_descriptif']; ?></p>
            </div>
        </div>

    </div>

    <?php } ?>

</div>


<div class="container ">

  <div class="mb-5 d-flex justify-content-center " >
  <div >
    <a  href="./sel.php"
      style="display:inline-flex; align-items:center; gap:8px; background:transparent; color:#4a6fa5; border:2px solid #4a6fa5; border-radius:50px; padding:8px 22px; font-weight:700; letter-spacing:.05em; text-decoration:none; transition: all .2s;"
      onmouseover="this.style.background='#4a6fa5';this.style.color='#fff';"
      onmouseout="this.style.background='transparent';this.style.color='#4a6fa5';">
      <i class="bi bi-arrow-left "></i> Retour aux sélections
    </a>
  </div>
</div>

</div>


</body>
</html>
