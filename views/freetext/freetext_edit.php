<? $etask = $vote->etask ?>
<label>
    <?= _("Frage") ?>
    <textarea name="questions[<?= $vote->getId() ?>][description]"
              class="size-l wysiwyg"
              placeholder="<?= _("Erz�hlen Sie uns ...") ?>"
    ><?= isset($etask->description) ? wysiwygReady($etask->description) : "" ?></textarea>
</label>
