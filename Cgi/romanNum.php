<?php


class test
{
    /**
     * @var array $mas The massive of digits values
     */
    protected $mas
        = array('M' => 1000, 'D' => 500, 'C' => 100, 'L' => 50, 'X' => 10,
                'V' => 5, 'I' => 1);
    protected $romannum = '';
    protected $result;

    /**
     * @param $value
     *
     * @return bool|string
     */
    function convert($value)
    {
        //Cant calc more then 3999
        if ($value > 3999) {
            return false;
        }

        /** @var int $remainder
         * Remainder of the division
         */
        $remainder = (int)($value / current($this->mas));
        /**
         * If reminder is zero move to next digits value
         */
        if ($remainder == 0) {
            if (!next($this->mas)) {
                $this->result = $this->romannum;
                reset($this->mas);
            } else {
                $this->convert($value);
            }

            /**
             * Else check for 9 first
             */
        } elseif (substr($value, 0, 1) == 9) {
            next($this->mas);
            $this->romannum .= key($this->mas);
            $value -= current($this->mas) * 9;
            prev($this->mas);
            prev($this->mas);
            $this->romannum .= key($this->mas);
            next($this->mas);
            next($this->mas);
            $this->convert($value);

            /**
             * Next for 4
             */
        } elseif ($remainder == 4) {
            $this->romannum .= key($this->mas);
            prev($this->mas);
            $this->romannum .= key($this->mas);
            next($this->mas);
            $value -= current($this->mas) * 4;

            $this->convert($value);

            /**
             * End finally all other variants
             */
        } else {
            $this->romannum .= key($this->mas);
            $value -= current($this->mas);
            $this->convert($value);
        }


        return $this->result;

    }

}

$test = new test();


$result = $test->convert(156);
echo $result;