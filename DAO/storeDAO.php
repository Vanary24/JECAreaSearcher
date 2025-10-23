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

class Hashtag
{
    public int $hashtag_id;
    public string $hashtag_name;
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
        $sql = "select *, count(*) as count from store where store_name LIKE :keyword group by store_id, store_name, store_address, store_tel,
                store_worktime, store_average_price, hashtag_id, goukann";

        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':keyword', '%' . $keyword . '%', PDO::PARAM_STR);
        $stmt->execute();
        $store = $stmt->fetchObject('store');

        return $store;
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
        $hashtag = $stmt->fetchObject('hashtag');

        return $hashtag;
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
     //ストアハッシュタグテーブルにstoreidとhashtagidを入れる
    public function hashtag_insert($store_id,$hashtag_id){

        $dbh = DAO::get_db_connect();
       
        $sql = "INSERT INTO store_hashtag
                VALUES(:store_id,:hashtag_id)";
        
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':store_id',$store_id,PDO::PARAM_INT);
        $stmt->bindValue(':hashtag_id',$hashtag_id,PDO::PARAM_INT);
        $stmt->execute();

    }

    public function image_insert($store_id,$image_name){
        $dbh = DAO::get_db_connect();

        $sql = "INSERT INTO store_image
                VALUES(:store_id,:image_name)";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':store_id',$store_id,PDO::PARAM_INT);
        $stmt->bindValue(':image_name',$image_name,PDO::PARAM_STR);
        $stmt->execute();
    }

    public function get_store_name(int $store_id)
        {
                $dbh = DAO::get_db_connect();

                //store-idをもとにstore_nameを取得する

                $sql = "SELECT store_name FROM store where store_id = :store_id";

                $stmt = $dbh->prepare($sql);
                
                $stmt->bindvalue(':store_id', $store_id, PDO::PARAM_STR);

                $stmt->execute();

                 return $stmt->fetchObject("store");

        }





    public function store_insert(
        string $store_name,
        string $store_address,
        string $store_tel,
        string $store_worktime,
        string $store_average_price,
        int $goukann
    ) {

        $dbh = DAO::get_db_connect();

        $sql = "INSERT INTO store(store_name ,store_address, store_tel, store_worktime, store_average_price, goukann)
                VALUES(:store_name,:store_address,:store_tel,:store_worktime,:store_average_price,:goukann)";

        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':store_name', $store_name, PDO::PARAM_STR);
        $stmt->bindValue(':store_address', $store_address, PDO::PARAM_STR);
        $stmt->bindValue(':store_tel', $store_tel, PDO::PARAM_STR);
        $stmt->bindValue(':store_worktime', $store_worktime, PDO::PARAM_STR);
        $stmt->bindValue(':store_average_price', $store_average_price, PDO::PARAM_INT);
        $stmt->bindValue(':goukann', $goukann, PDO::PARAM_INT);
        $stmt->execute();
    }
    

    
}
