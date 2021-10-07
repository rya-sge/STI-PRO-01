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
/*
* @brief Ajouter un boiteMail
* @param Donnée POST du formulaire
* @details
* Source utilisée pour le traitement des checkbox : https://makitweb.com/get-checked-checkboxes-value-with-php/
*/
function addMessageBdd($postArray)
{
    $db = getBD();
    //Récupération des données passées en post
    $subject = $postArray ["subject"];
    $body = $postArray ["body"];
    $recipient = $postArray ["recipient"];
    try{
        $req = $db->prepare('INSERT INTO message (sender, recipient, subject, body)
                                      VALUES (:sender, :recipient, :subject, :body)');
        $req->execute(array(
            'sender' => $_SESSION['idUser'],
            'recipient' => 1,
            'subject' => $subject,
            'body' => $body,
        ));
        $_SESSION['modif'] = "Le message a été envoyé.";
    } catch(Exception $e){
        throw new Exception("Erreur : le message n'a pas pu être envoyé");
    }
}
?>


