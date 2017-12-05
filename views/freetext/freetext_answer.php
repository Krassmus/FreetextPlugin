<?
$answer = $vote->getMyAnswer();
$answerdata = $answer['answerdata'] ? $answer['answerdata']->getArrayCopy() : array();
?>

<label>
    <div><?= formatReady($vote['questiondata']['question']) ?></div>
    <textarea name="answers[<?= $vote->getId() ?>][answerdata][text]" style="width: 100%; border: 1px solid #c5c7ca;"><?= htmlReady($answerdata['text']) ?></textarea>
</label>