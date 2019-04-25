<?php

namespace App;

class Bingo{
    private $bingo = [];
    private $numbers = [];
    private $cardArray = [];
    private $cardDraw = '|  B |  I |  N |  G |  O |'.PHP_EOL;

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
                $this->bingo[0],
                $number
            );
        }

        if ($number > 15 && $number <= 30) {
            $this->setValue(
                $this->bingo[1],
                $number
            );
        }

        if ($number > 30 && $number <= 45) {
            $this->setValue(
                $this->bingo[2],
                $number
            );
        }

        if ($number > 45 && $number <= 60) {
            $this->setValue(
                $this->bingo[3],
                $number
            );
        }

        if ($number > 60 && $number <= 75) {
            $this->setValue(
                $this->bingo[4],
                $number
            );
        }
    }

    /**
     * @param array|null $value
     * @param string $number
     */
    private function setValue(?array &$value, string $number)
    {
        $value = (array) $value;
        if (count($value) < 5) {
            $value[] = $number;
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
