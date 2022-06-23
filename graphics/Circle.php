<?php


class Circle
{
    /** @var Point - координаты центральной точки кружка*/
    public $point;
    public $radius = 9;
    public $strokeColor = 'black';
    public $strokeWidth = 1;
    public $isFilled;
    public $fillColor = 'black';

    /**
     * Circle constructor.
     * @param $point Point
     * @param int $scale
     * @param bool $isFilled
     */
    public function __construct($point, $scale = 1, $isFilled = false)
    {
        $this->point = $point;
        $this->radius *= $scale;
        $this->isFilled = $isFilled;
    }

    // Готовим svg для отрисовки кружка или точки
    public function draw()
    {
        if (!$this->isFilled){
            $this->fillColor = 'white';
        }

        return str_replace(
            ['{x}', '{y}', '{RADIUS}', '{COLOR_STROKE}', '{STROKE_WIDTH}', '{COLOR_FILL}'],
            [$this->point->x, $this->point->y, $this->radius, $this->strokeColor, $this->strokeWidth, $this->fillColor],
            '<circle cx="{x}" cy="{y}" r="{RADIUS}" stroke="{COLOR_STROKE}" stroke-width="{STROKE_WIDTH}" fill="{COLOR_FILL}"></circle>'
        );
    }

    /**
     * @param string $strokeColor
     */
    public function setStrokeColor($strokeColor)
    {
        $this->strokeColor = $strokeColor;
    }

    /**
     * @param string $strokeWidth
     */
    public function setStrokeWidth($strokeWidth)
    {
        $this->strokeWidth = $strokeWidth;
    }

    /**
     * @param string $fillColor
     */
    public function setFillColor($fillColor)
    {
        $this->fillColor = $fillColor;
    }

    /**
     * @param int $radius
     */
    public function setRadius($radius)
    {
        $this->radius = $radius;
    }


}