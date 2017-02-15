<?php

namespace App;

use App\Interfaces\RepoInterface;
use App\Interfaces\DbConnection;
use SplFixedArray;

class Repo implements RepoInterface
{
    private $db;

    private $preparedStatement;

    /**
     * Repo constructor.
     * @param DbConnection $db
     */
    public function __construct(DbConnection $db)
    {
        $this->db = $db->getConnection();
        $this->preparedStatement =
        $this->db->prepare("SELECT word FROM big_files.distinct_words WHERE word = :word LIMIT 1");
    }

    /**
     * @param string $word
     * @return bool
     */
    public function wordExists($word){
        $stmt = $this->preparedStatement;
        $stmt->bindParam(':word', $word, \PDO::PARAM_STR, 45);
        $stmt->execute();
        $result = $stmt->fetch();
        if ($result === FALSE) {
            return false;
        }
        return true;
    }

    /**
     * Dummy INSERT generator.
     * @param SplFixedArray $words
     * @param int $count
     */
    public function storeBunch(SplFixedArray $words, $count)
    {
        $sql = "INSERT INTO distinct_words (`word`) VALUES ";
        $notFirst = false;
        for ($i = 0; $i <= $count; $i++){
            if ($words->offsetExists($i)) {
                $word = $words->offsetGet($i);
//                check if the word exists in db
                if ($this->wordExists($word)) {
                    continue;
                }
                if ($notFirst) {
                    $sql .= ',';
                } else {
                    $notFirst = true;
                }
                $sql .= "(" . $this->db->quote($word) . ")";
            }
        }
        $sql .= ";";
        $this->db->query($sql);
    }

    /**
     * @return int|string
     */
    public function countWords()
    {
        $sql = "SELECT count(*) FROM big_files.distinct_words WHERE 1";
        $result = $this->db->query($sql)->fetch(\PDO::FETCH_COLUMN);
        if ($result !== false) {
            return $result;
        }
        return "I have no idea.";
    }

    /**
     * @return array
     */
    public function scanWatchlist()
    {
        $sql = "SELECT word FROM big_files.distinct_words WHERE word IN (SELECT word FROM big_files.watchlist Where 1)";
        $stmt = $this->db
            ->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_COLUMN);
        if ($result === false) {
            return [];
        }
        return $result;
    }

    public function truncateWordsTable()
    {
        $this->db->query("TRUNCATE `big_files`.`distinct_words`;");
    }

}