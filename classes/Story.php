<?php
/**
 * Story - "історія" - the main class of the project, will be consisted of the info about episodes
 * in prospects, the possibility of connecting the character to the story will be realized, it will make wider the functionality
 */

class Story
{
    const SEPARATE_SIGN = '_';

    /** @var string - the name of story*/
    public $name;
    /** @var string - short code for using it in ID of episodes*/
    public $shortCode;
    /** @var Episode[] - array of episode's ID of the exact story*/
    public $episodesList = [];

    public function __construct($name)
    {
        $this->name = $name;
        $this->shortCode = ShortCode::generateCode($name);
        $episode = new Episode($this->getNextID(), $this->getNextName());
        array_push($this->episodesList, $episode);
    }

    public function addEpisode()
    {
        $newEpisode = new Episode($this->getNextID(), $this->getNextName());
        array_push($this->episodesList, $newEpisode);
    }

    public function sortEpisodes()
    {
        $sortkey = [];
        for ($i=0; $i < count($this->episodesList); $i++) {
            $sortkey[$i]=$this->episodesList[$i]->id;
        }

        asort($sortkey);

        foreach ($sortkey as $key => $key) {
            $sorted[]=$this->episodesList[$key];
        }
        return $sorted;
    }

    private function getNextID()
    {
        return $this->shortCode . self::SEPARATE_SIGN . count($this->episodesList);
    }

    private function getNextName()
    {
        return 'Episode ' . count($this->episodesList);
    }

    /**
     * @param string $id
     * @return bool|Episode
     */
    public function findEpisode($id)
    {
        foreach ($this->episodesList as $episode)
        {
            if($episode->id == $id){
                return $episode;
            }
        }
        return false;
    }

    private function deleteEpisode($id)
    {
        foreach ($this->episodesList as $key=>$episode)
        {
            if($episode->id == $id){
                array_splice($this->episodesList, $key, 1);
                return true;
            }
        }
        return false;
    }

    /**
     * @param Episode $updatedEpisode
     */
    public function renovateEpisode($updatedEpisode)
    {
        $this->deleteEpisode($updatedEpisode->id);
        array_push($this->episodesList, $updatedEpisode);
        $this->saveToFile();
    }

    public function saveToFile()
    {
        $storyJson = json_encode($this);
        file_put_contents('library/' . $this->shortCode . ".json", $storyJson);
    }

    static public function readFromFile($file)
    {
        $rowData = json_decode(file_get_contents($file), true);
        $story = new Story($rowData['name']);
        $story->shortCode = $rowData['shortCode'];
        $story->episodesList = [];
        foreach ($rowData['episodesList'] as $episode){
            $episode = Episode::load($episode);
            array_push($story->episodesList, $episode);
        }
        return $story;
    }

    public function delete()
    {
        unlink('library/' . $this->shortCode . '.json');
    }
}