<?php
require_once 'config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validation des données
    $requiredFields = ['name', 'email', 'subject', 'message'];
    
    $missingFields = [];
    foreach ($requiredFields as $field) {
        if (!isset($_POST[$field]) || empty($_POST[$field])) {
            $missingFields[] = $field;
        }
    }

    if (!empty($missingFields)) {
        $_SESSION['error'] = "Veuillez remplir tous les champs obligatoires";
        header('Location: index.php#contact');
        exit();
    }

    // Validation de l'email
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Format d'email invalide";
        header('Location: index.php#contact');
        exit();
    }

    try {
        $conn = getConnection();

        // Préparation et exécution de la requête
        $stmt = $conn->prepare("
            INSERT INTO contact_messages (name, email, subject, message)
            VALUES (?, ?, ?, ?)
        ");

        $stmt->execute([
            filter_var($_POST['name'], FILTER_SANITIZE_STRING),
            filter_var($_POST['email'], FILTER_SANITIZE_EMAIL),
            filter_var($_POST['subject'], FILTER_SANITIZE_STRING),
            filter_var($_POST['message'], FILTER_SANITIZE_STRING)
        ]);

        // Envoi d'un email de confirmation
        $to = $_POST['email'];
        $subject = "Confirmation de votre message - FIMAC";
        $message = "Bonjour " . $_POST['name'] . ",\n\n";
        $message .= "Nous avons bien reçu votre message concernant \"" . $_POST['subject'] . "\".\n";
        $message .= "Notre équipe vous répondra dans les plus brefs délais.\n\n";
        $message .= "Cordialement,\n";
        $message .= "L'équipe FIMAC";
        $headers = "From: contact@fimac.edu";

        mail($to, $subject, $message, $headers);

        // Envoi d'une notification à l'administrateur
        $adminEmail = "admin@fimac.edu";
        $adminSubject = "Nouveau message de contact - FIMAC";
        $adminMessage = "Un nouveau message a été reçu :\n\n";
        $adminMessage .= "De : " . $_POST['name'] . " (" . $_POST['email'] . ")\n";
        $adminMessage .= "Sujet : " . $_POST['subject'] . "\n\n";
        $adminMessage .= "Message :\n" . $_POST['message'];

        mail($adminEmail, $adminSubject, $adminMessage, $headers);

        $_SESSION['success'] = "Votre message a été envoyé avec succès ! Nous vous répondrons dans les plus brefs délais.";
    } catch(PDOException $e) {
        error_log("Erreur lors de l'enregistrement du message : " . $e->getMessage());
        $_SESSION['error'] = "Une erreur est survenue lors de l'envoi du message";
    }

    header('Location: index.php#contact');
    exit();
} else {
    header('Location: index.php');
    exit();
}
?>
