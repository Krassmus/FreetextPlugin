<label>
    <?= _("Frage") ?>
    <textarea name="questions[<?= $vote->getId() ?>][questiondata][question]" placeholder="<?= _("Erzählen Sie uns ...") ?>"><?= isset($vote['questiondata']['question']) ? htmlReady($vote['questiondata']['question']) : "" ?></textarea>
</label>
