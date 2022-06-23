<?php
/**
 * ChoiceOption - "варіант вибору" - the smallest class of the service, will be consisted of the info about option;
 * in prospects, the changes in properties of character will be available here.
 */


class ChoiceOption
{
    /** @var string - the name of choice, e.g. "to go left" */
    public $optionName;
    /** @var string - ID of the connected episode*/
    public $nextItemId;

    public function __construct()
    {
        $this->optionName = "Example Option";
        $this->nextItemId = null;
    }

    public function renovateInfo()
    {
        $this->optionName = $_POST['choice_name'];
        $this->nextItemId = $_POST['choice_link'];
        return $this;
    }
}