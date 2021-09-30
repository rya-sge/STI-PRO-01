<?php
// ------------ CodeSource ---------------------
//Fonctions liées aux requêtes sur la table CodeSource

// -----------------------------


/*
 * @brief afficher l'ensemble des codes sources VALIDES
 * @return les tuples obtenus suite à la requête
 */
function listerLesCodesSourcesValide()
{
    $db = getBD();
    // Création de la string pour la requête
    $requete = "SELECT id, algorithme, estValide, archive, documentation, idLangage, idPseudoCode,  description, dateAjout, dateModification,
                ROUND(AVG(valeur), 0) AS 'note_moyenne'
                FROM vCodeSource 
                   LEFT JOIN Note ON
                    vCodeSource.id = Note.idArtefact
                WHERE estValide = TRUE
                GROUP BY id
                ORDER BY dateModification DESC;";
    // Exécution de la requete
    return $db->query($requete);
}

// -----------------------------
/*
 * @brief Liste des codes sources reliés à l'utilisateur connecté
 * @return les tuples obtenus suite à la requête
 */
function listeCodeSourcePourUnUtilisateur()
{
    $db = getBD();
    // Création de la string pour la requête
    $requete = "SELECT id, algorithme, estValide, archive, documentation, idLangage, idPseudoCode,  description, dateAjout, dateModification,
                ROUND(AVG(valeur), 0) AS 'note_moyenne' 
                 FROM vCodeSource 
                   LEFT JOIN Note ON
                    vCodeSource.id = Note.idArtefact
                WHERE idUtilisateur_Createur ='" . $_SESSION["idUser"] . "'
                GROUP BY id 
                ORDER BY id;";
    // Exécution de la requete
    return $db->query($requete);
}

// -----------------------------
/*
 * @brief Liste des codes sources VALIDES reliés à un algorithmes
 * @param idAlgorithme id de l'algorithme dont on recherche les codes sources
 * @return les tuples obtenus suite à la requête
 */
function listeCodeSourceAlgorithme($idAlgorithme)
{
    $db = getBD();
    // Création de la string pour la requête
    $requete = "SELECT id, algorithme, archive, documentation, idLangage, idPseudoCode,  description, dateAjout, dateModification,
                ROUND(AVG(valeur), 0) AS 'note_moyenne' 
                FROM vCodeSource  
                LEFT JOIN Note ON
                    vCodeSource.id = Note.idArtefact
                WHERE 
                    idAlgorithme = '" . $idAlgorithme . "' 
                        AND estValide = True
                GROUP BY id
                ORDER BY dateModification DESC;";
    // Exécution de la requete
    return $db->query($requete);
}

/*
 * @brief Obtenir les informations d'un code source
 * @return tuple contenant les informations (résultat du fetch)
 *
 */
function infoMesCodeSource($idCodeSource)
{
    $db = getBD();
    // Création de la string pour la requête
    $requete = "SELECT id, idLangage, archive, documentation, description 
                FROM vCodeSource 
                WHERE id = '" . $idCodeSource . "' 
                    AND idUtilisateur_Createur = '" . $_SESSION['idUser'] . "';";
    // Exécution de la requete
    $res = $db->query($requete);
    return $res->fetch();
}

// -----------------------------
/*
 * @brief Liste des codes sources en attente de validation
 * @return les tuples obtenus suite à la requête
 *
 */
function listeCodeSourceValidation()
{
    $db = getBD();
    // Création de la string pour la requête
    $requete = "SELECT * 
                FROM vCodeSource 
                WHERE estValide = FALSE 
                ORDER BY id;";
    // Exécution de la requete
    return $db->query($requete);
}


/*
 * @brief Ajouter un code source au site
 * @param array contenant les informations du fichier
 * Source : le code suivant, permettant d'uploader un fichier est tiré de ce site :
    http://antoine-herault.developpez.com/tutoriels/php/upload/
 *
 */
function ajouterFichierCodeSource($fileArray)
{
    $file = $fileArray['fichierCodeSource']['tmp_name'];
    $path = ROOT_FICHIERS . $_SESSION['idAlgorithme_artefact'] . "/codes-sources/";
    $extensions = EXTENSIONS_FILE;
    $hashCodeSource = uploadFichier($path, $file, $extensions, $fileArray['fichierCodeSource']['name']);
    return $hashCodeSource;
}

/*
 * @brief Ajouter une documentation au dossier du site
 * @param array contenant les informations du fichier
 *
 */
function ajouterFichierDocumentation($fileArray)
{
    $file = $fileArray['fichierDocumentation']['tmp_name'];
    $path = ROOT_FICHIERS . $_SESSION['idAlgorithme_artefact'] . "/codes-sources/";
    $extensions = EXTENSIONS_DOC;
    $hashDocumentation = uploadFichier($path, $file, $extensions, $_FILES['fichierDocumentation']['name']);
    return $hashDocumentation;
}

// -----------------------------
/*
 * @brief Ajouter un code source
 * @param les données POST du formulaire
 * @throw exception, notamment si aucun fichier n'est fourni
 * @return les tuples obtenus suite à la requête
 *
 */
function ajoutCodeSource($postArray)
{
    $db = getBD();

    //Récupération des données passées en post
    $description = $postArray ["description"];
    $description = traitementText($description);
    erreurXss($description);
    testId($postArray ["idLangage"]);
    $hashDocumentation = NULL;

    if (!isset($postArray ["idLangage"])) {
        throw new Exception("Langage ne peut être NULL");
    }

    if (isset($_FILES['fichierCodeSource']) && $_FILES['fichierCodeSource']['size'] != 0) {
        $hashCodeSource = ajouterFichierCodeSource($_FILES);
    } else {
        throw new Exception("Erreur : Veuillez fournir un fichier.");
    }

    if (isset($_FILES['fichierCodeSource']) && $_FILES['fichierDocumentation']['size'] != 0) {
        $hashDocumentation = ajouterFichierDocumentation($_FILES);
    }
    //Fin de la source
    $idArtefact = ajouterArtefact($_SESSION['idUser'], $_SESSION['idAlgorithme_artefact'], $description);
    // ajout Du code Source
    try {
        $req = $db->prepare('INSERT INTO CodeSource (idArtefact, idLangage, archive, documentation)
            VALUES (:idArtefact, :idLangage, :archive, :documentation)');
        $req->execute(array(
            'idArtefact' => $idArtefact,
            'idLangage' => $postArray ["idLangage"],
            'archive' => $hashCodeSource,
            'documentation' => $hashDocumentation

        ));
        $_SESSION['modif'] = "Le code source a été ajouté. Il est en attente de validation par un modérateur";
    } catch (Exception $e) {
        //Si erreur lors de l'ajout du code source, alors suppression artefact car l'héritage est complete
        delArtefact($idArtefact);
        throw $e;
    }
}


// -----------------------------
/*
 * @brief Télécharger un code source
 * @param id du code source
 * @type du document archive ou non
 * @throw Exception si le fichier n'a pas être récupéré dans la BDD
 */
function downloadCodeSource($idCodeSource, $type)
{
    // Récupère le nom du fichier correspondant au pseudo-code
    $db = getBD();

    if ($type == "archive") {
        $req = $db->prepare('SELECT idAlgorithme, archive from vCodeSource WHERE id = :idArtefact;');
    } else {
        $req = $db->prepare('SELECT idAlgorithme, documentation from vCodeSource WHERE id = :idArtefact;');
    }


    $req->execute(array('idArtefact' => $idCodeSource));
    $result = $req->fetchAll();

    if (count($result) != 1) {
        throw new Exception("Erreur de récupération de l'id");
    }


    $idAlgorithme = $result[0]['idAlgorithme'];
    $filename = $result[0][$type];
    $path = ROOT_FICHIERS . $idAlgorithme . "/codes-sources/";
    downloadFichier($path, $filename);
}

/*
 * @brief Modifier un code source
 * @param id du code source à modifier
 * @param postArray donnée POST du formulaire
 * @return objet PDOStatement
 */
function updateCodeSource($id, $postArray)
{
    $db = getBD();

    $hashDocumentation = NULL;
    $hashCodeSource = NULL;
    if (!isset($postArray ["idLangage"])) {
        throw new Exception("Langage ne peut être NULL");
    }
    testId($postArray ["idLangage"]);
    if (isset($_FILES['fichierCodeSource']) && $_FILES['fichierCodeSource']['size'] != 0) {
        $hashCodeSource = ajouterFichierCodeSource($_FILES);
    } else {
        throw new Exception("Erreur : Veuillez fournir un fichier.");
    }
    if (isset($_FILES['fichierCodeSource']) && $_FILES['fichierDocumentation']['size'] != 0) {
        $hashDocumentation = ajouterFichierDocumentation($_FILES);
    }
    $description = traitementText($postArray ["description"]);
    {
        updateArtefact($id, $description);
    }
    // Création de la string pour la requête
    if (!empty($hashDocumentation)) {
        $req = $db->prepare("UPDATE CodeSource 
                                        SET idLangage =:idLangage, archive =:archive, documentation =:documentation 
                                        WHERE idArtefact = '" . $id . "';");
        $req->execute(array(
            'idLangage' => $postArray ["idLangage"],
            'archive' => $hashCodeSource,
            'documentation' => $hashDocumentation
        ));
    } else {
        $req = $db->prepare("UPDATE CodeSource 
                                        SET idLangage =:idLangage, archive =:archive
                                       WHERE idArtefact = '" . $id . "';");
        $req->execute(array(
            'idLangage' => $postArray ["idLangage"],
            'archive' => $hashCodeSource,
        ));

    }
    if ($req->rowCount()) {
        $_SESSION['modif'] = "Le code source a été mis à jour. La modification doit être validée par un modérateur.";
    } else {
        throw new Exception("Erreur : le code source n'a pas pu être mis à jour");
    }
}


/*
 * @brief Attacher un pseudo code à un code source
 * @param id du pseudo code
 * @param id du code source
 * @return objet PDOStatement
 */
function attachPseudoCode($idPseudoCode, $idCodeSource)
{
    $db = getBD();

    $req = "UPDATE CodeSource 
            SET idPseudoCode = " . $idPseudoCode . " 
            WHERE idArtefact = '" . $idCodeSource . "';";
    $req = $db->query($req);

    if ($req->rowCount()) {
        $_SESSION['modif'] = "Le code source a été mis à jour. La modification doit être validée par un modérateur.";
    } else {
        throw new Exception("Erreur : le code source n'a pas pu être mis à jour");
    }
}

