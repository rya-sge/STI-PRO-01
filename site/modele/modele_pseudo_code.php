<?php
// ------------ Pseudo-code ---------------------
//Fonctions liée à la table PseudoCode
// -----------------------------


/*
 * @brief Sélection des pseudo-codes
 * @return objet PDOStatement
 */
function listerLesPseudoCodesParDateV()
{
    $db = getBD();
    // Création de la string pour la requête
    $requete = "SELECT id, algorithme, estValide, texte, fichier, description, dateAjout, dateModification, ROUND(AVG(valeur), 0) AS 'note_moyenne'
                FROM vPseudoCode
                    LEFT JOIN Note ON
                        vPseudoCode.id = Note.idArtefact
                WHERE estValide = TRUE
                GROUP BY id
                ORDER BY dateModification DESC;";
    // Exécution de la requete
    return $db->query($requete);
}

/*
 * @brief Sélection des pseudo-codes sur la vue vPseudoCode
 * @return objet PDOStatement
 */
function listerPseudoCodePourUnUtilisateur()
{
    $db = getBD();
    // Création de la string pour la requête
    $requete = "SELECT id, algorithme, estValide, texte, fichier, description, dateAjout, dateModification, ROUND(AVG(valeur), 0) AS 'note_moyenne' 
                FROM vPseudoCode 
                 LEFT JOIN Note ON
                        vPseudoCode.id = Note.idArtefact
                WHERE idUtilisateur_Createur ='" . $_SESSION["idUser"] . "' 
                GROUP BY id
                ORDER BY dateModification DESC;";
    // Exécution de la requete
    return $db->query($requete);
}

/*
 * @brief Sélection des pseudo-codes sur la vue vPseudoCode, appartenant à un Algorithme
 * @param idAlgorithme dont on recherche les pseudo-codes
 * @return objet PDOStatement
 */
function listePseudoCodeAlgorithmeV($idAlgorithme)
{
    $db = getBD();
    // Création de la string pour la requête
    $requete = "SELECT id, algorithme, estValide, texte, fichier, description, dateAjout, dateModification, ROUND(AVG(valeur), 0) AS 'note_moyenne'
                FROM vPseudoCode 
                  LEFT JOIN Note ON
                        vPseudoCode.id = Note.idArtefact
                WHERE idAlgorithme = $idAlgorithme 
                        && estValide = TRUE 
                GROUP BY id
                ORDER BY dateModification;";
    // Exécution de la requete
    return $db->query($requete)->fetchAll();
}

/*
 * @brief Sélection des pseudo-codes en attente de validation
 * @return objet PDOStatement
 * @details ordonnée par date croissante pour augmenter la visibilité des plus anciens pseudo-codes
 * afin qu'ils soient rapidement validé.
 */
function listePseudoCodePourValidation()
{
    $db = getBD();
    // Création de la string pour la requête
    $requete = "SELECT *
                FROM vPseudoCode 
                WHERE estValide = FALSE 
                ORDER BY dateModification;";
    // Exécution de la requete
    return $db->query($requete);
}

//Source : le code suivant, permettant d'uploader un fichier est tiré de ce site :
// http://antoine-herault.developpez.com/tutoriels/php/upload/

function ajouterFichier($fileArray, $description)
{
    $db = getBD();
    $file = $fileArray['fichierPseudoCode']['tmp_name'];
    $path = ROOT_FICHIERS . $_SESSION['idAlgorithme_artefact'] . "/pseudo-codes/";
    $extensions = EXTENSIONS_DOC;
    $hashPseudoCode = uploadFichier($path, $file, $extensions, $fileArray['fichierPseudoCode']['name']);

    $idArtefact = ajouterArtefact($_SESSION['idUser'], $_SESSION['idAlgorithme_artefact'], $description);

    try {
        // ajout du pseudo code
        $req = $db->prepare('INSERT INTO PseudoCode (idArtefact, fichier)
                VALUES (:idArtefact, :fichier)');

        $req->execute(array(
            'idArtefact' => $idArtefact,
            'fichier' => $hashPseudoCode,
        ));
    } catch (Exception $e) {
        //Si erreur lors de l'ajout du code source, alors suppression artefact car l'héritage est complete
        delArtefact($idArtefact);
        throw $e;
    }
}

/*
 * @brief Ajouter du texte
 * @param les données POST du formulaire
 * @throw Exception aucun texte ou pseudo-code n'est fourni
 * @return les tuples obtenus suite à la requête
 *
 */
function ajouterTexte($texte, $description)
{
    $db = getBD();
    $idArtefact = ajouterArtefact($_SESSION['idUser'], $_SESSION['idAlgorithme_artefact'], $description);
    // ajout du pseudo code
    $req = $db->prepare('INSERT INTO PseudoCode (idArtefact, texte)
                VALUES (:idArtefact, :texte)');

    $req->execute(array(
        'idArtefact' => $idArtefact,
        'texte' => $texte,
    ));
}


/*
 * @brief Ajouter un pseudo-code
 * @param les données POST du formulaire
 * @throw Exception aucun texte ou pseudo-code n'est fourni
 * @return les tuples obtenus suite à la requête
 *
 */
function ajoutPseudoCode($postArray)
{
    //Récupération des données passées en post
    $description = $postArray ["description"];
    $description = traitementText($description);

    if (isset($_FILES['fichierPseudoCode']) && $_FILES['fichierPseudoCode']['size'] != 0) {
        ajouterFichier($_FILES, $description);
    } else if (isset($postArray['textePseudoCode'])) {
        ajouterTexte(traitementText($postArray['textePseudoCode']), $description);
    } else {
        throw new Exception("Il manque soit un texte ou un fichier avec le pseudo-code soit votre fichier est vide");
    }
    $_SESSION['modif'] = "Le pseudo-code a été ajouté. Il est en attente de validation par un modérateur";
}

/*
 * @brief Télécharger un pseudo-code
 * @param id du pseudo-code
 * @throw Exception si le fichier n'a pas être récupéré dans la BDD
 */
function downloadPseudoCode($idPseudoCode)
{

    // Récupère le nom du fichier correspondant au pseudo-code
    $db = getBD();
    $req = $db->prepare('SELECT idAlgorithme, fichier FROM vPseudoCode WHERE id = :idArtefact;');
    $req->execute(array('idArtefact' => $idPseudoCode));
    $result = $req->fetchAll();

    if (count($result) != 1)
        throw new Exception("Erreur de récupération de l'id");

    $idAlgorithme = $result[0]['idAlgorithme'];
    $filename = $result[0]['fichier'];

    $path = ROOT_FICHIERS . $idAlgorithme . "/pseudo-codes/";

    downloadFichier($path, $filename);
}


/*
 * @brief Obtenir le pseudo-code d'un texte
 * @param id du pseudo-code
 * @return texte (résultat du fetch)
 * @throw Exception si l'id n'a pas été trouvé dans la BDD
 */
function getPseudoCodeTexte($idPseudoCode)
{
    $db = getBD();
    // Création de la string pour la requête
    $requete = "SELECT texte 
                FROM PseudoCode 
                WHERE idArtefact = $idPseudoCode";
    // Exécution de la requete
    $res = $db->query($requete);
    $ligne = $res->fetch();
    //Test le résultat
    if (empty($ligne['texte'])) {
        throw new Exception("Erreur : le pseudo-code recherché n'a pas été trouvé");
    }
    return $ligne;
}


