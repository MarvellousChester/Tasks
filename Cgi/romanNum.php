<?php


class test
{
    protected $mas = array('M' => 1000, 'D' => 500, 'C' => 100, 'L' => 50, 'X' => 10, 'V' => 5, 'I' => 1);
    protected $romannum = '';
    protected $result;
    function convert($value)
    {
        if($value > 3999) {
            return false;
        }
            $remainder = (int)($value / current($this->mas));
            if ($remainder == 0) {
                if (!next($this->mas)) {
                    $this->result = $this->romannum;
                } else {
                    $this->convert($value);
                }
            }
            elseif(substr($value, 0, 1) == 9) {
                next($this->mas);
                $this->romannum .= key($this->mas);
                $value -= current($this->mas) * 9;
                prev($this->mas);
                prev($this->mas);
                $this->romannum .= key($this->mas);
                next($this->mas);
                next($this->mas);
                $this->convert($value);
            }
            elseif ($remainder == 4) {
                $this->romannum .= key($this->mas);
                prev($this->mas);
                $this->romannum .= key($this->mas);
                next($this->mas);
                $value -= current($this->mas) * 4;

                $this->convert($value);

            } else {
                $this->romannum .= key($this->mas);
                $value -= current($this->mas);
                $this->convert($value);
            }


        return $this->result;

    }

}

$test = new test();


$result = $test->convert(3999);

echo $result;