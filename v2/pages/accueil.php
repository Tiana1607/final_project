<?php
include '../inc/fonction.php';
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: ../index.php');
    exit();
}
$user = $_SESSION['user'];

$list_objet = list_object();
$emprunter = objet_emprunter(); // Liste des objets empruntés (tableau d'IDs)
$list_categ = list_categorie();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <title>Accueil</title>
</head>

<body>
    <header class="mt-2 mb-5">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <a href="#" class="navbar-brand">
                    <span class="fs-2 fw-bold">Ebay</span>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a href="#" class="nav-link text-white">Accueil</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main>
        <!-- Formulaire de filtre -->
        <section class="mb-4">
            <div class="container d-flex justify-content-center">
                <form class="row gy-2 gx-3 align-items-center" method="post" action="trait_filtre.php">
                    <div class="col-auto">
                        <label class="visually-hidden" for="autoSizingSelect">Tri</label>
                        <select class="form-select" id="autoSizingSelect" name="cat">
                            <option selected value="0">Toutes les catégories</option>
                            <?php foreach ($list_categ as $cat): ?>
                                <option value="<?= $cat['id_categorie'] ?>"><?= htmlspecialchars($cat['nom_categorie']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary">Rechercher</button>
                    </div>
                </form>
            </div>
        </section>

        <!-- Affichage des objets -->
        <section>
            <div class="container">
                <div class="row g-4 justify-content-center">
                    <?php
                    $objets_a_afficher = isset($_SESSION['filt']) ? $_SESSION['filt'] : $list_objet;

                    foreach ($objets_a_afficher as $objet): ?>
                        <article class="col-md-3 col-sm-6 col-12">
                            <div class="card h-100">
                                <img src="../images/objets/default.jpg" class="card-img-top" alt="Image Objet">
                                <div class="card-body">
                                    <h5 class="card-title"><?= htmlspecialchars($objet['nom_objet']) ?></h5>
                                    <?php if (isset($emprunter[$objet['id_objet']])): ?>
                                        <p class="text-danger">Déjà emprunté</p>
                                        <h6 class="text-muted">Retour prévu le :
                                            <?= htmlspecialchars($emprunter[$objet['id_objet']]) ?></h6>
                                    <?php else: ?>
                                        <p class="text-success">Disponible</p>
                                    <?php endif; ?>

                                </div>
                            </div>
                        </article>
                    <?php endforeach;

                    if (isset($_SESSION['filt'])) {
                        unset($_SESSION['filt']);
                    }
                    ?>
                </div>
            </div>
        </section>
    </main>

    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>