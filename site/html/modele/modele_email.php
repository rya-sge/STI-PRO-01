<?php
    function listMailInbox()
    {
        $db = getBD();
        // Création de la string pour la requête
        $requete = "SELECT * from message
                    WHERE
                    recipient  = '" . $_SESSION["idUser"] . "'
                    ORDER BY dateReceipt DESC;";
        // Exécution de la requete
        return $db->query($requete);
    }

    function getMessageContent($idMessage)
        {
            $db = getBD();
            // Création de la string pour la requête
            $requete = "SELECT * from message
                        WHERE
                        recipient  = '" . $_SESSION["idUser"] . "'
                        AND id = $idMessage;";
            // Exécution de la requete
            return $db->query($requete)->fetch();
        }
?>


