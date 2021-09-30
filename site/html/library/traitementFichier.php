<?php
// ------------ Traitement de fichier ---------------------
//Fonctions de traitements de fichiers

/**
 * @param $path
 * @param $fileServer
 * @param $extensions liste des extensions autorisées
 * @param $nomFichier
 * @return string
 * @throws Exception
 */
function uploadFichier($path, $fileServer, $extensions, $nomFichier)
{
    if (file_exists($path) == false) {
        mkdir($path, 0777, true);
    }
    $filename = basename($nomFichier);
    $taille_maxi = 104857600;//100 mo
    $taille = filesize($fileServer);

    $extension = strrchr($nomFichier, '.');
    //Début des vérifications de sécurité
    if (!in_array($extension, $extensions)) //Si l'extension n'est pas dans le tableau
    {
        throw new Exception("L'extension n'est pas acceptée");
    }
    if ($taille > $taille_maxi) {
        throw new Exception("Le fichier est trop gros...");
    }
    if (!isset($erreur)) //S'il n'y a pas d'erreur, on upload
    {
        $filename = hash_file('md5', $fileServer);
        //file_exists($path.$filename) == true
        //TODO: Vérification de l'existance du fichier ?
        if (false) {
            throw new Exception("Un fichier du même nom existe déjà");
            exit();
        } else {
            //Si la fonction renvoie TRUE, c'est que ça a fonctionné
            if (move_uploaded_file($fileServer, $path . $filename . $extension)) {
                //move_uploaded_file($fileServer, $path . $filename);
            } else //Sinon (la fonction renvoie FALSE).
            {
                throw new Exception("Echec de l'upload !");
            }
        }
    }
    return $filename . $extension;
}

/**
 * @param $path
 * @param $filename
 * @throws Exception
 */
function downloadFichier($path, $filename)
{

    // Source : https://www.php.net/manual/en/function.readfile.php
    $fullpath = $path . $filename;
    echo "'" . $path . "'  -> " . $filename;

    if (file_exists($fullpath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($filename));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . filesize($fullpath));
        ob_clean();
        flush();
        readfile($fullpath);
        exit;
    } else {
        throw new Exception("Le fichier n'existe pas");
    }
}

?>