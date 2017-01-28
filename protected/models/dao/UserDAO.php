<?php
class UserDAO extends BaseDAO{

    public function findAccount($account){
        $sql = "SELECT * FROM wms.user WHERE account=:account ";
        return $this->queryRow($sql, array(':account' => $account));
    }
    
    public function findUserIds($userIds){
        $sql = "SELECT * FROM wms.user WHERE userId IN ('%s') ";
        return $this->queryAll(sprintf($sql, implode("','", $userIds)));
    }

    public function findUserId($user_id){
        $sql = "SELECT *
                FROM wms.user
                WHERE userId=:userId ";
        return $this->queryRow(
                $sql,
                array(':userId' => $user_id)
        );
    }

    public function editUser($editUserVO, $changePwd = 0){
        $bind = array(':userId' => $editUserVO->userId,':name' => $editUserVO->name, ':isActive' => $editUserVO->isActive);
        if($changePwd == 1){
            $set = ", password=:password, privateKey=:privateKey";
            $bind[':password'] = $editUserVO->password;
            $bind[':privateKey'] = $editUserVO->privateKey;
        }
        $sql = "UPDATE wms.user 
                SET
                    name=:name
                    , isActive=:isActive
                    , updatetime=NOW() 
                    {$set}
                WHERE userId=:userId";
        $this->bindQuery($sql, $bind);
    }

    /**
     * 找尋群組的使用者
     * @param integer $group_id
     */
    public function findUserList(){
        $sql = "SELECT *
                FROM wms.user
                WHERE isActive!=-1
                ORDER BY userId ";
        return $this->getCommand($sql)->queryAll();
    }

    /**
     * 建立帳號
     */
    public function addUser($userVO){
        $sql = "INSERT INTO wms.user
                    (account, name, password, privateKey, isActive, updateTime, createTime) 
                VALUES
                    (:account, :name, :password, :privateKey, :isActive, NOW(), NOW())";
        $this->bindQuery($sql, array(
            ':account'      => $userVO->account,
            ':name'         => $userVO->name,
            ':password'     => $userVO->password,
            ':privateKey'   => $userVO->privateKey,
            ':isActive'     => $userVO->isActive
        ));
    }
}