<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "contact.form";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("La connexion à la base de données a échoué : " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = htmlspecialchars($_POST["name"]);
    $email = htmlspecialchars($_POST["email"]);
    $message = htmlspecialchars($_POST["message"]);
    
    $entry = "Nom: $name\nEmail: $email\nMessage: $message\n---\n";
    
    $filePath = "messages.txt";
    
    if (file_put_contents($filePath, $entry, FILE_APPEND | LOCK_EX) === false) {
        die("Erreur : Impossible d'écrire dans le fichier.");
    }

    $sql = "INSERT INTO messages (name, email, message) VALUES ('$name', '$email', '$message')";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: merci.html");
        exit();
    } else {
        die("Erreur : " . $conn->error);
    }

    $conn->close();
}
?>
