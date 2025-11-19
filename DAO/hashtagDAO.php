<?php

require_once 'DAO.php';


class hashtag
{
    public int $hashtag_id;
    public string $hashtag_name;
}

class hashtagDAO
{

    function get_hashtag_id()
    {
        //ハッシュタグID取得
        $dbh = DAO::get_db_connect();

        $sql = "select hashtag_id from hashtag";

        $stmt = $dbh->prepare($sql);

        $stmt->execute();
        return  $stmt->fetch();
    }

    // 検索結果用
    public function get_hashtag_name(int $id)
    {
        $dbh = DAO::get_db_connect();
        $sql = "SELECT hashtag_name FROM hashtag AS h INNER JOIN store_hashtag AS SH ON h.hashtag_id = sh.hashtag_id WHERE sh.store_id = :id";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $data = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }

        return $data;
    }

    function search_by_keyword_to_hashtag_name(string $keyword)
    {
        //ハッシュタグ検索
        $dbh = DAO::get_db_connect();
        $hashtag_id = $this->get_hashtag_id();
        $hashtag_name = $this->get_hashtag_name($hashtag_id);

        $sql = " select * from store where :keyword LIKE :hashtag_name";

        $stmt = $dbh->prepare($sql);

        $stmt->bindValue(':keyword', '%' . $keyword . '%', PDO::PARAM_STR);
        $stmt->bindValue(':hashtag_name', '%' . $hashtag_name . '%', PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function search_by_hashtag(array $tags, int $gou, string $key)
    {
        $dbh = DAO::get_db_connect();

        if (count($tags) == 3) {
            $sql = "SELECT s.store_id, store_name, store_address FROM hashtag AS h 
                INNER JOIN store_hashtag AS sh ON h.hashtag_id = sh.hashtag_id 
                INNER JOIN store AS s ON sh.store_id = s.store_id
                WHERE store_name LIKE :key and goukann = :gou and hashtag_name LIKE :t1 OR hashtag_name LIKE :t2 OR hashtag_name LIKE :t3";
        } elseif (count($tags) == 2) {
            $sql = "SELECT s.store_id, store_name, store_address FROM hashtag AS h 
                INNER JOIN store_hashtag AS sh ON h.hashtag_id = sh.hashtag_id 
                INNER JOIN store AS s ON sh.store_id = s.store_id
                WHERE store_name LIKE :key and goukann = :gou and hashtag_name LIKE :t1 OR hashtag_name LIKE :t2 ";
        } else {
            $sql = "SELECT s.store_id, store_name, store_address FROM hashtag AS h 
                INNER JOIN store_hashtag AS sh ON h.hashtag_id = sh.hashtag_id 
                INNER JOIN store AS s ON sh.store_id = s.store_id
                WHERE store_name LIKE :key and goukann = :gou and hashtag_name LIKE :t1";
        }

        $stmt = $dbh->prepare($sql);

        for ($i = 0; $i < count($tags); $i++) {
            $stmt->bindValue(':t' . ($i + 1), '%' . $tags[$i] . '%', PDO::PARAM_STR);
        }

        $stmt->bindValue(':gou', $gou, PDO::PARAM_INT);
        $stmt->bindValue(':key', '%' . $key . '%', PDO::PARAM_STR);
        $stmt->execute();

        $data = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }

        return $data;
    }

    // ハッシュタグidを検索
    public function hashtag_id_search(string $hashtag_name)
    {
        $dbh = DAO::get_db_connect();

        $sql = "SELECT hashtag_id FROM hashtag
                WHERE hashtag_name = :hashtag_name";

        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':hashtag_name', $hashtag_name, PDO::PARAM_STR);
        $stmt->execute();
        $hashtag = $stmt->fetchObject('hashtag');

        if ($hashtag !== null) {
            return $hashtag;
        } else {
            return false;
        }
    }

    //ハッシュタグテーブルに追加されるハッシュタグ名がないとき
    public function hashtag_name_insert(string $hashtag_name)
    {
        $dbh = DAO::get_db_connect();


        if ($this->hashtag_id_search($hashtag_name) === false) {
            $sql = "INSERT INTO hashtag
                VALUES(:hashtag_name)";

            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':hashtag_name', $hashtag_name, PDO::PARAM_STR);
            $stmt->execute();
        }
    }

    public function hashtag_insert($store_id, $hashtag_id)
    {

        $dbh = DAO::get_db_connect();

        $sql = "INSERT INTO store_hashtag(store_id, hashtag_id)
                VALUES(:store_id,:hashtag_id)";

        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':store_id', $store_id, PDO::PARAM_INT);
        $stmt->bindValue(':hashtag_id', $hashtag_id, PDO::PARAM_INT);
        $stmt->execute();
    }
}
