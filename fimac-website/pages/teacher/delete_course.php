<?php
session_start();
require_once '../../auth/auth.php';
require_once '../../config/database.php';

$auth = new Auth();
$auth->requireTeacher();

$user = $auth->getCurrentUser();
$conn = getConnection();

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['course_id'])) {
    $_SESSION['error'] = "Requête invalide.";
    header('Location: courses.php');
    exit;
}

$courseId = intval($_POST['course_id']);

try {
    // Vérifier que le cours appartient bien au professeur
    $stmt = $conn->prepare("SELECT id FROM courses WHERE id = ? AND teacher_id = ?");
    $stmt->execute([$courseId, $user['id']]);
    
    if (!$stmt->fetch()) {
        throw new Exception("Vous n'avez pas l'autorisation de supprimer ce cours.");
    }

    $conn->beginTransaction();

    // Supprimer les inscriptions au cours
    $stmt = $conn->prepare("DELETE FROM course_enrollments WHERE course_id = ?");
    $stmt->execute([$courseId]);

    // Supprimer les devoirs liés au cours
    $stmt = $conn->prepare("SELECT id FROM assignments WHERE course_id = ?");
    $stmt->execute([$courseId]);
    $assignments = $stmt->fetchAll(PDO::FETCH_COLUMN);

    if (!empty($assignments)) {
        // Supprimer les soumissions de devoirs
        $placeholders = str_repeat('?,', count($assignments) - 1) . '?';
        $stmt = $conn->prepare("DELETE FROM assignment_submissions WHERE assignment_id IN ($placeholders)");
        $stmt->execute($assignments);

        // Supprimer les devoirs
        $stmt = $conn->prepare("DELETE FROM assignments WHERE course_id = ?");
        $stmt->execute([$courseId]);
    }

    // Supprimer les documents du cours
    $stmt = $conn->prepare("SELECT file_path FROM course_materials WHERE course_id = ?");
    $stmt->execute([$courseId]);
    $materials = $stmt->fetchAll(PDO::FETCH_COLUMN);

    foreach ($materials as $material) {
        $fullPath = "../../" . ltrim($material, '/');
        if (file_exists($fullPath)) {
            unlink($fullPath);
        }
    }

    $stmt = $conn->prepare("DELETE FROM course_materials WHERE course_id = ?");
    $stmt->execute([$courseId]);

    // Supprimer l'image du cours si elle existe
    $stmt = $conn->prepare("SELECT image_path FROM courses WHERE id = ?");
    $stmt->execute([$courseId]);
    $imagePath = $stmt->fetchColumn();

    if ($imagePath) {
        $fullPath = "../../" . ltrim($imagePath, '/');
        if (file_exists($fullPath)) {
            unlink($fullPath);
        }
    }

    // Supprimer le dossier du cours
    $courseDir = "../../uploads/courses/{$courseId}";
    if (file_exists($courseDir)) {
        // Supprimer récursivement le dossier et son contenu
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($courseDir, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::CHILD_FIRST
        );

        foreach ($files as $fileinfo) {
            if ($fileinfo->isDir()) {
                rmdir($fileinfo->getRealPath());
            } else {
                unlink($fileinfo->getRealPath());
            }
        }

        rmdir($courseDir);
    }

    // Supprimer le cours
    $stmt = $conn->prepare("DELETE FROM courses WHERE id = ?");
    $stmt->execute([$courseId]);

    $conn->commit();
    $_SESSION['success'] = "Le cours a été supprimé avec succès.";

} catch (Exception $e) {
    $conn->rollBack();
    $_SESSION['error'] = "Une erreur est survenue lors de la suppression du cours : " . $e->getMessage();
}

header('Location: courses.php');
exit;
?>
