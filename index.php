<!DOCTYPE html>
    <html lang="fr">
      <head>
        <title>Formulaire PHP</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="style.css">
      </head>
      <body>

    <?php
    // S'il y des données de postées
    if ($_SERVER['REQUEST_METHOD']=='POST') {
      // Code PHP pour traiter l'envoi de l'email
      
      $nombreErreur = 0; // Variable qui compte le nombre d'erreur
      
      // Définit toutes les erreurs possibles
      if (!isset($_POST['nom'])) {
        $nombreErreur++;
        $erreur1 = '<p>Il y a un problème avec la variable "nom".</p>';
      } else {
        if (empty($_POST['nom'])) {
          $nombreErreur++;
          $erreur2 = '<p>Vous avez oublié de donner un nom.</p>';
        }
      }
    
      if (!isset($_POST['email'])) { // Si la variable "email" du formulaire n'existe pas (il y a un problème)
        $nombreErreur++; // On incrémente la variable qui compte les erreurs
        $erreur3 = '<p>Il y a un problème avec la variable "email".</p>';
      } else { // Sinon, cela signifie que la variable existe (c'est normal)
        if (empty($_POST['email'])) { // Si la variable est vide
          $nombreErreur++; // On incrémente la variable qui compte les erreurs
          $erreur4 = '<p>Vous avez oublié de donner votre email.</p>';
        } else {
          if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $nombreErreur++; // On incrémente la variable qui compte les erreurs
            $erreur5 = '<p>Cet email ne ressemble pas un email.</p>';
          }
        }
      }
      
      if (!isset($_POST['objet'])) {
        $nombreErreur++;
        $erreur6 = '<p>Il y a un problème avec la variable "objet".</p>';
      } else {
        if (empty($_POST['objet'])) {
          $nombreErreur++;
          $erreur7 = '<p>Vous avez oublié de donner un objet.</p>';
        }
      }
    
      if (!isset($_POST['message'])) {
        $nombreErreur++;
        $erreur8 = '<p>Il y a un problème avec la variable "message".</p>';
      } else {
        if (empty($_POST['message'])) {
          $nombreErreur++;
          $erreur9 = '<p>Vous avez oublié de donner un message.</p>';
        }
      }
      
      if ($nombreErreur==0) { // S'il n'y a pas d'erreur
        // Récupération des variables et sécurisation des données
        $nom = htmlentities($_POST['nom']); // htmlentities() convertit des caractères "spéciaux" en équivalent HTML
        $email = htmlentities($_POST['email']);
        $objet = htmlentities($_POST['objet']);
        $message = htmlentities($_POST['message']);
        
        // Variables concernant l'email
        $destinataire = 'maxime.j@codeur.online'; // Adresse email du webmaster
        $sujet = '[NEW…] » Message de votre Portfolio «'; // Titre de l'email
        $contenu = '<html><head><title>Titre du message</title></head><body>';
        $contenu .= '<p>----------------------------------------------------------------------------<br>
                        Vous avez reçu un nouveau message de votre portfolio !<br>
                        ----------------------------------------------------------------------------</p>';
        $contenu .= '<p><strong>Nom</strong>:&nbsp; '.$nom.'</p>';
        $contenu .= '<p><strong>Email</strong>:&nbsp; '.$email.'</p>';
        $contenu .= '<p><strong>Objet</strong>:&nbsp; '.$objet.'</p>';
        $contenu .= '<p><strong>Message</strong>:&nbsp;<br><br> '.$message.'</p>';
        $contenu .= '</body></html>'; // Contenu du message de l'email
        
        // Pour envoyer un email HTML, l'en-tête Content-type doit être défini
        $headers = 'MIME-Version: 1.0'."\r\n";
        $headers .= 'Content-type: text/html; charset="UTF-8"'."\r\n";
        
        @mail($destinataire, $sujet, $contenu, $headers); // Fonction principale qui envoi l'email
        
        echo '<h2>Message envoyé!</h2>'; // Afficher un message pour indiquer que le message a été envoyé
      } else { // S'il y a un moins une erreur
        echo '<div style="border:1px solid #ff0000; padding:5px;">';
        echo '<p style="color:#ff0000;">Désolé, il y a eu '.$nombreErreur.' erreur(s). Voici le détail des erreurs:</p>';
        if (isset($erreur1)) echo '<p>'.$erreur1.'</p>';
        if (isset($erreur2)) echo '<p>'.$erreur2.'</p>';
        if (isset($erreur3)) echo '<p>'.$erreur3.'</p>';
        if (isset($erreur4)) echo '<p>'.$erreur4.'</p>';
        if (isset($erreur5)) echo '<p>'.$erreur5.'</p>';
        if (isset($erreur6)) echo '<p>'.$erreur6.'</p>';
        if (isset($erreur7)) echo '<p>'.$erreur7.'</p>';
        if (isset($erreur7)) echo '<p>'.$erreur8.'</p>';
        if (isset($erreur7)) echo '<p>'.$erreur9.'</p>';
        echo '</div>';
      }
    }

    $insert = "INSERT INTO formulairePhpBdd VALUE ('$nom', '$email', '$objet','$message')";
    $bdd->exec($insert);
    ?>
    
      <form id="form" method="post" action="<?php echo strip_tags($_SERVER['REQUEST_URI']); ?>">
        <p><input id="nom" type="text" name="nom" placeholder="NOM / PRENOM"></p>
        <p><input id="email" type="email" name="email" placeholder="E-MAIL"></p>
        <p><input id="objet" type="text" name="objet" placeholder="OBJET"></p>
        <textarea id="message" name="message" placeholder="MESSAGE"></textarea><br>
        <p><input id="submit" type="submit" name="submit" value="ENVOYER !"></p>
      </form>
    
      </body>
    </html>