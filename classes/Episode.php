<?php
/**
 * Episode - "епізод" - class об'єкт, will be consisted of choice's options, so that the story will be changed;
 * in prospects, the possibility of adding the game's characters and changing the qualities of the main one wil de realized;
 */

class Episode
{
    /** @var int - ID of the episode*/
    public $id;
    /** @var string - name of the episode*/
    public $name;
    /** @var string - description of the episode*/
    public $description;
    /** @var ChoiceOption[] - array of choice options for exact episode*/
    public $options;

    public function __construct($id, $name)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = 'Example of description';
        $this->options = [
            new ChoiceOption(),
            new ChoiceOption(),
            new ChoiceOption()
        ];
    }

    static public function load($dataFromFile)
    {
        $episode = new Episode($dataFromFile['id'], $dataFromFile['name']);
        $episode->options = [];
        foreach ($dataFromFile['options'] as $option){
            $newOption = new ChoiceOption();
            $newOption->optionName = $option['optionName'];
            $newOption->nextItemId = $option['nextItemId'];
            array_push($episode->options, $newOption);
        }
        return $episode;
    }

    public function renovateInfo()
    {
        if ($_POST['choice_name'] || $_POST['choice_link']){
            $this->options[getChoiceId()]->renovateInfo();
        } else {
            $this->name = $_POST['name'];
            $this->description = $_POST['desc'];
        }
        return $this;
    }
}