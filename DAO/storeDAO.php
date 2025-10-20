<?php
require_once 'DAO.php';

class Store
{
    public int $store_id;
    public string $store_name;
    public string $store_address;
    public string $store_tel;
    public string $store_worktime;
    public int $store_average_price;
    public string $hashtag_id;
    public string $hashtag_name;
    public string $store_image;
    public int $goukann;
    public int $count;
}

class StoreDAO
{
    function get_hashtag_id()
    {
        //ハッシュタグID取得
        $dbh = DAO::get_db_connect();

        $sql = "select sh.hashtag_id from store as s INNER JOIN store_hashtag as sh 
                on s.store_id = sh.store_id";

        $stmt = $dbh->prepare($sql);

        $stmt->execute();
        return $stmt->fetch();
    }

    function get_hashtag_name($hashtag_id)
    {
        $dbh = DAO::get_db_connect();
        //ハッシュタグ名取得
        $hashtag_id = $this->get_hashtag_id();

        $sql = "select h.hashtag_name from hashtag as h INNER JOIN store_hashtag as sh 
                on h.hashtag_id = sh.hashtag_id
                where h.hashtag_id = :hashtag_id";

        $stmt = $dbh->prepare($sql);
        $stmt->execute();
        $stmt->bindValue(':hashtag_id', $hashtag_id, PDO::PARAM_STR);
        return $stmt->fetch();
    }

    function search_by_keyword(string $keyword)
    {
        $dbh = DAO::get_db_connect();
        //キーワード検索
        $sql = "select * from store where store_name LIKE :keyword";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':keyword', '%' . $keyword . '%', PDO::PARAM_STR);
        $stmt->execute();
        $store = $stmt->fetchObject('store');

        return $store;
    }

    function search_count(string $keyword) {
        $dbh = DAO::get_db_connect();
        $sql = "select count(store_name) as count from store where store_name LIKE :keyword";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':keyword', '%' . $keyword . '%', PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->fetchColumn();

        return $count;
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

    public function hashtag_id_search(string $hashtag_name)
    {
        $dbh = DAO::get_db_connect();

        $sql = "SELECT hashtag_id FROM hashtag
                WHERE hashtag_name = :hashtag_name";

        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':hashtag_name', $hashtag_name, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchObject('hashtag');
    }

    public function hashtag_name_insert(string $hashtag_name)
    {
        $dbh = DAO::get_db_connect();

        //ハッシュタグテーブルに追加されるハッシュタグ名がないとき
        if (!$this->hashtag_id_search($hashtag_name)) {
            $sql = "INSERT INTO hashtag
                VALUES(':hashtag_name')";

            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':hashtag_name', $hashtag_name, PDO::PARAM_STR);
            $stmt->execute();
        }
    }



    public function store_insert(
        string $store_name,
        string $store_address,
        string $store_tel,
        string $store_worktime,
        string $store_average_price,
        int $hashtag_id,
        int $goukann
    ) {

        $dbh = DAO::get_db_connect();

        $sql = "INSERT INTO store(store_name ,store_address, store_tel, store_worktime, store_average_price, hashtag_id, store_image, goukann)
                VALUES(:store_name,:store_address,:store_tel,:store_worktime,:store_average_price,:hashtag_id,:goukann)";

        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':store_name', $store_name, PDO::PARAM_STR);
        $stmt->bindValue(':store_address', $store_address, PDO::PARAM_STR);
        $stmt->bindValue(':store_tel', $store_tel, PDO::PARAM_STR);
        $stmt->bindValue(':store_worktime', $store_worktime, PDO::PARAM_STR);
        $stmt->bindValue(':store_average_price', $store_average_price, PDO::PARAM_INT);
        $stmt->bindValue(':hashtag_id', $hashtag_id, PDO::PARAM_INT);
        $stmt->bindValue(':goukann', $goukann, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function insert_image() {}
}
