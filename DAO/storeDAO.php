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
    public int $goukann;
    public int $count;
    public int $hashtag_id;
    public string $hashtag_name;
    public int $identity1;
}



class StoreDAO
{
    public function search_by_keyword(string $keyword)
    {
        $dbh = DAO::get_db_connect();
        //キーワード検索
        $sql = "SELECT * FROM store WHERE store_name LIKE :keyword";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':keyword', '%' . $keyword . '%', PDO::PARAM_STR);
        $stmt->execute();
        $store = [];

        while ($row = $stmt->fetchObject('store')) {
            $store[] = $row;
        }

        return $store;
    }

    public function search_count(string $keyword)
    {
        $dbh = DAO::get_db_connect();
        $sql = "SELECT COUNT(store_name) AS count FROM store WHERE store_name LIKE :keyword";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':keyword', '%' . $keyword . '%', PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->fetchColumn();

        return $count;
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
