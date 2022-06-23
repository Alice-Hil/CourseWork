<?php


class SvgText
{
    const ANCOR_LEFT = "left";
    const ANCOR_CENTER = "middle";
    const ANCOR_RIGHT = "right";

    public $size;
    public $anchor;
    public $point;

    /**
     * Text constructor.
     * @param $point Point
     * @param int $size
     * @param string $align
     */
    public function __construct($point, $size = 10, $align = self::ANCOR_CENTER)
    {
        $this->point = $point;
        $this->size = $size;
        $this->anchor = $align;
    }

    /**
     * @param $content
     * @return string
     */
    public function draw($content)
    {
        return str_replace(
            ['{x}', '{y}', '{ANCHOR}', '{SIZE}', '{CONT}'],
            [$this->point->x, $this->point->y, $this->anchor, $this->size, $content],
            '<text x="{x}" y="{y}" text-anchor="{ANCHOR}" style="font-size: {SIZE}pt;">{CONT}</text>'
        );
    }
}