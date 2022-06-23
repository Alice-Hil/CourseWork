<?php


class PlusSign
{
    const RADIUS_VALUE = 9;
    const A_VALUE = 4;
    /** @var Point - central point of the circle */
    public $point;

    public function __construct($point)
    {
        $this->point = $point;
    }

    public function draw()
    {
        /** @var Point[] $points - array for plus sign lines */
        $points = [];
        $points[0] = $this->point->copyAndMove(-self::RADIUS_VALUE + self::A_VALUE);
        $points[1] = $this->point->copyAndMove(self::RADIUS_VALUE - self::A_VALUE);
        $points[2] = $this->point->copyAndMove(0, -self::RADIUS_VALUE + self::A_VALUE);
        $points[3] = $this->point->copyAndMove(0, self::RADIUS_VALUE - self::A_VALUE);
        $circle = new Circle($this->point);
        $line1 = new Line($points[0], $points[1]);
        $line2 = new Line($points[2], $points[3]);

        $content = '';
        $content .= $circle->draw() . $line1->draw() . $line2->draw();
        return $content;
    }
}