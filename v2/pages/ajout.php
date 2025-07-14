<?php
session_start();
include '../inc/fonction.php';

if (!isset($_SESSION['user'])) {
    header('Location: ../index.php');
    exit();
}

$list_categ = list_categorie();
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom_objet = htmlspecialchars($_POST['nom_objet'] ?? '', ENT_QUOTES, 'UTF-8');
    $id_categorie = (int) ($_POST['id_categorie'] ?? 0);
    $id_membre = $_SESSION['user']['id_membre'];
    
    if (!empty($nom_objet) && $id_categorie > 0) {
        $id_objet = ajout_objet($nom_objet, $id_categorie, $id_membre);
        
        if (!empty($_FILES['images']['name'][0])) {
            $images = traiter_upload_images($id_objet);
            $message = $images ? 'Objet et images ajoutés!' : 'Objet ajouté mais images invalides';
        } else {
            $message = 'Objet ajouté sans image';
        }
    } else {
        $message = 'Veuillez remplir tous les champs';
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <title>Ajouter un objet</title>
    <style>
        body { background-color: #f8f9fa; padding-top: 20px; }
        .form-container { 
            max-width: 600px; 
            margin: 0 auto; 
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        .btn-custom { 
            background-color: #0d6efd; 
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            border: none;
        }
        .btn-custom:hover { background-color: #0b5ed7; }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h2 class="text-center mb-4">Ajouter un nouvel objet</h2>
            
            <?php if ($message): ?>
                <div class="alert alert-info"><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></div>
            <?php endif; ?>
            
            <form method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="form-label">Nom de l'objet *</label>
                    <input type="text" class="form-control" name="nom_objet" value="<?= htmlspecialchars($_POST['nom_objet'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Catégorie *</label>
                    <select class="form-select" name="id_categorie" required>
                        <option value="" disabled <?= empty($_POST['id_categorie']) ? 'selected' : '' ?>>Choisir...</option>
                        <?php foreach ($list_categ as $cat): ?>
                            <option value="<?= $cat['id_categorie'] ?>" <?= isset($_POST['id_categorie']) && $_POST['id_categorie'] == $cat['id_categorie'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($cat['nom_categorie'], ENT_QUOTES, 'UTF-8') ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="mb-4">
                    <label class="form-label">Images (optionnel)</label>
                    <input type="file" class="form-control" name="images[]" multiple accept="image/*">
                    <small class="text-muted">Formats: JPG, PNG, GIF (max 5MB)</small>
                </div>
                
                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-custom">Ajouter</button>
                    <a href="accueil.php" class="btn btn-outline-secondary">Retour</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>