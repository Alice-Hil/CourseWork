<?php
/**
 * Library - "бібліотека" - class that will be consisted of created stories, will show them all;
 * in prospects, the connection between libraries and the exact users will be realized, as well as using DB.
 */

class Library
{
    /** @var Story[] - list of stories as objects */
    public $storiesList = [];

    static public function getStories()
    {
        $lib = new Library();
        $allFiles = array_splice(scandir('library/'), 2);
        foreach ($allFiles as $file){
            $story = Story::readFromFile('library/'. $file);
            array_push($lib->storiesList, $story);
        }
        return $lib->storiesList;
    }

    /**
     * @param Story[] $lib
     * @param string $id
     * @return bool|mixed
     */
    static public function findStoryByID($lib, $id)
    {
        foreach ($lib as $story){
            if ($story->shortCode == $id){
                return $story;
            }
        }
        return false;
    }

}