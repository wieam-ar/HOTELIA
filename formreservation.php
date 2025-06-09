<?php
include 'db.php';

$nom_hotel = $_POST['nom_hotel'];
$date_arrivee = $_POST['date_arrivee'];
$date_depart = $_POST['date_depart'];
$personnes = $_POST['personnes'];

// Requête : Trouver les hôtels avec au moins une chambre disponible
$sql = "
SELECT DISTINCT h.* FROM hotels h
JOIN chambres c ON h.id_hotel = c.id_hotel
WHERE h.ville LIKE :ville
AND c.capacite >= :personnes
AND c.id_chambre NOT IN (
    SELECT id_chambre FROM reservation
    WHERE NOT (
        :date_depart <= date_arrivee OR :date_arrivee >= date_depart
    )
)
";

$stmt = $pdo->prepare($sql);
$stmt->execute([
  ':ville' => "%$ville%",
  ':personnes' => $personnes,
  ':date_arrivee' => $date_arrivee,
  ':date_depart' => $date_depart
]);

$hotels = $stmt->fetchAll();
?>

<h2>Hôtels disponibles :</h2>
<div class="resultats">
<?php if ($hotels): ?>
  <?php foreach ($hotels as $hotel): ?>
    <div class="card">
      <img src="<?= $hotel['image'] ?>" alt="Image hotel">
      <h3><?= $hotel['nom_hotel'] ?></h3>
      <p>Ville : <?= $hotel['ville'] ?></p>
      <p>Adresse : <?= $hotel['adresse'] ?></p>
    </div>
  <?php endforeach; ?>
<?php else: ?>
  <p>Aucun hôtel trouvé pour ces critères.</p>
<?php endif; ?>
</div>
