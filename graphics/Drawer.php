<?php
/**
 * Drawer - "рисувальник" - class which will draw the constructor, the scheme to be accurate;
 */

class Drawer
{
    const INDENT_SIZE = 30;

    public $length = 150;
    public $width = 60;
    public $distX = 100;
    public $distY = 60;

    /** @var Point - the point of the drawing start */
    public $startPoint;

    /**
     * Drawer constructor
     * @param Point $startPoint - the start point of drawing the scheme
     */
    public function __construct($startPoint)
    {
        $this->startPoint = $startPoint;
    }

    public function drawSVG($content)
    {
        return '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" 
				x="0px" y="0px" width="1200" height="600" viewBox="0 0 1190 600 " style="display: inline-block">'.$content. '</svg>';
    }

    /**
     * @param Point $point - start point of drawing the choice option
     * @param string $name - the name of the specimen (choice option's or episode's)
     * @param bool $isActive - status for drawing of inactive blocks
     * @return string - result that we give to the SVG-drawer
     */
    public function drawBase($point, $name, $isActive = true){
        $content = '';
        $rect = new Rectangle($this->length, $this->width);
        $content .= $rect->draw($point->x, $point->y, $isActive);
        $points = $rect->getPoints($point->x, $point->y);

        $textPoint = Point::findPointBetweenPoints($points[0], $points[2])->copyAndMove(0, 3);
        $text = new SvgText($textPoint, 12);
        $content .= $text->draw($name);

        return $content;
    }

    /**
     * @param Episode $episode - the episode that we want to draw
     * @param Point $point - start point for drawing
     * @return string - result that we give to the SVG-drawer
     */
    public function drawWholeEpisode($episode, $point)
    {
        $content = '';
        $linkContent = $this->drawBase($point, $episode->name);
        $content .= addLink('#episode', $linkContent);
        $deltaY = $this->width + $this->distY;

        $pathPoint1 = $point->copyAndMove($this->length, $this->width/2);
        $pathPoint2 = $pathPoint1->copyAndMove($this->distX/2);
        $content .= (new Line($pathPoint1, $pathPoint2))->draw();
        $pathPoint1 = $pathPoint2->copyAndMove(0, -$deltaY);

        $point = $point->copyAndMove($this->distX + $this->length, -$deltaY);
        $linePoint1 = $pathPoint2->copyAndMove(0, -$deltaY);
        $linePoint2 = $linePoint1->copyAndMove($this->distX/2);
        $plusPoint = $linePoint2->copyAndMove($this->length + self::INDENT_SIZE);

        $itemPoint1 = $linePoint2->copyAndMove($this->length);
        $itemPoint2 = $itemPoint1->copyAndMove(2*self::INDENT_SIZE);
        $nextItemPoint = $plusPoint->copyAndMove(self::INDENT_SIZE, -self::INDENT_SIZE);

        $i = 1;
        foreach ($episode->options as $option)
        {
            $linkContent = $this->drawBase($point, $option->optionName);
            $content .= addLink('#choice'.$i, $linkContent);

            $line1 = new Line($linePoint1, $linePoint2);
            $line2 = new Line($linePoint1, $pathPoint2);

            if ($option->nextItemId == null){
                $plusSign = new PlusSign($plusPoint);
                $linkContent = $plusSign->draw();
                $link = 'demo.php?id=' . $episode->id . '&mode=add_'. $i;
                $content .= addLink($link, $linkContent);
            } else {
                $linkContent = $this->drawBase($nextItemPoint, $option->nextItemId, false);
                $link = 'demo.php?id=' . $option->nextItemId;
                $content .= addLink($link, $linkContent);

                $line = new Line($itemPoint1, $itemPoint2);
                $content .= $line->draw();
            }

            $content .= $line1->draw() . $line2->draw();

            $point = $point->copyAndMove(0, $deltaY);
            $pathPoint1 = $pathPoint1->copyAndMove(0, $deltaY);
            $linePoint1 = $linePoint1->copyAndMove(0, $deltaY);
            $linePoint2 = $linePoint2->copyAndMove(0, $deltaY);
            $plusPoint = $plusPoint->copyAndMove(0, $deltaY);
            $i++;
            $itemPoint1 = $itemPoint1->copyAndMove(0, $deltaY);
            $itemPoint2 = $itemPoint2->copyAndMove(0, $deltaY);
            $nextItemPoint = $nextItemPoint->copyAndMove(0, $deltaY);
        }
        return $content;
    }
}