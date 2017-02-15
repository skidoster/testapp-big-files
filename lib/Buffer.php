<?php

namespace App;


use App\Interfaces\WordsBuffer;
use SplFixedArray;

class Buffer implements WordsBuffer
{
    const DEFAULT_BUFFER_SIZE = 10000;

    private $size;

    private $words;

    public $bunches = 0;

    private $emptyIndex = 0;

    private $repo;

    /**
     * Buffer constructor.
     * @param int $size
     */
    public function __construct($size = self::DEFAULT_BUFFER_SIZE)
    {
        $this->repo = new Repo(Db::getInstance());
        $this->size = $size;
        $this->refresh();
    }

    /**
     * @param $word
     * @return bool
     */
    public function handle($word)
    {
        if ($this->hasFreeSpace()){
            $this->add($word);
            return true;
        }
        $this->store();
    }

    /**
     * @param bool $refresh
     */
    public function store($refresh = true)
    {
        $this->repo->storeBunch($this->words, $this->emptyIndex);
        if ($refresh) {
            $this->refresh();
        }
    }

    /**
     * @param $word
     */
    public function add($word)
    {
        if ($this->exists($word)) {
            return;
        }
        $this->words->offsetSet($this->currEmptyIndex(), $word);
    }

    /**
     * @param string $needle
     * @return bool
     */
    public function exists($needle)
    {
        foreach ($this->words as $value) {
            if ($needle === $value) {
                return true;
            }
        }
        return false;
    }

    /**
     * @return bool
     */
    public function hasFreeSpace()
    {
        return (($this->words->count()-1) > $this->emptyIndex) ? true : false;
    }

    /**
     * @return int
     */
    private function currEmptyIndex()
    {
        $index = $this->emptyIndex;
        $this->emptyIndex++;
        return $index;
    }

    /**
     * drop buffer data into initial state.
     */
    public function refresh()
    {
        $this->words = new SplFixedArray($this->size);
        $this->emptyIndex = 0;
        $this->bunches++;
    }

    /**
     * @return bool
     */
    public function notEmpty()
    {
        return ($this->emptyIndex > 0) ? true : false;
    }

}