<h1>Modifier le trajet</h1>

<form method="POST" action="/trips/<?= (int)$trip['id'] ?>/update">
    <label>Départ</label>
    <select name="origin_agency_id">
        <?php foreach ($agencies as $agency): ?>
            <option value="<?= $agency['id'] ?>"
                <?= $agency['id'] == $trip['from_agency_id'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($agency['name']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label>Arrivée</label>
    <select name="destination_agency_id">
        <?php foreach ($agencies as $agency): ?>
            <option value="<?= $agency['id'] ?>"
                <?= $agency['id'] == $trip['to_agency_id'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($agency['name']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label>Date de départ</label>
    <input type="datetime-local" name="departure_at"
        value="<?= date('Y-m-d\TH:i', strtotime($trip['departure_at'])) ?>">

    <label>Places disponibles</label>
    <input type="number" name="places_available" value="<?= (int)$trip['places_available'] ?>">

    <button type="submit" class="btn">Enregistrer</button>
</form>