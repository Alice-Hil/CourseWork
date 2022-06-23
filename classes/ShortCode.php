<?php
/**
 * ShortCode - "короткий код" - class that will generate short-code of the story to add it to the episode's ID
*/

class ShortCode
{
    /**
     * @param string $name - the name of story
     * @return string - result short-code
     */
    public static function generateCode($name)
    {
        $code = $name[0] . $name[4] . $name[6];
        return $code;
    }
}