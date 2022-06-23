<?php


class Line
{
    public $startPoint;
    public $finishPoint;
    public $isActive;

    public function __construct($startPoint, $finishPoint, $isActive = true)
    {
        $this->startPoint = $startPoint;
        $this->finishPoint = $finishPoint;
        $this->isActive = $isActive;
    }

    public function draw()
    {
        if($this->isActive)
        {
            $color = 'black';
            $stroke = 0;
        }
        else
        {
            $color = 'gray';
            $stroke = 5;
        }

        return str_replace(
            ['{x1}', '{y1}', '{x2}', '{y2}', '{COLOR_LINE}', '{DASH_ARRAY}', '{LINE_WIDTH}'],
            [$this->startPoint->x, $this->startPoint->y, $this->finishPoint->x, $this->finishPoint->y,$color, $stroke, 1],
            '<line x1="{x1}" y1="{y1}" x2="{x2}" y2="{y2}" stroke="{COLOR_LINE}" stroke-dasharray="{DASH_ARRAY}" stroke-width="{LINE_WIDTH}"></line>'
        );
    }
}