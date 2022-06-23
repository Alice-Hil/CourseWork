<?php
include_once 'allConnections.php';

$lib = Library::getStories();
$id = getStoryId();
/** @var Story $story*/
$story = Library::findStoryByID($lib, $id);

include_once dirname(__FILE__) . '/demo.php';