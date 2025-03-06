<?php
function getConnection() {
    $host = 'localhost';
    $dbname = 'fimac_db';
    $username = 'root';
    $password = '';
    
    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch(PDOException $e) {
        error_log("Erreur de connexion : " . $e->getMessage());
        throw new Exception("Erreur de connexion à la base de données");
    }
}
?>
