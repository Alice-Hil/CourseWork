<?php

/**
 * Rectangle - class which we use to draw the rectangle in svg
 * we start to build it from left bottom point
 */
class Rectangle
{
    public $length;
    public $height;

    public function __construct($length, $width)
    {
        $this->length = $length;
        $this->height = $width;
    }

    /**
     * get all points from drawing
     * @param $start_x - X value of start Point
     * @param $start_y - Y value of start Point
     * @return Point[] - result of points
     */
    public function getPoints($start_x, $start_y)
    {
        /** @var Point[] $points */
        $points = [];
        $points[0] = new Point($start_x, $start_y);
        $points[1] = $points[0]->copyAndMove(0, $this->height);
        $points[2] = $points[1]->copyAndMove($this->length, 0);
        $points[3] = $points[2]->copyAndMove(0, -$this->height);
        return $points;
    }

    /**
     * prepare array for drawing the rectangle
     * @param int $startX - X value of start Point of drawing
     * @param int $startY - X value of start Point of drawing
     * @param bool $isActive - status of block
     * @return string - result string
     */
    public function draw($startX=0, $startY=0, $isActive = true)
    {
        if ($isActive)
        {
            $fill = 'white';
            $color = 'black';
        }
        else
        {
            $fill = '#f4f4f4';
            $color = '#aaaaaa';
        }
        $points = $this->getPoints($startX, $startY);
        $stringPoints = Point::pointsToString($points);
        return '<path fill="'.$fill.'" stroke="' . $color . '" stroke-width="1" d="M'.$stringPoints.'" />';
    }
}