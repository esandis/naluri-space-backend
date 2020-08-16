<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;

class PiController
{
    public function getLatestPiValue(): Response
    {
        // $pi = $this->countPiValue();
        $pi = 3.14;

        return new Response($pi);
    }

    public function countPiValue()
    {
        $latestPiDigit = 15;

        $nextPiDigit = $this->getPiDigit($latestPiDigit + 1);

        return $nextPiDigit;
    }

    private function getPiDigit($n) {
        $n = $n-1;

        $x = ((4 * $this->getSum(1, $n)) - (2 * $this->getSum(4, $n)) - ($this->getSum(5, $n)) - ($this->getSum(6, $n)));
        $x = $this->getDecimal($x);

        return ($x * 16**14);
    }

    private function getSum($j, $n) {
        //Left Sum
        $s = 0.0;
        $k = 0;
        while ($k <= $n) {
            $r = 8 * $k + $j;
            $s = $this->getDecimal(($s + ((16**($n - $k)) % $r) / $r));
            $k = $k+1;
        }

        //Right Sum
        $t = 0.0;
        $k = $n + 1;
        while (TRUE) {
            $newt = $t + pow(16, ($n - $k)) / (8 * $k + $j);
            //Iterate until $t no longer changes
            if ($t == $newt) {
                break;
            } else {
                $t = $newt;
            }
            $k = $k+1;
        }

        return ($s + $t);
    }

    private function getDecimal($x) {
        $xint = intval($x);
        return $x-$xint;
    }
}
