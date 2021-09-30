<?php
$titre = 'TheDeveloperSpellbook - pseudo-code texte';

// vue_pseudo_code_texte.php
// Date de création : 16/01/2020
// Fonction : vue pour afficher le texte d'un peudo-code
// _______________________________

// Tampon de flux stocké en mémoire
ob_start();
?>

    <article>
        <h1>Affichage du pseudo-code sélectionné</h1>
        <div class="cadre">
            <p>
                <?php echo $texte['texte']; ?>
            </p>
        </div>
    </article>
<?php
$contenu = ob_get_clean();
require "vue/gabarit.php";
?>