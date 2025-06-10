<?php
session_start();
require 'includes/db.php';



$id = $_SESSION['client_id'];
$stmt = $pdo->prepare("SELECT * FROM clients WHERE client_id = ?");
$stmt->execute([$id]);
$clients = $stmt->fetch();
?>


<!DOCTYPE html>
<html>
<head>
    <title>Profil Utilisateur</title>
    <style>
        body { font-family: Arial; }
        .profile-box { max-width: 500px; margin: auto; padding: 20px; border: 1px solid #ccc; border-radius: 10px; }
        img { width: 100px; height: 100px; border-radius: 50%; }
    </style>
</head>
<body>
    <div class="profile-box">
        <h2>Bienvenue, <?= htmlspecialchars($clients['nom']) ?></h2>
        <p><strong>Email:</strong> <?= htmlspecialchars($clients['email']) ?></p>
        <p><strong>adresse:</strong> <?= htmlspecialchars($clients['adresse']) ?></p>
        <p><strong>telephone:</strong> <?= htmlspecialchars($clients['telephone']) ?></p>
        <a href="logout.php">Se déconnecter</a>
    </div>
</body>
</html>