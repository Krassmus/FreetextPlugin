<label>
    <?= _("Frage") ?>
    <textarea name="questions[<?= $vote->getId() ?>][questiondata][question]" placeholder="<?= _("Erz�hlen Sie uns ...") ?>"><?= isset($vote['questiondata']['question']) ? htmlReady($vote['questiondata']['question']) : "" ?></textarea>
</label>
