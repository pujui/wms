<?php
class CustomerDAO extends BaseDAO{

    public function findOrderList($pageVO, $action = 'PAGE', $search = []){
        $FROM = "FROM
                    wms.customer AS c ";
        $WHERE = "WHERE
                    c.is_del=0 ";
        $bind = [];

        if($search['name'] != ''){
            $WHERE .= " AND customer_name LIKE :name ";
            $bind[':name'] = '%'.$search['name'].'%';
        }
        if($search['address'] != ''){
            $WHERE .= " AND customer_address LIKE :address ";
            $bind[':address'] = '%'.$search['address'].'%';
        }
        if($search['serial_numbers'] != ''){
            $WHERE .= " AND serial_numbers=:serial_numbers ";
            $bind[':serial_numbers'] = '%'.$search['serial_numbers'].'%';
        }
		if($search['phone'] != ''){
            $WHERE .= " AND ( customer_phone=:phone OR customer_tel1=:phone OR customer_tel2=:phone OR customer_fax=:phone ) ";
            $bind[':phone'] = $search['phone'];
        }
    
        if($action == 'PAGE'){
            $bind[':start'] = $pageVO->start;
            $bind[':limit'] = $pageVO->limit;
            return $this->getCommand(
                    "SELECT c.* "
                    .$FROM
                    .$WHERE
                    ."ORDER BY c.customer_id DESC "
                    ."LIMIT :start, :limit " ,
                    $bind
            )
            ->queryAll();
        }else{
            $row = $this->getCommand(
                        "SELECT COUNT(c.customer_id) AS count "
                        .$FROM
                        .$WHERE,
                        $bind
                    )
            ->queryRow();
            return (empty($row))? []: $row;
        }
    }

    public function findUserId($id){
        $sql = "SELECT *
                FROM wms.customer
                WHERE is_del=0 AND customer_id=:customer_id ";
        return $this->queryRow(
                $sql,
                array(':customer_id' => $id)
			);
    }

    /**
     * 建立客戶資料
     */
    public function add($data){
        $sql = "INSERT INTO wms.customer
                    (customer_name, customer_phone, customer_tel1, customer_tel2, customer_fax, customer_address, serial_numbers, createtime) 
                VALUES
                    (:customer_name, :customer_phone, :customer_tel1, :customer_tel2, :customer_fax, :customer_address, :serial_numbers, NOW())";
        $this->bindQuery($sql, array(
            ':customer_name'    => (string)$data['name'],
            ':customer_phone'   => (string)$data['phone'],
            ':customer_tel1'    => (string)$data['tel1'],
            ':customer_tel2'   	=> (string)$data['tel2'],
            ':customer_fax'     => (string)$data['fax'],
            ':customer_address'  => (string)$data['address'],
            ':serial_numbers'  => (string)$data['serial_numbers'],
        ));
    }

    public function edit($id, $data){
        $bind = array(
					':customer_name' => (string)$data['name'],
					':customer_phone' => (string)$data['phone'],
					':customer_tel1' => (string)$data['tel1'],
					':customer_tel2' => (string)$data['tel2'],
					':customer_fax' => (string)$data['fax'],
					':customer_address' => (string)$data['address'],
					':serial_numbers'  => (string)$data['serial_numbers'],
					':customer_id' => (string)$id,
				);
        $sql = "UPDATE wms.customer 
                SET
                    customer_name=:customer_name, 
					customer_phone=:customer_phone, 
					customer_tel1=:customer_tel1, 
					customer_tel2=:customer_tel2, 
					customer_fax=:customer_fax, 
					customer_address=:customer_address,
					serial_numbers=:serial_numbers,
					updatetime=NOW()
                WHERE customer_id=:customer_id ";
        $this->bindQuery($sql, $bind);
    }

}