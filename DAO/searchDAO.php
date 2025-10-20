 <?php
 
    require_once 'DAO.php';




 
 class searchDAO{
    public int $hashtag_id;
    public string $hashtag_name;
    public string $keyword;


    function get_hashtag_id(){
        //ハッシュタグID取得
        $dbh = DAO::get_db_connect();

        $sql = "select sh.hashtag_id from store as s INNER JOIN store_hashtag as sh 
                on s.store_id = sh.store_id";
                
        $stmt = $dbh->prepare($sql);
        
        $stmt->execute();
        return $stmt->fetch();
    }

    function get_hashtag_name($hashtag_id){
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

    function search_by_keyword(string $keyword){
        $dbh = DAO::get_db_connect();
        //キーワード検索
        $sql = "select * from store where store_name LIKE :keyword";

        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':keyword', '%'.$keyword.'%', PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    function search_by_keyword_to_hashtag_name(string $keyword){
        //ハッシュタグ検索
        $dbh = DAO::get_db_connect();
        $hashtag_id = $this->get_hashtag_id();
        $hashtag_name = $this->get_hashtag_name($hashtag_id);

        $sql = " select * from store where :keyword LIKE :hashtag_name";

        $stmt = $dbh->prepare($sql);

        $stmt->bindValue(':keyword', '%'.$keyword.'%', PDO::PARAM_STR);
        $stmt->bindValue(':hashtag_name', '%'.$hashtag_name.'%', PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

 }

 ?>