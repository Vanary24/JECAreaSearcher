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
}

class StoreDAO
{
    public function ishashtag(string $hashtag_name)
    {
        $dbh = DAO::get_db_connect();

        $sql = "SELECT * FROM hashtag
                WHERE hashtag_name = :hashtag_name";

        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':hashtag_name', $hashtag_name, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetch();
    }

    public function hashtag_name_insert(string $hashtag_name)
    {
        $dbh = DAO::get_db_connect();

         //ハッシュタグテーブルに追加されるがないとき
            if (!$this->cart_exists($memberid, $goodscode))

        $sql = "INSERT INTO hashtag
                VALUES(':hashtag_name')";

        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':hashtag_name', $hashtag_name, PDO::PARAM_STR);
        $stmt->execute();
    }

    public function hashtag_id_search(string $hashtag_name){
        $dbh = DAO::get_db_connect();

        $sql = "SELECT hashtag_id FROM hashtag
                WHERE hashtag_name = :hashtag_name";
        
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':hashtag_name',$hashtag_name,PDO::PARAM_STR);
        $stmt->execute();
        
        return $stmt->fetchObject('hashtag');
    }

    public function store_insert(
        string $store_name,
        string $store_address,
        string $store_tel,
        string $store_worktime,
        string $store_average_price,
        string $hashtag_id,
        string $store_image,
        int $goukann
    ) {

        $dbh = DAO::get_db_connect();

        $sql = "INSERT INTO store(store_name ,store_address, store_tel, store_worktime, store_average_price, hashtag_id, store_image, goukann)
                VALUES(:store_name,:store_address,:store_tel,:store_worktime,:store_average_price,:hashtag_id,:store_image,:goukann)";

        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':store_name', $store_name, PDO::PARAM_STR);
        $stmt->bindValue(':store_address', $store_address, PDO::PARAM_STR);
        $stmt->bindValue(':store_tel', $store_tel, PDO::PARAM_STR);
        $stmt->bindValue(':store_worktime', $store_worktime, PDO::PARAM_STR);
        $stmt->bindValue(':store_average_price', $store_average_price, PDO::PARAM_INT);
        $stmt->bindValue(':hashtag_id', $hashtag_id, PDO::PARAM_INT);
        $stmt->bindValue(':store_image', $store_image, PDO::PARAM_STR);
        $stmt->bindValue(':goukann', $goukann, PDO::PARAM_INT);
        $stmt->execute();
    }
}
