<?php
// Clickable 1–5 star rating input. Set $selectedRating (0–5) before including to pre-select a value.
$selectedRating = isset($selectedRating) ? (int) $selectedRating : 0;
?>
<fieldset class="star-input">
    <legend>Your rating</legend>
    <div class="stars">
        <?php for ($stars = 5; $stars >= 1; $stars--): ?>
            <input type="radio" id="rating-<?= $stars ?>" name="rating" value="<?= $stars ?>" required<?= $stars === $selectedRating ? ' checked' : '' ?>>
            <label for="rating-<?= $stars ?>" title="<?= $stars ?> star<?= $stars === 1 ? '' : 's' ?>">
                <span aria-hidden="true">★</span>
                <span class="visually-hidden"><?= $stars ?> star<?= $stars === 1 ? '' : 's' ?></span>
            </label>
        <?php endfor; ?>
    </div>
</fieldset>
