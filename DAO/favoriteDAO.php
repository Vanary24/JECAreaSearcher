<?php

require_once 'DAO.php';

class member_favorite
{
    public string $member_id;
    public int $store_id;
}
class favoriteDAO
{
    public function get_store_id(string $member_id)
    {
        $dbh = DAO::get_db_connect();

        //学籍番号をもとにstore_idを取得する

        $sql = "SELECT store_id FROM member_favorite where member_id = :member_id";

        $stmt = $dbh->prepare($sql);
        $stmt->bindvalue(':member_id', $member_id, PDO::PARAM_STR);
        $stmt->execute();
        $data = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }

    public function insert_favorite(string $member_id, int $store_id)
    {
        $dbh = DAO::get_db_connect();

        $sql = "INSERT INTO member_favorite VALUES(:member_id, :store_id)";

        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':member_id', $member_id, PDO::PARAM_STR);
        $stmt->bindValue(':store_id', $store_id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function delete_favorite(string $member_id, int $store_id) {
        $dbh = DAO::get_db_connect();
        $sql = "DELETE FROM member_favorite WHERE member_id = :member_id AND store_id = :store_id";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':member_id', $member_id, PDO::PARAM_STR);
        $stmt->bindValue(':store_id', $store_id, PDO::PARAM_STR);
        $stmt->execute();
    }


}
