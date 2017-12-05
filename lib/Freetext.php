<?php

require_once 'lib/classes/QuestionType.interface.php';

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
        $question_data = $questions[$this->getId()];
        $this->setData($question_data);
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
        $answer_data = $answers[$this->getId()];
        $answer->setData($answer_data);
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
        $output = array();

        foreach ($this->answers as $answer) {
            $text = $answer['answerdata']['text'];
            if (isset($output[$text])) {
                $output[$text][$answer['user_id']]++;
            } else {
                $output[$text] = array($answer['user_id'] => 1);
            }
        }

        return $output;
    }

    public function onEnding()
    {

    }
}