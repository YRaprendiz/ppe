<?php
$reservations = $controller->listerReservations();

if (count($reservations) > 0) {
    echo "<h1>Liste des Réservations</h1>";
    echo "<table border='1'>
            <tr>
                <th>Chambre</th>
                <th>Date Check-In</th>
                <th>Date Check-Out</th>
                <th>Statut</th>";
    if (isset($_SESSION['user']) && $_SESSION['user']['User_role'] === 'Admin') {
        echo "<th>Client</th>";
    }
    echo "</tr>";

    foreach ($reservations as $reservation) {
        echo "<tr>
                <td>{$reservation['Chambre_000']}</td>
                <td>{$reservation['Date_CheckIn']}</td>
                <td>{$reservation['Date_CheckOut']}</td>
                <td>{$reservation['Statut']}</td>";
        if (isset($_SESSION['user']) && $_SESSION['user']['User_role'] === 'Admin') {
            echo "<td>{$reservation['Nom']} {$reservation['Prenom']}</td>";
        }
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "<p>Aucune réservation trouvée.</p>";
}
?>
