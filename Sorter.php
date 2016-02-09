<?php
/**
 * Created by PhpStorm.
 * User: aleksandr
 * Date: 05.02.16
 * Time: 15:30
 */
interface sorterInterface
{
    function sort($mas, $sortOption);
}

class Sorter implements sorterInterface
{
    public static function generateMas($min, $max, $size)
    {
        $mas = array();
        for ($i = 0; $i < $size; $i++) {
            $mas[$i] = mt_rand($min, $max);
        }
        return $mas;
    }

    public function sort($mas, $sortOption)
    {
        echo 'Method Sort of the class ' . get_class($this). '<br />';
        if(($sortOption == 'ASC') || ($sortOption == 'DESC') ) return $this->internalSort($mas, $sortOption);
        else throw new Exception('Invalid sorting option!');
    }

    protected function internalSort($mas, $sortOption) //Сортировка методом пузырьков
    {
        echo 'Method internalSort of the class ' . get_class($this);
        do {
            $sorted = 0;
            for ($i = 0; $i < count($mas) - 1; $i++) {
                if ($sortOption == 'ASC') { //Сортируем по возрастанию
                    if ($mas[$i] > $mas[$i + 1]) {
                        list($mas[$i], $mas[$i + 1]) = array($mas[$i + 1], $mas[$i]);
                        $sorted++;
                    }
                } else{ //Или по убыванию
                    if ($mas[$i] < $mas[$i + 1]) {
                        list($mas[$i], $mas[$i + 1]) = array($mas[$i + 1], $mas[$i]);
                        $sorted++;
                    }
                }
            }
        } while ($sorted != 0);
        return $mas;
    }
}

class UpgradedSorter extends Sorter
{
    protected function internalSort($mas, $sortOption) //Сортировка перемешиванием
    {
        echo 'Method internalSort of the class ' . get_class($this);
        $n = count($mas);
        $left = 0;
        $right = $n - 1;
        if($sortOption == 'ASC') { //Сортируем по возрастанию
            do {
                for ($i = $left; $i < $right; $i++) {
                    if ($mas[$i] > $mas[$i + 1]) {
                        list($mas[$i], $mas[$i + 1]) = array($mas[$i + 1], $mas[$i]);
                    }
                }
                $right -= 1;
                for ($i = $right; $i > $left; $i--) {
                    if ($mas[$i] < $mas[$i - 1]) {
                        list($mas[$i], $mas[$i - 1]) = array($mas[$i - 1], $mas[$i]);
                    }
                }
                $left += 1;
            } while ($left <= $right);
        }
        else { //Или по убыванию
            do {
                for ($i = $left; $i < $right; $i++) {
                    if ($mas[$i] < $mas[$i + 1]) {
                        list($mas[$i], $mas[$i + 1]) = array($mas[$i + 1], $mas[$i]);
                    }
                }
                $right -= 1;
                for ($i = $right; $i > $left; $i--) {
                    if ($mas[$i] > $mas[$i - 1]) {
                        list($mas[$i], $mas[$i - 1]) = array($mas[$i - 1], $mas[$i]);
                    }
                }
                $left += 1;
            } while ($left <= $right);
        }
        return $mas;
    }
}
try {
    $sorter = new Sorter();
    $sorter2 = new UpgradedSorter();
    $mas = Sorter::generateMas(0, 20, 25);
    $newMas = $sorter->sort($mas, 'DESC');
    var_dump($newMas);
    $newMas2 = $sorter2->sort($mas, 'DESC');
    var_dump($newMas2);
}
catch (Exception $ex) {
    echo "Exception: $ex";
}