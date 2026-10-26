


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
            <a  href='./selection.php'
              style='display:inline-flex; align-items:center; gap:8px; background:transparent; color:#4a6fa5; border:2px solid #4a6fa5; border-radius:50px; padding:8px 22px; font-weight:700; letter-spacing:.05em; text-decoration:none; transition: all .2s;'
              onmouseover='this.style.background='#4a6fa5';this.style.color='#fff';'
              onmouseout='this.style.background='transparent';this.style.color='#4a6fa5';'>
              <i class='bi bi-arrow-left '></i> Retour aux sélections
                </a>
            </div>
      </div>
              
              ";
          }


    if(isset($_GET['sel_id']) && isset($_GET['elt_id']) && $_GET['elt_id']>0){
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

    $sql="SELECT * FROM t_element_elt WHERE elt_id='".$fid."' AND elt_etat='publié' ";
    $resSQL=$mysqli->query($sql);
    if($resSQL==false){
        echo "Erreur requête recueil des info du first element : " . $mysqli->error;
        exit();
    }
    


    /** Attention pas fini traiter le cas ou l'element est brouillon */

    $first_elt=$resSQL->fetch_assoc();

    $next="SELECT MIN(elt_id) AS next_id FROM t_regroupement_rgp JOIN t_element_elt USING (elt_id)  WHERE slt_id=".$sel." AND elt_id>".$fid." AND elt_etat='publié';";

    $prev="SELECT MAX(elt_id) AS prev_id FROM t_regroupement_rgp  JOIN t_element_elt USING (elt_id) WHERE slt_id=".$sel." AND elt_id<".$fid." AND elt_etat='publié'; ";
    $res1=$mysqli->query($next);
    $res2=$mysqli->query($prev);
    if($res1==false || $res2==false){ 
      echo" Erreur requete du choix de l'id de l'element suivant ou precedent ".$mysqli->error;
      exit();
    }
    $IdNext=$res1->fetch_assoc();
    $IdPrev=$res2->fetch_assoc();
    

?>

  
</head>
<body>

<div class="container py-5">

  <!-- Image + infos -->
  <div class="row g-4 align-items-start">

    <!-- Image -->
    <div class="col-md-6">
        <?php
            if(!empty($first_elt['elt_fichier_image'])){
              /*
                echo("
                        <img src='../ressources/".$first_elt['elt_fichier_image']."'
                        alt='Image élément'
                        class='img-fluid rounded w-100'
                        style='object-fit: contain; aspect-ratio: 4/3; display:block; margin:0 auto;width:100%;'>
                    ");
                    */
                    echo("
                          <img src='../ressources/".$first_elt['elt_fichier_image']."'
                          alt='Image élément'
                          class='img-fluid rounded'
                          style='display:block; margin:0 auto; max-width:500px; width:100%; aspect-ratio: 4/3;'>
                      ");
            }
            else{
                    echo("
                            <div class='bg-secondary rounded d-flex align-items-center justify-content-center'
                            style='aspect-ratio: 4/3;'>
                            <i class='bi bi-image text-white' style='font-size: 3rem;'></i>
                            </div>
                    ");
                
            }
         ?>
         

    </div>

    <!-- Infos -->
    <div class="col-md-6 d-flex flex-column gap-3">

      <!-- Intitulé -->
      <div>
        <label class="text-uppercase text-muted" style="font-size: 11px; letter-spacing: 0.05em;">Intitulé</label>
        <div class="p-3 rounded border bg-white bg-opacity-10">
          <h2 class="mb-0 fw-500" style="color: #c9a84c;">
            <?php  
              echo ($first_elt['elt_intitule']);
             ?>
          </h2>
        </div>
      </div>

      <!-- Date -->
      <div>
        <label class="text-uppercase text-muted" style="font-size: 11px; letter-spacing: 0.05em;">Date d'ajout</label>
        <div class="p-3 rounded border bg-white bg-opacity-10 d-flex align-items-center gap-2">
          <i class="bi bi-calendar3" style="color: #FFD700;"></i>
          <span><?php echo(htmlspecialchars($first_elt['elt_date_ajout'])); ?></span>
        </div>
      </div>

      <!-- ID -->
      

    </div>
  </div>

  <!-- Descriptif -->
  <div class="mt-4">
    <label class="text-uppercase text-muted" style="font-size: 11px; letter-spacing: 0.05em;">Descriptif</label>
    <div class="p-4 rounded border bg-white bg-opacity-10 mt-1">
      <p class="mb-0" style="line-height: 1.7;">
        <?php echo( htmlspecialchars($first_elt['elt_descriptif'])) ; ?>
      </p>
    </div>
  </div>

  <div class="d-flex justify-content-center m-4">

    <!-- Flèche précédent -->
     <?php 
          //echo($res2->num_rows);
          if($res2->num_rows==1 && $IdPrev['prev_id']!=NULL){
            echo("
                  <a href='affichageselection.php?sel_id=".$sel."&elt_id=".$IdPrev['prev_id']."'
                  class='btn btn-outline-success me-5'>
                    <i class='bi bi-arrow-left-circle-fill' style='color: #FFD700; font-size: 1.5rem;'></i>
                    Précédent
                    </a>
            ");
          }
     ?>


    <!-- Flèche suivant -->
    <?php 
          if($res1->num_rows==1 && $IdNext['next_id'] !=NULL){
            echo("
                  <a href='affichageselection.php?sel_id=".$sel."&elt_id=".$IdNext['next_id']."'
                  class='btn btn-outline-dark ms-5'>
                    Suivant
                    <i class='bi bi-arrow-right-circle-fill' style='color: #FFD700; font-size: 1.5rem;'></i>
                  </a>
            ");
          }
     ?>
  </div>

<div class="mbt-3 d-flex justify-content-center " >
      <div >
          <a  href="./selection.php"
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