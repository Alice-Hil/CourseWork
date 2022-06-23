<?php
function getStoryId()
{
    $story = explode('_', $_GET['id']);
    return $story[0];
}

function getChoiceId()
{
    if ($_POST){
        $story = explode('_', $_POST['choice_id']);
        return $story[2] - 1;
    } else {
        $story = explode('_', $_GET['mode']);
        var_dump($story);
        return $story[1];
    }
}


/**
 * @param string $href - the link for our block
 * @param string $content - content information that will be used inside of a link
 * @return string - result
 */
function addLink($href, $content)
{
    return
        '<a href="'.$href.'">'.
        $content.
        '</a>';
}

/**
 * @param Story[] $library
 * @return string
 */
function getStoriesList($library)
{
    $cont = '';
    $i = 0;
    /** @var Story $story*/
    foreach ($library as $story) {
        $href = 'demo.php?id='.$story->shortCode.'_0';
        $content =
            '<div class="list_item">' .
            $story->name .
            '</div>';
        $cont .= addLink($href, $content);
        $i++;
    }
    return '<div class="library_list">' . $cont . '</div>';
}

function drawScheme($episode)
{
    $point = new Point(220, 200);
    $drawer = new Drawer($point);
    $content = $drawer->drawWholeEpisode($episode, $point);
    $scheme = $drawer->drawSVG($content);

    return
        '<head>
            <meta charset="utf-8">
            <title>Demo</title>
            <link rel="stylesheet" href="style.css">
        </head>
        <body>
            <div class="top_bar">
                <div style="padding: 7px 10px;">
                <a href="home.php">
                    <p>
                        Back to Library  
                    </p>
                </a>
                <a href="play.php">
                    <p>
                        Play the Story
                    </p>
                </a>
                <a href="demo.php?id='.$episode->id.'&mode=delete">
                    <p>
                        Delete the Story
                    </p>
                </a>    
            </div>
            <div style="width: 1200px">
                <h3>Online-constructor of the exact episode:</h3>
            </div>' . $scheme .
        '</body>';
}

/**
 * @param Story $story
 * @param Episode $episode
 * @return string
 */
function generateDemo($story, $episode)
{
    ob_end_clean();
    $content = drawScheme($episode);
    $content .= getEpisodesList($story);
    $content .= callEpisodeModal($episode);
    $i = 1;
    foreach ($episode->options as $option)
    {
        $content .= callChoiceModal($episode, $i++);
    }

    return $content;
}

/**
 * @param Story $story - the story to print the list of its episodes
 * @return string
 */
function getEpisodesList($story)
{
    $cont = '<h3 style="margin-bottom: 10px">List of Episodes:</h3>';
    foreach ($story->sortEpisodes() as $episode) {
        $href = '?id=' . $episode->id;
        $content =
            '<div class="list_block">' .
            $episode->name .
            '</div>';
        $cont .= addLink($href, $content);
    }
    return '<div class="list">' . $cont . '</div>';
}

/**
 * @param Episode $episode
 * @return string
 */
function callEpisodeModal($episode){
    $link = 'demo.php?id=' . $episode->id;
    return
    '<a href="#" class="overlay" id="episode"></a>
    <div class="popup episode_popup">
        <form name="episode" id="'.$episode->id.'" method="post" action="' .$link. '" >
            <div style="text-align: center;">
                <label for="episode_name" style="padding-right: 36px">Name:</label>
                <input type="text" style="width: 550px" name="name" value="'.$episode->name.'">
                <br>
                <br>
                <label for="episode_id" style="padding-right: 3px">Episode ID:</label>
                <input type="text" disabled style="width: 550px" name="id" value="'.$episode->id.'">
                <br>
                <br>
                <label for="episode_desc" style="vertical-align: top">Description:</label>
                <textarea rows="8" cols="50" name="desc">'.$episode->description.'</textarea>
            </div>
            <br>
            <div class="buttons_block">
                <a href="#close"><input type="button" value="Cancel" class="cancelBut"></a>
                <input type="submit" value="Save" class="saveBut">
            </div>
        </form>
    </div>';
}

/**
 * @param Episode $episode
 * @param int $choiceID - 1, 2 or 3
 * @return string
 */
function callChoiceModal($episode, $choiceID){
    $link = 'demo.php?id=' . $episode->id;
    $wholeID = $episode->id.'_'.$choiceID;
    /** @var ChoiceOption $currentChoice*/
    $currentChoice = $episode->options[$choiceID-1];
    return
        '<a href="#" class="overlay" id="choice'.$choiceID.'"></a>
    <div class="popup choice_popup">
        <form name="choice" id="'.$wholeID.'" method="post" action="' .$link. '" >
            <div style="text-align: center;">
                <label for="choice_name" style="padding-right: 61px">Name:</label>
                <input type="text" style="width: 525px" name="choice_name" value="'.$currentChoice->optionName.'">
                <br>
                <br>
                <label for="choice_id" style="padding-right: 34px">Choice ID:</label>
                <input type="text" readonly="" style="width: 525px" name="choice_id" value="'.$wholeID.'">
                <br>
                <br>
                <label for="choice_link" style="padding-right: 3px">Linked episode:</label>
                <input type="text" style="width: 525px" name="choice_link" value="'.$currentChoice->nextItemId.'">
                <br>
                <br>
            </div>
            <br>
            <div class="buttons_block">
                <a href="#close"><input type="button" value="Cancel" class="cancelBut"></a>
                <input type="submit" value="Save" class="saveBut">
            </div>
        </form>
    </div>';
}
