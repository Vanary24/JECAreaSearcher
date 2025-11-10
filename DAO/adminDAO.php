<?php
require_once 'DAO/DAO.php';

class Admin
{
    public int $admin_id;
    public string $tmp_store;
    public string $tmp_address;
    public string $tmp_tel;
    public string $tmp_worktime;
    public int $tmp_price;
    public int $tmp_buildingNo;
}

class Admin_image
{
    public int $admin_id;
    public string $photo;
}

class Admin_hashtag
{
    public int $admin_id;
    public string $hashtag;
    public int $no;
}

class AdminDAO
{
    public function admin_insert(string $name, string $address, string $tel, string $worktime, int $price, int $goukan)
    {
        $dbh = DAO::get_db_connect();

        $sql = "INSERT INTO admin_store(tmp_store_name ,tmp_store_address, tmp_store_tel, tmp_store_worktime, tmp_store_average_price, tmp_goukann)
                VALUES(:name,:address,:tel,:worktime,:price,:goukan)";
        $stmt = $dbh->prepare($sql);


        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->bindValue(':address', $address, PDO::PARAM_STR);
        $stmt->bindValue(':tel', $tel, PDO::PARAM_STR);
        $stmt->bindValue(':worktime', $worktime, PDO::PARAM_STR);
        $stmt->bindValue(':price', $price, PDO::PARAM_INT);
        $stmt->bindValue(':goukan', $goukan, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function get_admin_id(string $name){
          $dbh = DAO::get_db_connect();

          $sql = "SELECT admin_id FROM admin_store where tmp_store_name = :name";

          $stmt = $dbh->prepare($sql);
          $stmt->bindValue(':name',$name,PDO::PARAM_STR);
          $stmt->execute();
          $id = $stmt->fetch(PDO::FETCH_ASSOC);
          return $id;
    }

    public function get_tmp_data() {
        $dbh = DAO::get_db_connect();

        $sql = "SELECT * FROM admin_store";
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
        $data = [];

        while ($row = $stmt->fetchObject("admin_store")) {
            $data[] = $row;
        }

        return $data;
    }
}

class Admin_imageDAO
{
    public function image_insert(int $id, string $photo)
    {
        $dbh = DAO::get_db_connect();

        $sql = "INSERT INTO admin_store_image
                VALUES(:id,:photo)";

        $stmt = $dbh->prepare($sql);

        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':photo', $photo, PDO::PARAM_STR);
        $stmt->execute();
    }
}

class Admin_hashtagDAO
{
    public function hashtag_insert(int $id, string $tag)
    {
        $dbh = DAO::get_db_connect();

        $sql = "INSERT INTO admin_store_hashtag(admin_id,tmp_hashtag_name)
                VALUES(:id,:tag)";

        $stmt = $dbh->prepare($sql);

        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':tag', $tag, PDO::PARAM_STR);
        $stmt->execute();
    }
}
