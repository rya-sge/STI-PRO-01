<?php
define("ROOT_ERREUR", "vue/erreur");
// modele.php
// Fonction : modele avec connexion avec le serveur et la BD
//            exécution des requêtes
// ____________________________________________________________


// -----------------------------------------------------
// Fonctions liées aux utilisateurs

// -----------------------------
// getIdUser($login)
//argument : le login de l'utilisateur
// Fonction : Récupère l'id d'un utilisateur à partir de son login
//Utilisée dans la fonction : ajoutActivite
// Sortie : $idUser['idUser']. Il s'agit de l'id de l'utilisateur
function getIdUser($login)
{
    $db = getBD();
    // Création de la string pour la requête
    $requete = "SELECT id 
                FROM Utilisateur 
                WHERE nom='" . $login . "' 
                    OR email='" . $login . "'";
    // Exécution de la requete
    $resultats = $db->query($requete);
    $idUser = $resultats->fetch();
    return $idUser['id'];
}


/*
 * @brief  Met à jour le rôle d'un utilisateur spécifié par son nom.
 * @param nom nom utilisateur
 * @param idRole nouveau Rôle
 */
function updateRoleByName($nom, $idRole)
{
    $db = getBD();
    // Création de la string pour la requête
    $requete = $db->prepare("UPDATE Utilisateur
                                       SET idRole = '" . $idRole . "'
                                       WHERE nom = '" . $nom . "'
                                       AND id !='" . $_SESSION['idUser'] ."'
                                       AND id != 1;");
    // Exécution de la requete
    $requete->execute();
    if ($requete->rowCount()) {
        $_SESSION['modif'] = "Le rôle de l'utilisateur a été modifié";
    } else {
        $_SESSION['modif'] = "Erreur : le rôle n'a pas pu être modifié";
    }
}

/*
 * @brief Met à jour le rôle d'un utilisateur spécifié par son ID
 * @param idUtilisateur de l'utilisateur
 * @param idRole nouveau Rôle
 */
function updateRoleById($idUtilisateur, $idRole)
{
    $db = getBD();
    // Création de la string pour la requête
    $requete = $db->prepare("UPDATE Utilisateur
                                        SET idRole = '" . $idRole . "'
                                       WHERE id = '" . $idUtilisateur . "'");
    // Exécution de la requete
    $requete->execute();
    if ($requete->rowCount()) {
        $_SESSION['modif'] = "Le rôle de l'utilisateur a été modifié";
    } else {
        $_SESSION['modif'] = "Erreur : le rôle n'a pas pu être modifié";
    }
}

// -----------------------------
/*
 * @brief  contient la requête permettant d'avoir toutes les informations de l'utilisateur passé en paramètre
 * @param le login de l'utilisateur
 * @return $resultats. Il s'agit d'jeu de résultats retourné en tant qu'objet PDOStatement
 */
function getUserByLogin($login)
{
    $db = getBD();
    // Création de la string pour la requête
    $requete = "SELECT * 
                FROM Utilisateur 
                WHERE nom ='" . $login . "'";
    // Exécution de la requete
    return $db->query($requete);
}


// -----------------------------
// infoUtilisateur()
/*
 * @brief Récupère les infos de l'utilisateur connecté
 * @return $infoUser Les informations de l'utilisateur
 */
function infoUtilisateur()
{
    $db = getBD();
    //Initialisation du tableau qui va contenir les informations de l'utilisateur.
    $infoUser = array(
        'email' => "",
    );
    $reponse = getUserByLogin($_SESSION['login']);
    $donnees = $reponse->fetch();
    //Insère dans le tableau précédemment crée les informations de l'utilisateur
    if (empty($donnees['nom'])) {
        throw new Exception("Le nom d'utilisateur n'existe pas");
    }
    $infoUser = array(
        'email' => $donnees['email'],
    );
    return $infoUser;//Retourne le tableau contenant les informations de l'utilisateur
}

// -----------------------------
/*
 * @brief  Contrôle de login
 * @return $infoUser. COntient les informations de base de l'utilisateur (email, id et login)
 * @param les informations passées en POST
 */
function checkLogin($postArray)
{
    $username = $postArray ["fLogin"];
    $passwdPost = $postArray["fPasswd"];
    erreurUrl($username);
    $resultats = getUserByLogin($username);
    $resultats = $resultats->fetch();
    if (empty($resultats['nom'])) {
        throw new Exception("Les données d'authentification sont incorrectes");
    }
    $hash = $resultats['motDePasse'];
    if (password_verify($passwdPost, $hash)) {
        //Initialisation du tableau qui va contenir les informations de l'utilisateur.
        $infoUser = array(
            'email' => $resultats['email'],
            'idUser' => $resultats['id'],
            'login' => $resultats['nom'],
            'idRole' => $resultats['idRole'],
        );
    } else {
        throw new Exception("Les données d'authentification sont incorrectes");
    }
    return @$infoUser;//renvoie certaines infos de l'utilisateur
}

// -----------------------------
/*
 * @brief  Ajouter un utilisateur
 * @param les informations passées en POST
 */
function ajoutUser($postArray)
{
    $db = getBD();
    //https://www.grafikart.fr/forum/topics/14831
    $email = $_POST['fEmail'];
    $login = $postArray ["fLogin"];
    $passwdPost = $postArray["fPasswd"];
    $passwdConf = $postArray['fPasswdConf'];
    $erreur = false;
    //Affiche un message d'erreur si la fonction htmlspecialchars a effectué des remplacements de caractères pour le mot de passe (pour éviter faille xss)

    //Test des formulaires
    champVide($login, "Login");
    champVide($email, "Email");
    champVide($passwdPost, "Mot de passe");
    champVide($passwdConf, "Confirmer votre mot de passe");
    erreurXss($login);
    erreurXss($email);
    verifEmail($email);
    longChampValid($email, "Adresse email", 254);
    longChampValid($login, "Nom d'utilisateur/login", 30);

    erreurPasswd($passwdConf, $passwdPost);
    //Source pour le test de la validation d'adresse email : http://php.net/manual/fr/filter.examples.validation.php
    //Hashage mdp
    $passwdHash = password_hash($passwdPost, PASSWORD_DEFAULT);
    $passwd = $passwdHash;
    $dateInscription = date('Y-m-d H:i:s'); //Source : http://www.pontikis.net/tip/?id=18
    // test si le login ou l'email existe déjà pour éviter qu'il y ait deux utilisateurs ayant le même login ou la même adresse email
    $reqSelect = "SELECT * 
                 FROM Utilisateur 
                 WHERE nom='" . $login . "'
                    OR email='" . $email . "';";
    $res = $db->query($reqSelect);
    $ligne = $res->fetch(); // récupère la valeur du login sélectionné s'il y en a un
    // Test le résultat
    if (empty($ligne['nom'])) {
        // ajout de l'utilisateur
        $req = $db->prepare('INSERT INTO Utilisateur (nom, email, motDePasse, dateInscription)
                    VALUES (:nom, :email, :motDePasse,:dateInscription)');
        $req->execute(array(
            'nom' => $login,
            'email' => $email,
            'motDePasse' => $passwd,
            'dateInscription' => $dateInscription,

        ));
    } else {
        throw new Exception("L'utilisateur ne peut pas être ajouté car il existe déjà.");
    }
}


// -----------------------------
/*
 * @brief  Permet de changer le mot de passe
 * @param les informations passées en POST
 */
function changePasswd($postArray)
{
    $passwdOld = $postArray['fPasswdOld'];
    $NPasswdPost = $postArray['fNPasswdPost'];
    $NPasswdConf = $postArray['fNPasswdConf'];
    $db = getBD();
    //Sélection du mot de passe de l'utilisateur dans la BDD
    $requete = "SELECT motDePasse 
              FROM Utilisateur 
              WHERE nom ='" . $_SESSION['login'] . "';";
    $resultats = $db->query($requete);
    $passwd = $resultats->fetch();

    if (!empty($resultats)) {
        //erreurPasswd($NPasswdConf,$NPasswdPost); //Vérifie que les mots de passes correspondent et soient assez long
        erreurPasswd($NPasswdConf, $NPasswdPost);
        $hash = $passwd['motDePasse'];
        if (password_verify($passwdOld, $hash)) //Vérification du mot de passe
        {
            $passwdHash = password_hash($NPasswdPost, PASSWORD_DEFAULT); //Hachage du mot de passe
            $passwd = $passwdHash;
            //Mise à jour des informations
            $req = $db->prepare("UPDATE Utilisateur SET motDePasse=:motDePasse 
                WHERE id='" . $_SESSION['idUser'] . "';");
            $req->execute(array(
                'motDePasse' => $passwd,
            ));
            $_SESSION['modif'] = "Votre mot de passe a été modifié";
        } else {
            throw new Exception("Les données d'authentification sont incorrectes");
        }
    } else {
        throw new Exception("Les données d'authentification sont incorrectes");
    }
}

// -----------------------------
/*
 * @brief   Permet de changer le login
 * @details Ne fait rien si le nouveau login est identique au précédent
 */
function changeLogin($postArray)
{
    $db = getBD();
    $NLogin = $postArray ["fNLogin"];
    champVide($NLogin, "Nom d'utilisateur/login");
    erreurXss($NLogin);
    longChampValid($NLogin, "Nom d'utilisateur/login", 30);
    if ($NLogin != $_SESSION['login']) {
        // test si le login ou l'email existe déjà pour éviter qu'il y ait deux utilisateurs ayant le même login
        $reqSelect = "SELECT * 
                     FROM Utilisateur 
                     WHERE nom='" . $NLogin . "' 
                        AND nom !='" . $_SESSION['login'] . "';";
        $res = $db->query($reqSelect);
        $ligne = $res->fetch(); // récupère la valeur du login sélectionné s'il y en a un
        // Test le résultat
        if (empty($ligne['nom'])) {
            //Mise à jour des informations
            $req = $db->prepare("update Utilisateur set nom=:nom 
            WHERE id='" . $_SESSION['idUser'] . "';");
            $req->execute(array(
                'nom' => $NLogin,
            ));
            $_SESSION['login'] = $NLogin;
            $_SESSION['modif'] = "Votre nom d'utilisateur a été modifié";
        } else {
            throw new Exception("Ce login est déjà utilisé");
        }
    }

}


/*
 * @brief  Permet de modifier l'email d'un utilisateur
 * @details Ne fait rien si le nouvel email est identique à l'actuel
 */
function changeEmail()
{
    $db = getBD();

    $NEmail = $_POST['fNEmail'];
    champVide($NEmail, "Adresse email");
    erreurXss($NEmail);
    verifEmail($NEmail);
    longChampValid($NEmail, "Adresse email", 45);
    if ($NEmail != $_SESSION['email']) {
        // test si l'email existe déjà pour éviter qu'il y ait deux utilisateurs ayant la même adresse email
        $reqSelect = "SELECT * 
                     FROM Utilisateur 
                     WHERE email='" . $NEmail . "' ;";
        $res = $db->query($reqSelect);
        $ligne = $res->fetch(); // récupère l'utilisateur sélectionné s'il y en a un
        // Test le résultat
        if (empty($ligne['id'])) {
            $req = $db->prepare("UPDATE Utilisateur SET email=:email
                WHERE id='" . $_SESSION['idUser'] . "';");
            $req->execute(array(
                'email' => $NEmail,
            ));
            $_SESSION['modif'] = "Votre adresse email a été modifié";
        } else {
            throw new Exception("Cet email est déjà utilisé");
        }
    } else {
        throw new Exception("La nouvelle adresse email est identique à l'ancienne");
    }
}

// -----------------------------
/*
 * @brief  Permet de supprimer un utilisateur
 * @param L'id de l'utilisateur à supprimer
 */
function delUser($idUser)
{
    $db = getBD();
    $requete = 'DELETE FROM Utilisateur 
                WHERE id ="' . $idUser . '";';
    $db->exec($requete);
}