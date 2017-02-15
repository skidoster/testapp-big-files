<?php


namespace App;

use SplFileObject;

class WordRetriever
{
    private $file;

    public function __construct(SplFileObject $file)
    {
        $this->file = $file;
    }

    /**
     * @return bool|string
     */
    public function getWord()
    {
        $word = '';
        while (!$this->file->eof()) {
            $symbol = $this->file->fgetc();
            if ($symbol == ' ' && mb_strlen($word) > 0) {
                break;
            }
            if ($symbol == "\n" || $symbol == "\r" || $symbol == "\r\n") {
                if (mb_strlen($word) > 0) {
                    break;
                }
                continue;
            }
            $word .= $symbol;
        }
        $word = mb_strtolower($word);
        return (mb_strlen($word) > 0) ? $word : FALSE;
    }

    /**
     * @return bool
     */
    public function hasAnotherWord()
    {
        return !$this->file->eof();
    }
}