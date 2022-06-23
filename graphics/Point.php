<?php

class Point
{
    public $x;
    public $y;

    public function __construct($x=0, $y=0)
    {
        $this->x = $x;
        $this->y = $y;
    }

    /**
     * Создает новую точку, путем копирования первоначальных координат с учетом заданых смещений
     * @param int $deltaX - смещение по оси ОХ
     * @param int $deltaY - смещение по оси ОY
     * @return Point - новая точка
     */
    public function copyAndMove($deltaX = 0, $deltaY = 0)
    {
        return new Point($this->x + $deltaX, $this->y + $deltaY);
    }

    /**
     * Переводит координаты всех точек в массиве в текстовую строку для svg объектов
     * @param $points Point[] - массив точек
     * @param bool $keyPrefix - флаг для добавления признака замкнутого контура ('z')
     * @return string
     */
    public static function pointsToString($points, $keyPrefix = true)
    {
        /** @var string[] $result - накапливает строковые фрагменты координат каждой точки */
        $result = [];
        foreach($points as $point){
            $result[] = $point->x . ',' . $point->y;
        }
        $prefix = $keyPrefix ? ' z' : '';
        return implode(" ", $result) . $prefix;
    }

    /** Высчитывает и возвращает объект Точку между двумя точками
     * @param $point_1 Point - начальная точка
     * @param $point_2 Point - конечная точка
     * @param $dist - расстояние между первой точкой и вспомогательной
     * @return Point - найденная точка
     */
    public static function findPointBetweenPoints($point_1, $point_2, $dist = null)
    {
        if (!$dist){
            $x = ($point_1->x + $point_2->x)/2;
            $y = ($point_1->y + $point_2->y)/2;
        }
        // Требуется реализация кода для случая, когда точка на любом расстоянии
        else {
            $deltaX = $point_2->x - $point_1->x;
            $deltaY = $point_2->y - $point_1->y;
            $lengthBetweenPoints = sqrt(pow($deltaX, 2) + pow($deltaY, 2));
            $coefficient = $dist/$lengthBetweenPoints;
            $deltaX = $point_2->x - $point_1->x;
            $deltaY = $point_2->y - $point_1->y;

            $changeX = $deltaX * $coefficient;
            $changeY = $deltaY * $coefficient;
            $x = $point_1->x + $changeX;
            $y = $point_1->y + $changeY;
        }
        return new Point($x, $y);
    }

    /**
     * Поворот точки на заданный угол (используется в радиальном размере)
     * @param int $dist - расстояние между поворачиваемой точкой и точкой поворота
     * @param $angle int - угол поворота точки
     * @return Point - повернутая точка
     */
    public function rotatePoint($dist, $angle)
    {
        $angle = deg2rad($angle);
        $deltaX = $dist * sin($angle);
        $deltaY = -$dist * cos($angle);
        return new Point($this->x + $deltaX, $this->y + $deltaY);
    }
}