<?php


namespace App;

use SplFileObject;

class App
{
    /**
     * @param $fileName
     */
    public function run($fileName)
    {
        $repo = new Repo(Db::getInstance());

        $repo->truncateWordsTable();

        $buffer = new Buffer();
        $wordRetriever = new WordRetriever(new SplFileObject($fileName, 'rb'));
        $i=0;
        while ($wordRetriever->hasAnotherWord()) {
            $buffer->handle($wordRetriever->getWord());
            $i++;
        }
        if ($buffer->notEmpty())
        {
            $buffer->store(false);
        }

        $count = $repo->countWords();
        echo "Distinct unique words: $count" . PHP_EOL . PHP_EOL;

        echo "Watchlist words:" . PHP_EOL;
        $watchwordsMatches = $repo->scanWatchlist();
        if (count($watchwordsMatches) > 0) {
            foreach ($watchwordsMatches as $value) {
                echo $value . PHP_EOL;
            }
        } else {
            echo "No matches." . PHP_EOL;
        }
        echo PHP_EOL;

        echo "Statistics:" . PHP_EOL;
        echo ">>> $i words found." . PHP_EOL;
        echo ">>> Words buffer was filled up " . $buffer->bunches . " times." . PHP_EOL;
    }
}