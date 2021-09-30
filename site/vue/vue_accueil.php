<?php
$titre = 'TheDeveloperSpellbook - Accueil';

// vue_accueil.php
// Date de création : 24/12/2020
// Fonction : vue pour l'affichage page d'accueil
// _______________________________

// Tampon de flux stocké en mémoire
ob_start();
?>

    <article>
        <h1>Page d'accueil</h1>
        <div class="cadre">
            <p>
                Bonjour ! Vous êtes connecté en tant que <?php echo $_SESSION['login']; ?>
            </p>
        </div>
        </div>

    </article>
<?php
$contenu = ob_get_clean();
require "gabarit.php";