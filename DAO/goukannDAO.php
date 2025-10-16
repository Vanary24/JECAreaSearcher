<?php

require_once 'DAO.php';

class goukann{
public int $goukann; 
public int $store_id;

}

class goukannDAO{


    public function get_store_id($goukann){
        $dbh = DAO::get_db_connect();

        $sql = "select store_id from store
                where goukann = :goukann";
        
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':goukann', $goukann, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchObject("store");

        
    }

   public function get_count($store_id){
     $dbh = DAO::get_db_connect();

     $sql ="SELECT store_id COUNT(*) FROM member_review WHERE store_hyoka = 1 
            store_id = :store_id order by desc";

    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':store_id', $store_id, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchObject("member_review");
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
}



?>