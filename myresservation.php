<?php
session_start(); 
include './includes/db.php';


$client_id = $_POST['id_client'];


$sql = "SELECT r.*, h.nom_hotel, h.ville, c.type_chambre, c.prix
        FROM reservations r
        JOIN hotels h ON r.hotel_id = h.id_hotel
        JOIN chambres c ON r.chambre_id = c.id_chambre
        WHERE r.client_id = :client_id
        ORDER BY r.date_arrivee DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute(['client_id' => $client_id]);
$reservations = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes Réservations</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2 class="mb-4">📅 Mes Réservations</h2>

    <?php if (count($reservations) === 0): ?>
        <div class="alert alert-info">Vous n'avez aucune réservation pour le moment.</div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-bordered table-hover bg-white">
                <thead class="table-dark">
                <tr>
                    <th>Hôtel</th>
                    <th>Ville</th>
                    <th>Chambre</th>
                    <th>Date Arrivée</th>
                    <th>Date Départ</th>
                    <th>Personnes</th>
                    <th>Prix / nuit</th>
                    <th>Total</th>
                    <th>Status</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($reservations as $r): 
                    $nights = (strtotime($r['date_depart']) - strtotime($r['date_arrivee'])) / (60 * 60 * 24);
                    $total = $r['prix'] * $nights;
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($r['nom_hotel']) ?></td>
                        <td><?= htmlspecialchars($r['ville']) ?></td>
                        <td><?= htmlspecialchars($r['type_chambre']) ?></td>
                        <td><?= $r['date_arrivee'] ?></td>
                        <td><?= $r['date_depart'] ?></td>
                        <td><?= $r['personnes'] ?></td>
                        <td><?= number_format($r['prix'], 2) ?> DH</td>
                        <td class="fw-bold"><?= number_format($total, 2) ?> DH</td>
                        <td>
                            <?php if ($r['status'] === 'paid'): ?>
                                <span class="badge bg-success">Payée</span>
                            <?php else: ?>
                                <span class="badge bg-warning text-dark">En attente</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>
</body>
</html>
