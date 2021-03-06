<?php

require_once 'lib/classes/QuestionType.interface.php';

use eTask\Task;

class Freetext extends QuestionnaireQuestion implements QuestionType
{
    static public function getIcon($active = false, $add = false)
    {
        return Icon::create(($add ?  "add/" : "")."guestbook", $active ? "clickable" : "info");
    }

    static public function getName()
    {
        return _("Freitextfrage");
    }

    public function getEditingTemplate()
    {
        $tf = new Flexi_TemplateFactory(realpath(__DIR__."/../views"));
        $template = $tf->open("freetext/freetext_edit.php");
        $template->set_attribute('vote', $this);
        return $template;
    }

    public function createDataFromRequest()
    {
        $questions = Request::getArray("questions");
        $data = $questions[$this->getId()];

        if (!$this->etask) {
            $this->etask = Task::create([
                'type' => "freetext",
                'user_id' => $GLOBALS['user']->id,
            ]);
        }

        $this->etask->description = Studip\Markup::purifyHtml($data['description']);
        $this->etask->task = [];

        $this->etask->store();
    }

    public function getDisplayTemplate()
    {
        $tf = new Flexi_TemplateFactory(realpath(__DIR__."/../views"));
        $template = $tf->open("freetext/freetext_answer.php");
        $template->set_attribute('vote', $this);
        return $template;
    }

    public function createAnswer()
    {
        $answer = $this->getMyAnswer();
        $answers = Request::getArray("answers");
        $userAnswerText = $answers[$this->getId()]['answerdata']['text'];
        $answer->setData(['answerData' => ['text' => $userAnswerText]]);
        return $answer;
    }

    public function getResultTemplate($only_user_ids = null)
    {
        $tf = new Flexi_TemplateFactory(realpath(__DIR__."/../views"));
        $template = $tf->open("freetext/freetext_evaluation.php");
        $template->set_attribute('vote', $this);
        return $template;
    }

    public function getResultArray()
    {
        $output = [];
        $count_nobodies = 0;

        $question = trim(strip_tags($this->etask->description));
        foreach ($this->answers as $key => $answer) {
            if ($answer['user_id'] && $answer['user_id'] != 'nobody') {
                $user_id = $answer['user_id'];
            } else {
                $count_nobodies += 1;
                $user_id = _('unbekannt') . ' ' . $count_nobodies;
            }
            $output[$question][$user_id] = $answer['answerdata']['text'];
        }

        return $output;
    }

    public function onEnding()
    {

    }
}
