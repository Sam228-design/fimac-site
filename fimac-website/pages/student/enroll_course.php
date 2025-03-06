<?php
session_start();
require_once '../../auth/auth.php';
require_once '../../config/database.php';

$auth = new Auth();
$auth->requireStudent();

$user = $auth->getCurrentUser();
$conn = getConnection();

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['course_id'])) {
    $_SESSION['error'] = "Requête invalide.";
    header('Location: courses.php');
    exit;
}

$courseId = intval($_POST['course_id']);

try {
    // Vérifier que le cours existe et correspond à la filière/niveau de l'étudiant
    $stmt = $conn->prepare("
        SELECT id 
        FROM courses 
        WHERE id = ? 
        AND filiere = ? 
        AND niveau = ? 
        AND published = 1
    ");
    $stmt->execute([$courseId, $user['filiere'], $user['niveau']]);
    
    if (!$stmt->fetch()) {
        throw new Exception("Ce cours n'est pas disponible pour votre filière/niveau.");
    }

    // Vérifier que l'étudiant n'est pas déjà inscrit
    $stmt = $conn->prepare("
        SELECT id 
        FROM course_enrollments 
        WHERE course_id = ? 
        AND student_id = ?
    ");
    $stmt->execute([$courseId, $user['id']]);
    
    if ($stmt->fetch()) {
        throw new Exception("Vous êtes déjà inscrit(e) à ce cours.");
    }

    // Inscrire l'étudiant au cours
    $stmt = $conn->prepare("
        INSERT INTO course_enrollments (
            course_id, student_id, status, 
            enrollment_date, created_at, updated_at
        ) VALUES (
            ?, ?, 'active',
            NOW(), NOW(), NOW()
        )
    ");
    $stmt->execute([$courseId, $user['id']]);

    $_SESSION['success'] = "Vous êtes maintenant inscrit(e) à ce cours.";

} catch (Exception $e) {
    $_SESSION['error'] = $e->getMessage();
}

header('Location: courses.php');
exit;
?>
