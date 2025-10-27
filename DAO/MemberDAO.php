<?php
require_once 'DAO.php';

class Member
{
    public string $member_id;         // 学籍番号
    public string $member_password;         // パスワード
    public string $member_nickname;         // ニックネーム

}

class MemberDAO
{
    public function member_password_exists(string $member_password)
    {
        $dbh = DAO::get_db_connect();

        $sql = "select *
                    from Member
                    where member_id = :member_password";

        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':member_password', $member_password, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetch();
    }

    public function member_update(string $member_password, string $nickname, string $member_id)
    {
        $dbh = DAO::get_db_connect();

        $sql = "update member
                    set member_password = :member_password,
                    member_nickname = :nickname where member_id = :member_id";

        $stmt = $dbh->prepare($sql);

        $password = password_hash($member_password, PASSWORD_DEFAULT);

        $stmt->bindValue(':member_password', $password, PDO::PARAM_STR);
        $stmt->bindValue(':nickname', $nickname, PDO::PARAM_STR);
        $stmt->bindValue(':member_id', $member_id, PDO::PARAM_STR);
        $stmt->execute();
    }

    public function get_member(string $member_id, string $member_password)
    {
        $dbh = DAO::get_db_connect();

        $sql = "select * from Member where member_id = :member_id";

        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':member_id', $member_id, PDO::PARAM_STR);
        $stmt->execute();
        $member = $stmt->fetchObject('member');

        if ($member !== false) {
            if (password_verify($member_password, $member->member_password)) {
                return $member;
            } else {
                return false;
            }
        }
        //ここはlogin.phpの32行目に返ってくる

    }

    public function update_password(string $member_password, string $member_id)
    {
        $dbh = DAO::get_db_connect();

        $sql = "update member
                    set member_password = :member_password
                    where member_id = :member_id";
        $stmt = $dbh->prepare($sql);

        $password = password_hash($member_password, PASSWORD_DEFAULT);

        $stmt->bindValue(':member_password', $password, PDO::PARAM_STR);
        $stmt->bindValue('member_id', $member_id, PDO::PARAM_STR);
        $stmt->execute();
    }

    public function admin_exists(string $member_id, string $member_password)
    {

        $dbh = DAO::get_db_connect();

        $sql = "select * 
                    from member 
                    where :member_id = '24jn0413' && :member_password = '20050622'";

        $stmt = $dbh->prepare($sql);

        $password = password_hash($member_password, PASSWORD_DEFAULT);
        $stmt->bindValue(':member_password', $password, PDO::PARAM_STR);
        $stmt->bindValue('member_id', $member_id, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }
}
