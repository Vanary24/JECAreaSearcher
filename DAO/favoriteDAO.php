<?php 

    require_once 'DAO.php';

    class favoriteDAO
    {
        public function get_store_id(int $member_id)
        {
             $dbh = DAO::get_db_connect();

             //学籍番号をもとにstore_idを取得する

             $sql = "SELECT store_id FROM member_favorite where member_id = :member_id";

             $stmt = $dbh->prepare($sql);

             $stmt->bindvalue(':member_id', $member_id, PDO::PARAM_STR);

             $stmt->execute();

             return $stmt->fetchObject("member_favorite");

        }

        

        
        
       


    }



?>