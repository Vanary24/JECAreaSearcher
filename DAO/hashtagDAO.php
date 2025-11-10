<?php

    require_once 'DAO.php';

    
 class hashtag
{
    public int $hashtag_id;
    public string $hashtag_name;
}

class hashtagDAO{

    function get_hashtag_id()
    {
        //ハッシュタグID取得
        $dbh = DAO::get_db_connect();

        $sql = "select hashtag_id from hashtag";

        $stmt = $dbh->prepare($sql);

        $stmt->execute();
        return  $stmt->fetch();
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


    public function hashtag_name_insert(string $hashtag_name)
    {
        $dbh = DAO::get_db_connect();

        //ハッシュタグテーブルに追加されるハッシュタグ名がないとき
        if ($this->hashtag_id_search($hashtag_name) === false) {
            $sql = "INSERT INTO hashtag
                VALUES(':hashtag_name')";

            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':hashtag_name', $hashtag_name, PDO::PARAM_STR);
            $stmt->execute();
        }


    }

     public function hashtag_insert($store_id,$hashtag_id){

        $dbh = DAO::get_db_connect();
       
        $sql = "INSERT INTO store_hashtag
                VALUES(:store_id,:hashtag_id)";
        
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':store_id',$store_id,PDO::PARAM_INT);
        $stmt->bindValue(':hashtag_id',$hashtag_id,PDO::PARAM_INT);
        $stmt->execute();

    }

}


?>