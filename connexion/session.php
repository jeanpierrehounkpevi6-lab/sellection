<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>session</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="../css/style_connexion.css">
</head>

<body>

    <div class="m-5">
        <a href="../index.php" 
        style="position:fixed; top:16px; right:16px; display:inline-flex; align-items:center; gap:8px; background:linear-gradient(135deg, #4a6fa5, #7eb8d4); color:#fff; border:none; border-radius:10px; padding:8px 20px; font-weight:700; letter-spacing:.05em; text-decoration:none; box-shadow: 0 4px 14px rgba(74,111,165,.35); z-index:999;"
        onmouseover="this.style.opacity='.85';"
        onmouseout="this.style.opacity='1';">
        <i class="fas fa-house"></i> Accueil
        </a>
    </div>

    <div id="mac" class=" mt-1" >

    
        <div class="card">
    
            <div class="card-header">
                <div class="icon-wrap"><i class="fas fa-user-circle"></i></div>
                <h1>Connexion</h1>
                <p>Bienvenue ! Veuillez vous identifier.</p>
            </div>
            
            <form action="session_action.php" method="post">
            
                <!-- Pseudo -->
                <div class="mb-3">
                <label class="form-label">Pseudo</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                    <input type="text" class="form-control" name="pseudo" placeholder="Votre pseudo">
                </div>
                </div>
            
                <div class="divider"></div>
            
                <!-- Mot de passe -->
                <div class="mb-3">
                <label class="form-label">Mot de passe</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    <input id="mdp" type="password" class="form-control" name="mdp" placeholder="Votre mot de passe">
                    <span class="input-group-text btn-toggle" onclick="ChangeVoire('mdp','iconMdp')">
                    <i class="fas fa-eye" id="iconMdp"></i>
                    </span>
                </div>
                </div>
            
                <button type="submit" class="btn-submit">
                <i class="fas fa-arrow-right-to-bracket" style="margin-right:8px"></i>Se connecter
                </button>

                
            
            </form>
        </div>
    </div>
    
<script src="../js/script_inscription.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
</body>
</html>