<?php


class imgge{
    public int $store_id;
    public string $image_name;
}
class imageDAO{
     public function image_insert($store_id,$image_name){
        $dbh = DAO::get_db_connect();

        $sql = "INSERT INTO store_image
                VALUES(:store_id,:image_name)";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':store_id',$store_id,PDO::PARAM_INT);
        $stmt->bindValue(':image_name',$image_name,PDO::PARAM_STR);
        $stmt->execute();
    }
} 


?>