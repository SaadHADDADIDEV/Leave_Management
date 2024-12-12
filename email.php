<?php
session_start();
include('includes/config.php');
// Charger la librairie PHPMailer
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';
require 'phpmailer//src/Exception.php';
// require 'template/phpmailer/OAuth.php';
// require 'template/phpmailer/OAuthTokenProvider.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


$id = $_SESSION['eid'];
$sql = 'SELECT * FROM `tblemployees` WHERE id=' . "$id";
$query = $dbh->prepare($sql);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);
foreach ($results as $result) {
    $nom = $result->FirstName . " " . $result->LastName;
}




//Fonction pour générer un code de confirmation aléatoire
// function generateConfirmationCode()
// {
//     $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
//     $code = '';
//     for ($i = 0; $i < 6; $i++) {
//         $code .= $characters[rand(0, strlen($characters) - 1)];
//     }
//     return $code;
// }

// Récupérer l'adresse email de l'utilisateur depuis un formulaire
$email = 'haddadisaad10@gmail.com';
// Générer un code de confirmation
// $code = generateConfirmationCode();
// Configurer les paramètres d'envoi d'email

// Envoi de l'e-mail
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo '<div class="container-scroller">';
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'haddadisaad41@gmail.com'; // copmte li ghadi tsifet mno lmessage
    $mail->Password = 'achcfgatmrjzeakm'; // katakhdo mn app password
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;
    $mail->setFrom('haddadisaad41@gmail.com'); // email li ghadi tsifet mno
    $mail->addAddress($email); // compte fin ghadii ywsal lmessage
    $mail->Subject = 'Demande de conge '; // sujet de l'email
    $leavetype = $_POST["leavetype"];
    $fromdate = $_POST["fromdate"];
    $fromdate = $_POST["fromdate"];
    $todate = $_POST["todate"];

    // Convertir les chaînes de caractères en objets DateTime
    $dateDebut = new DateTime($fromdate);
    $dateFin = new DateTime($todate);

    // Calculer la différence entre les deux dates
    $difference = $dateDebut->diff($dateFin);

    // Obtenir le nombre de jours à partir de l'objet DateInterval
    $dureeConge = $difference->days;
    $mail->Body = 'Monsieur ' . $nom . ' (' . $id . ')' . ' demande congé de type ' . $leavetype . ' d\'une durée de ' . $dureeConge . ' jours, du ' . $dateDebut->format('d/m/Y') . ' au ' . $dateFin->format('d/m/Y');

    $mail->send();
} else {
    echo 'Ce n\'est pas le début du mois.';
}
