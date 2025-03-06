<?php
session_start();
require_once '../../auth/auth.php';
require_once '../../config/database.php';

$auth = new Auth();
$auth->requireTeacher();

$user = $auth->getCurrentUser();
$conn = getConnection();

// Validation des données
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['error'] = "Méthode non autorisée.";
    header('Location: create_course.php');
    exit;
}

// Récupération et validation des données du formulaire
$title = trim($_POST['title'] ?? '');
$filiere = trim($_POST['filiere'] ?? '');
$niveau = trim($_POST['niveau'] ?? '');
$description = trim($_POST['description'] ?? '');
$content = trim($_POST['content'] ?? '');
$published = isset($_POST['published']) ? 1 : 0;

// Validation des champs obligatoires
if (empty($title) || empty($filiere) || empty($niveau) || empty($description)) {
    $_SESSION['error'] = "Tous les champs obligatoires doivent être remplis.";
    header('Location: create_course.php');
    exit;
}

try {
    $conn->beginTransaction();

    // Insertion du cours
    $stmt = $conn->prepare("
        INSERT INTO courses (
            title, filiere, niveau, description, content, 
            teacher_id, published, created_at, updated_at
        ) VALUES (
            ?, ?, ?, ?, ?, 
            ?, ?, NOW(), NOW()
        )
    ");

    $stmt->execute([
        $title, $filiere, $niveau, $description, $content,
        $user['id'], $published
    ]);

    $courseId = $conn->lastInsertId();

    // Traitement de l'image du cours
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $imageInfo = getimagesize($_FILES['image']['tmp_name']);
        if ($imageInfo === false) {
            throw new Exception("Le fichier téléchargé n'est pas une image valide.");
        }

        // Vérification du type MIME
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($imageInfo['mime'], $allowedTypes)) {
            throw new Exception("Type d'image non autorisé. Utilisez JPG, PNG ou GIF.");
        }

        // Vérification de la taille (2MB max)
        if ($_FILES['image']['size'] > 2 * 1024 * 1024) {
            throw new Exception("L'image est trop volumineuse. Taille maximale : 2MB");
        }

        // Création du dossier si nécessaire
        $uploadDir = "../../uploads/courses/{$courseId}/";
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Génération d'un nom de fichier unique
        $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $imageName = "course_image." . $extension;
        $imagePath = $uploadDir . $imageName;

        // Déplacement du fichier
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
            throw new Exception("Erreur lors du téléchargement de l'image.");
        }

        // Mise à jour du chemin de l'image dans la base de données
        $stmt = $conn->prepare("UPDATE courses SET image_path = ? WHERE id = ?");
        $stmt->execute(["/uploads/courses/{$courseId}/" . $imageName, $courseId]);
    }

    // Traitement des documents du cours
    if (isset($_FILES['materials']) && is_array($_FILES['materials']['name'])) {
        $allowedTypes = [
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/vnd.ms-powerpoint',
            'application/vnd.openxmlformats-officedocument.presentationml.presentation'
        ];

        $uploadDir = "../../uploads/courses/{$courseId}/materials/";
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        for ($i = 0; $i < count($_FILES['materials']['name']); $i++) {
            if ($_FILES['materials']['error'][$i] === UPLOAD_ERR_OK) {
                // Vérification du type MIME
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mimeType = finfo_file($finfo, $_FILES['materials']['tmp_name'][$i]);
                finfo_close($finfo);

                if (!in_array($mimeType, $allowedTypes)) {
                    continue; // Skip this file
                }

                // Vérification de la taille (10MB max)
                if ($_FILES['materials']['size'][$i] > 10 * 1024 * 1024) {
                    continue; // Skip this file
                }

                // Génération d'un nom de fichier unique
                $originalName = $_FILES['materials']['name'][$i];
                $extension = pathinfo($originalName, PATHINFO_EXTENSION);
                $fileName = uniqid('material_') . '.' . $extension;
                $filePath = $uploadDir . $fileName;

                // Déplacement du fichier
                if (move_uploaded_file($_FILES['materials']['tmp_name'][$i], $filePath)) {
                    // Enregistrement dans la base de données
                    $stmt = $conn->prepare("
                        INSERT INTO course_materials (
                            course_id, file_name, file_path, original_name, 
                            created_at, updated_at
                        ) VALUES (
                            ?, ?, ?, ?, 
                            NOW(), NOW()
                        )
                    ");
                    $stmt->execute([
                        $courseId,
                        $fileName,
                        "/uploads/courses/{$courseId}/materials/" . $fileName,
                        $originalName
                    ]);
                }
            }
        }
    }

    $conn->commit();
    $_SESSION['success'] = "Le cours a été créé avec succès.";
    header('Location: courses.php');
    exit;

} catch (Exception $e) {
    $conn->rollBack();
    $_SESSION['error'] = "Une erreur est survenue : " . $e->getMessage();
    header('Location: create_course.php');
    exit;
}
?>
