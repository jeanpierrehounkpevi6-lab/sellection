<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion Sellection</title>
    <?php 
        session_start();
        if(!isset($_SESSION['login']) || $_SESSION['app'] != 'musee_football') { 
            //Si la session n'est pas ouverte, redirection vers la page du formulaire
            header("Location:../connexion/session.php"); 
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
        $SqlSel="SELECT * FROM t_selection_slt;";
        $resSel=$mysqli->query($SqlSel);
        if ($resSel == false) {
            echo "Erreur requête selection des profils : " . $mysqli->error;
            exit();
        }


    ?>

    <!-- Bootstrap -->
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
    .table thead tr {
        background-color: var(--noir);
        color: var(--or);
    }
    .table thead th {
        border-color: var(--or) !important;
        letter-spacing: .04em;
    }
    .table tbody tr:hover { background-color: #fdf6e3; }
    .table { border-color: var(--noir) !important; }

    h2 { color: var(--noir); font-weight: 800; }
    h2 span { color: var(--or); }

    .elt-item {
        border-left: 3px solid var(--or);
        padding: 2px 8px;
        margin-bottom: 4px;
        font-size: .88rem;
        color: #2d3748;
    }
    .aucun-elt {
        color: #aaa;
        font-style: italic;
        font-size: .85rem;
    }
</style>
</head>
<body class="bg-light">

    

<div class="container py-5">

        <div class="d-flex justify-content-between">
            <div class="mb-4">
                <h2 >
                    <i class="fas fa-list-check me-2" style="color:var(--or)"></i>Gestion des <span>sélections</span>
                </h2>
            </div>
            <div class=" mb-4 ms-5" >
                <a href="../connexion/admin_accueil.php" 
                    style="display:inline-flex; align-items:center; gap:8px; background-color:var(--noir); color:var(--or); border:2px solid var(--or); border-radius:10px; padding:8px 20px; font-weight:700; letter-spacing:.05em; text-decoration:none; transition: background .2s, color .2s;"
                    onmouseover="this.style.background='var(--or)';this.style.color='var(--noir)';"
                    onmouseout="this.style.background='var(--noir)';this.style.color='var(--or)';">
                    <i class="fas fa-house"></i> Accueil
                </a>
            </div>
        </div>

        <div class="card mb-5 mx-auto " style="max-width:550px; border:2px solid var(--or); border-radius:16px; box-shadow: 0 8px 24px rgba(0,0,0,.1);">
            <div class="card-header" style="background-color:var(--noir); color:var(--or); font-weight:700; letter-spacing:.05em; border-radius:13px 13px 0 0;">
                <i class="fas fa-plus-circle me-2"></i>Ajouter une sélection
            </div>
            <div class="card-body" style="background:#fff;">
            <!-- style du formulaire gerer avec ia claude-->
                <form action="./selections_action.php" method="post">

                    <div class="mb-3">
                        <label class="form-label" style="font-size:.78rem; font-weight:700; text-transform:uppercase; letter-spacing:.07em; color:#8896a5;">Intitulé de la sélection</label>
                        <div class="input-group">
                            <span class="input-group-text" style="background:#f4f7fb; border-color:var(--or);">
                                <i class="fas fa-bookmark" style="color:var(--or);"></i>
                            </span>
                            <input type="text" class="form-control" name="intitule" placeholder="Intitulé" style="border-color:var(--or);">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label" style="font-size:.78rem; font-weight:700; text-transform:uppercase; letter-spacing:.07em; color:#8896a5;">Texte descriptif</label>
                        <div class="input-group">
                            <span class="input-group-text" style="background:#f4f7fb; border-color:var(--or);">
                                <i class="fas fa-align-left" style="color:var(--or);"></i>
                            </span>
                            <input type="text" class="form-control" name="description" placeholder="Description" style="border-color:var(--or);">
                        </div>
                    </div>

                    <button type="submit" name="ajout" style="background-color:var(--noir); color:var(--or); border:2px solid var(--or); border-radius:10px; padding:10px 24px; font-weight:700; letter-spacing:.05em; transition: background .2s, color .2s;"
                        onmouseover="this.style.background='var(--or)';this.style.color='var(--noir)';"
                        onmouseout="this.style.background='var(--noir)';this.style.color='var(--or)';">
                        <i class="fas fa-plus me-2"></i>Ajouter
                    </button>

                </form>
            </div>
        </div>

        <?php if ($resSel->num_rows == 0) { ?>
            <p class="text-center text-muted">Aucune sélection disponible.</p>
        <?php } else { ?>

        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered border-dark align-middle">
                <thead>
                    <tr>
                        <th><i class="fas fa-bookmark me-1"></i>Intitulé de la sélection</th>
                        <th><i class="fas fa-user me-1"></i>Créateur</th>
                        <th><i class="fas fa-layer-group me-1"></i>Éléments</th>
                        <th><i class="fas fa-trash me-1"></i>Suppression</th>
                    </tr>
                </thead>
                <tbody>

                <?php while ($sel = $resSel->fetch_assoc()) {
                    $SqlElt = "SELECT elt_intitule FROM t_element_elt 
                            JOIN t_regroupement_rgp USING (elt_id)
                            JOIN t_selection_slt USING (slt_id) 
                            WHERE slt_id=" . $sel['slt_id'];
                    $resElt = $mysqli->query($SqlElt);
                    if ($resElt == false) {
                        echo "Erreur requête éléments : " . $mysqli->error;
                        exit();
                    }
                ?>
                    <tr>
                        <td><strong><?php echo htmlspecialchars($sel['slt_intitule']); ?></strong></td>
                        <td><?php echo htmlspecialchars($sel['cpt_id']); ?></td>   
                        <td>
                            <?php if ($resElt->num_rows == 0) { ?>
                                <span class="aucun-elt">Aucun élément</span>
                            <?php } else {
                                while ($elt = $resElt->fetch_assoc()) { ?>
                                    <div class="elt-item"><?php echo htmlspecialchars($elt['elt_intitule']); ?></div>
                            <?php } } ?>
                        </td>
                        <td>
                            
                             <form action="./selections_action.php" method="post">
                                <input type="hidden" name="SelId"value="<?php  echo ($sel['slt_id']); ?>" >
                                <!--<button type="submit" name="supp">Supprimer</button>-->
                                <button type="submit" name="supp" 
                                    style="background-color:var(--or); color:var(--noir); border:none; border-radius:8px; padding:6px 14px; font-weight:700; cursor:pointer;"
                                    onmouseover="this.style.background='var(--noir)';this.style.color='var(--or)';this.style.border='1px solid var(--or)';"
                                    onmouseout="this.style.background='var(--or)';this.style.color='var(--noir)';this.style.border='none';">
                                    <i class="fas fa-trash me-1"></i>Supprimer
                                </button>
                             </form>
                        </td>
                    </tr>

                <?php } ?>

                </tbody>
            </table>
        </div>

    <?php } ?>

</div>
    

    <!-- Bootstrap JS ->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
    <?php
        $mysqli->close();
    ?>
</body>
</html>