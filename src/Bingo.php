<?php

namespace App;

class Bingo{
    private $bingo = [];
    private $numbers = [];
    private $cardArray = [];
    private $cardDraw = '|  B |  I |  N |  G |  O |'.PHP_EOL;

    public function __construct()
    {
        $this->bingo[0] = [];
        $this->bingo[1] = [];
        $this->bingo[2] = [];
        $this->bingo[3] = [];
        $this->bingo[4] = [];
    }

    /**
     * @param string $type
     * @return array|string
     */
    public function getBingo(string $type = 'card')
    {
        $this->randNumber();
        $this->sortLetters();

        if ($type === 'array') {
            $this->setCardArray();
            return $this->cardArray;
        }

        if ($type === 'json') {
            $this->setCardArray();
            return json_encode(['data' => $this->cardArray]);
        }

        $this->setCardDraw();
        return $this->cardDraw;
    }

    private function randNumber()
    {
        $this->setNumber(rand(1,75));
        $this->verifyNumbers();
    }

    /**
     * @param int $number
     */
    private function setNumber(int $number)
    {
        if (in_array($number, $this->numbers)) {
            $this->randNumber();
        }

        $number = str_pad($number, 2, "0", STR_PAD_LEFT);
        $this->numbers[] = $number;

        if ($number >= 1 && $number <= 15) {
            $this->setValue(
                0,
                $number
            );
        }

        if ($number > 15 && $number <= 30) {
            $this->setValue(
                1,
                $number
            );
        }

        if ($number > 30 && $number <= 45) {
            $this->setValue(
                2,
                $number
            );
        }

        if ($number > 45 && $number <= 60) {
            $this->setValue(
                3,
                $number
            );
        }

        if ($number > 60 && $number <= 75) {
            $this->setValue(
                4,
                $number
            );
        }
    }

    /**
     * @param int $index
     * @param string $number
     */
    private function setValue(int $index, string $number)
    {
        if (count($this->bingo[$index]) < 5) {
            $this->bingo[$index][] = $number;
        }
    }

    private function verifyNumbers()
    {
        $complete = true;
        foreach ($this->bingo as $key => $value) {
            if (count($this->bingo[$key]) < 5 ) {
                $complete = false;
            }
        }

        if (!$complete) {
            $this->randNumber();
        }
    }

    private function sortLetters()
    {
        foreach ($this->bingo as $key => &$value) {
            sort($value);
        }
    }

    private function setCardDraw()
    {
        for ($i = 0; $i < 5; $i++) {
            for ($y = 0; $y < 5; $y++) {
                $this->cardDraw .= '| '.$this->bingo[$y][$i].' ';
            }
            $this->cardDraw .= '|'.PHP_EOL;
        }
    }

    private function setCardArray()
    {
        for ($i = 0; $i < 5; $i++) {
            for ($y = 0; $y < 5; $y++) {
                $this->cardArray[$i][] = $this->bingo[$y][$i];
            }
        }
    }

}
