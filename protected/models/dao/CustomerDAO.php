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
            $WHERE .= " AND ( customer_phone LIKE :phone OR customer_tel1 LIKE :phone OR customer_tel2 LIKE :phone OR customer_fax LIKE :phone ) ";
            $bind[':phone'] = '%'.$search['phone'].'%';
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

    public function findCustomerByCreateOrder($search = []){
        $FROM = "FROM
                    wms.customer AS c ";
        $WHERE = "WHERE
                    c.is_del=0 ";
        $bind = [];
        if($search['name'] != ''){
            $WHERE .= " AND customer_name LIKE :name ";
            $bind[':name'] = '%'.$search['name'].'%';
        }
		if($search['phone'] != ''){
            $WHERE .= " AND ( customer_phone LIKE :phone OR customer_tel1 LIKE :phone OR customer_tel2 LIKE :phone OR customer_fax LIKE :phone ) ";
            $bind[':phone'] = '%'.$search['phone'].'%';
        }
        if($search['address'] != ''){
            $WHERE .= " AND customer_address LIKE :address ";
            $bind[':address'] = '%'.$search['address'].'%';
        }
		return $this->getCommand(
						"SELECT c.* "
						.$FROM
						.$WHERE
						."ORDER BY c.customer_id DESC ",
						$bind
					)
					->queryAll();
    }

    public function findItemByCreateOrder($search = []){
        $FROM = "FROM
                    wms.item AS c ";
        $WHERE = "WHERE
                    1 ";
        $bind = [];
        if($search['item_name'] != ''){
            $WHERE .= " AND item_name LIKE :item_name ";
            $bind[':item_name'] = '%'.$search['item_name'].'%';
        }
		if($search['item_serial'] != ''){
            $WHERE .= " AND item_serial LIKE :item_serial ";
            $bind[':item_serial'] = '%'.$search['item_serial'].'%';
        }
		return $this->getCommand(
						"SELECT c.* "
						.$FROM
						.$WHERE
						."ORDER BY c.item_id DESC ",
						$bind
					)
					->queryAll();
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
            ':customer_address' => (string)$data['address'],
            ':serial_numbers'   => (string)$data['serial_numbers'],
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
					':customer_id' => (int)$id,
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

    public function findItemList($pageVO, $action = 'PAGE', $search = []){
        $FROM = "FROM
                    wms.item AS i ";
        $WHERE = "WHERE 1 ";
        $bind = [':user_id' => $search['user_id']];
		
        if($search['name'] != ''){
            $WHERE .= " AND item_name LIKE :name ";
			$bind['name'] = '%'.$search['name'].'%';
        }
        if($search['item_serial'] != ''){
            $WHERE .= " AND i.item_serial LIKE :item_serial ";
            $bind[':item_serial'] = '%'.$search['item_serial'].'%';
        }
        if($action == 'PAGE'){
            $bind[':start'] = $pageVO->start;
            $bind[':limit'] = $pageVO->limit;
            return $this->getCommand(
                    "SELECT i.*
					,(
					SELECT SUM(item_count) 
					FROM
						wms.history h
						INNER JOIN wms.history_detail hd ON h.history_id=hd.history_id
					WHERE
						h.user_id=:user_id AND hd.item_id=i.item_id
						AND h.history_type=0
					) item_count_in
					,(
					SELECT SUM(item_count) 
					FROM
						wms.history h
						INNER JOIN wms.history_detail hd ON h.history_id=hd.history_id
					WHERE
						h.user_id=:user_id AND hd.item_id=i.item_id
						AND h.history_type=1
					) item_count_out
					"
                    .$FROM
                    .$WHERE
                    ."ORDER BY i.item_id DESC "
                    ."LIMIT :start, :limit " ,
                    $bind
            )
            ->queryAll();
        }else{
            $row = $this->getCommand(
                        "SELECT COUNT(i.item_id) AS count "
                        .$FROM
                        .$WHERE,
                        $bind
                    )
					->queryRow();
            return (empty($row))? []: $row;
        }
    }
	
    /**
     * 建立商品資料
     */
    public function addItem($data){
        $sql = "INSERT INTO wms.item
                    (item_serial, item_name, item_type, primary_price, sell_price) 
                VALUES
                    (:item_serial, :item_name, :item_type, :primary_price, :sell_price)";
        $this->bindQuery($sql, array(
            ':item_serial'  	=> (string)$data['item_serial'],
            ':item_name'   		=> (string)$data['item_name'],
            ':item_type'    	=> (int)$data['item_type'],
            ':primary_price'  	=> (int)$data['primary_price'],
            ':sell_price'    	=> (int)$data['sell_price'],
        ));
    }

    public function findItemId($id){
        $sql = "SELECT *
                FROM wms.item
                WHERE item_id=:item_id ";
        return $this->queryRow(
                $sql,
                array(':item_id' => $id)
			);
    }

    public function editItem($id, $data){
        $bind = array(
					':item_serial' => (string)$data['item_serial'],
					':item_name' => (string)$data['item_name'],
					':item_type' => (int)$data['item_type'],
					':primary_price' => (int)$data['primary_price'],
					':sell_price' => (int)$data['sell_price'],
					':item_id' => (int)$id,
				);
        $sql = "UPDATE wms.item 
                SET
                    item_serial=:item_serial, 
					item_name=:item_name, 
					item_type=:item_type, 
					primary_price=:primary_price,
					sell_price=:sell_price
                WHERE item_id=:item_id ";
        $this->bindQuery($sql, $bind);
    }
	
    /**
     * 建立客戶資料
     */
    public function addHistory($insert){
        $transaction = $this->db->beginTransaction();
        try
        {
			$sql = "INSERT INTO wms.history
						(
						user_id
						, history_type
						, history_serial
						, process_date
						, customer_id
						, total_price
						, serial_numbers
						, remark
						, createtime
						) 
					VALUES
						(
						:user_id
						, :history_type
						, :history_serial
						, :process_date
						, :customer_id
						, :total_price
						, :serial_numbers
						, :remark
						, NOW()
						) ";
			$this->bindQuery($sql, array(
				':user_id'    		=> (string)$insert['user_id'],
				':history_type'    	=> (string)$insert['history_type'],
				':history_serial'   => (string)$insert['history_serial'],
				':process_date'    	=> (string)$insert['process_date'],
				':customer_id'     	=> (string)$insert['customer_id'],
				':total_price' 		=> (string)$insert['total_price'],
				':serial_numbers' 	=> (string)$insert['serial_numbers'],
				':remark'   		=> (string)$insert['remark'],
			));
			$history_id = $this->db->getLastInsertID();
			if(empty($insert['details'])){
				$transaction->commit();
				return $history_id;
			}
			$sql = "INSERT INTO wms.history_detail
						(
						history_id
						, price
						, item_id
						, item_count
						, total_price
						, item_sn
						, createtime
						) 
					VALUES  ";
			$bind = $append_sql = [];
			foreach($insert['details'] as $key=>$row){
				$append_sql[] = "(
									:history_id{$key}
									, :price{$key}
									, :item_id{$key}
									, :item_count{$key}
									, :total_price{$key}
									, :item_sn{$key}
									, NOW()
								)";
				$bind[":history_id{$key}"] = $history_id;
				$bind[":price{$key}"] = $row['price'];
				$bind[":item_id{$key}"] = $row['item_id'];
				$bind[":item_count{$key}"] = $row['item_count'];
				$bind[":total_price{$key}"] = $row['total_price'];
				$bind[":item_sn{$key}"] = $row['item_sn'];
			}
			$this->bindQuery($sql . implode(',', $append_sql), $bind);
			$transaction->commit();
        }
        catch(Exception $e)
        {
           $transaction->rollback();
           return false;
        }
    }
	
	
    /**
     * 更新歷程資料
     */
    public function editHistory($history_id, $update){
        $transaction = $this->db->beginTransaction();
        try
        {
			$sql = "UPDATE wms.history 
					SET
						history_serial=:history_serial, 
						process_date=:process_date, 
						customer_id=:customer_id, 
						total_price=:total_price, 
						serial_numbers=:serial_numbers,
						remark=:remark, 
						updatetime=NOW()
					WHERE history_id=:history_id ";
			$this->bindQuery($sql, array(
				':history_id'    	=> (string)$history_id,
				':history_serial'   => (string)$update['history_serial'],
				':process_date'    	=> (string)$update['process_date'],
				':customer_id'     	=> (string)$update['customer_id'],
				':total_price' 		=> (string)$update['total_price'],
				':serial_numbers' 	=> (string)$update['serial_numbers'],
				':remark'   		=> (string)$update['remark'],
			));
			$sql = "DELETE FROM wms.history_detail WHERE history_id=:history_id ";
			$this->bindQuery($sql, array(
				':history_id' => (string)$history_id,
			));
			if(empty($update['details'])){
				$transaction->commit();
				return $history_id;
			}
			$sql = "INSERT INTO wms.history_detail
						(
						history_id
						, price
						, item_id
						, item_count
						, total_price
						, item_sn
						, createtime
						) 
					VALUES  ";
			$bind = $append_sql = [];
			foreach($update['details'] as $key=>$row){
				$append_sql[] = "(
									:history_id{$key}
									, :price{$key}
									, :item_id{$key}
									, :item_count{$key}
									, :total_price{$key}
									, :item_sn{$key}
									, NOW()
								)";
				$bind[":history_id{$key}"] = $history_id;
				$bind[":price{$key}"] = $row['price'];
				$bind[":item_id{$key}"] = $row['item_id'];
				$bind[":item_count{$key}"] = $row['item_count'];
				$bind[":total_price{$key}"] = $row['total_price'];
				$bind[":item_sn{$key}"] = $row['item_sn'];
			}
			$this->bindQuery($sql . implode(',', $append_sql), $bind);
			$transaction->commit();
        }
        catch(Exception $e)
        {
           $transaction->rollback();
           return false;
        }
    }
    /**
     * 刪除歷程資料
     */
    public function deleteHistory($history_id){
        $transaction = $this->db->beginTransaction();
        try
        {
			$sql = "DELETE FROM wms.history WHERE history_id=:history_id ";
			$this->bindQuery($sql, array(
				':history_id' => (string)$history_id,
			));
			$sql = "DELETE FROM wms.history_detail WHERE history_id=:history_id ";
			$this->bindQuery($sql, array(
				':history_id' => (string)$history_id,
			));
			$transaction->commit();
        }
        catch(Exception $e)
        {
           $transaction->rollback();
           return false;
        }
    }

    public function countHistoryForToday(){
        $sql = "SELECT COUNT(history_id) count
                FROM wms.history
                WHERE process_date=CURDATE()
                ";
        $row = $this->getCommand($sql)
                    ->queryRow();
        return (empty($row))? 0: $row['count'];
    }

	/**
	 * 進/出/估 歷程列表查詢
	 * history_type 0: 進貨單, 1: 出貨單, 2: 估價單
	 **/
    public function findHistoryList($pageVO, $action = 'PAGE', $search = []){
		$FROM = "FROM
					wms.history AS h 
					LEFT JOIN wms.customer c ON h.customer_id=c.customer_id ";
        $WHERE = "WHERE
                    h.history_type=:history_type AND h.user_id=:user_id ";
		if($search['s'] == '1'){
			$ORDER_BY = " ORDER BY h.process_date ASC ";
		}else if($search['s'] == '2'){
			$ORDER_BY = " ORDER BY h.createTime DESC ";
		}else if($search['s'] == '3'){
			$ORDER_BY = " ORDER BY h.createTime ASC ";
		}else{
			$ORDER_BY = " ORDER BY h.process_date DESC ";
		}
        $bind = [ ':user_id' => $search['user_id'], ':history_type' => $search['history_type'] ];

        if($search['history_serial'] != ''){
            $WHERE .= " AND h.history_serial LIKE :history_serial ";
            $bind[':history_serial'] = '%'.$search['history_serial'].'%';
        }
        if($search['item_serial'] != '' || $search['item_sn']!=''){
			
			if($search['item_serial'] != ''){
				$child_where = ' INNER JOIN wms.item i ON i.item_id=hd.item_id 
									AND i.item_serial=:item_serial  ';
				$bind[':item_serial'] = '%'.$search['item_serial'].'%';
			}
			if($search['item_sn'] != ''){
				$child_where = ' WHERE hd.item_sn LIKE :item_sn ';
				$bind[':item_sn'] = '%'.$search['item_sn'].'%';
			}
            $WHERE .= " AND h.history_id IN (
							SELECT hd.history_id 
							FROM wms.history_detail hd
							{$child_where}
						)";
        }
        if($search['create_start'] != '' && $search['create_end'] != ''){
            $WHERE .= ' AND h.createTime<=:endDate AND h.createTime>=:create_start ';
            $bind[':create_start'] = $search['create_start'] . ' 00:00:00';
            $bind[':create_end'] = $search['create_end'] . ' 23:59:59';
        }
        if($search['start'] != '' && $search['end'] != ''){
            $WHERE .= ' AND h.process_date<=:process_end AND h.process_date>=:process_start ';
            $bind[':process_start'] = $search['start'] ;
            $bind[':process_end'] = $search['end'] ;
        }
        if($search['name'] != ''){
            $WHERE .= " AND c.customer_name LIKE :name ";
            $bind[':name'] = '%'.$search['name'].'%';
        }
        if($search['address'] != ''){
            $WHERE .= " AND c.customer_address LIKE :address ";
            $bind[':address'] = '%'.$search['address'].'%';
        }
		if($search['phone'] != ''){
            $WHERE .= " AND ( customer_phone LIKE :phone OR customer_tel1 LIKE :phone OR customer_tel2 LIKE :phone OR customer_fax LIKE :phone ) ";
            $bind[':phone'] = '%'.$search['phone'].'%';
        }
        if($action == 'PAGE'){
            $bind[':start'] = $pageVO->start;
            $bind[':limit'] = $pageVO->limit;
            return $this->getCommand(
                    "SELECT h.*
						, c.customer_id, c.customer_name, c.customer_address
						, c.customer_tel1, c.customer_tel2, c.customer_phone, c.customer_fax
						, c.serial_numbers as customer_serial_numbers "
                    .$FROM
                    .$WHERE
                    .$ORDER_BY
                    ."LIMIT :start, :limit " ,
                    $bind
            )
            ->queryAll();
        }else if($action == 'MONEY'){
            return $this->getCommand(
                    "SELECT SUM(h.total_price) total_money "
                    .$FROM
                    .$WHERE,
                    $bind
            )
            ->queryRow();
        }else{
            $row = $this->getCommand(
                        "SELECT COUNT(h.history_id) AS count "
						.$FROM
						.$WHERE,
                        $bind
                    )
            ->queryRow();
            return (empty($row))? []: $row;
        }
    }

    public function findHistoryDetail($ids){
        $FROM = "FROM wms.history h
					LEFT JOIN wms.customer c ON h.customer_id=c.customer_id
					LEFT JOIN wms.history_detail hd ON h.history_id=hd.history_id
					LEFT JOIN wms.item i ON i.item_id=hd.item_id ";
		$bind = $append_where = [];
		foreach($ids as $key=>$id){
			$bind[':history_id'.$key] = $id;
			$append_where[] = ':history_id'.$key;
		}
        $WHERE = "WHERE
                    h.history_id IN (".implode(',', $append_where).") ";
        return $this->getCommand(
                    "SELECT h.*
						, c.customer_id, c.customer_name, c.customer_address
						, c.customer_tel1, c.customer_tel2, c.customer_phone, c.customer_fax
						, c.serial_numbers as customer_serial_numbers 
						, hd.price, hd.item_count, hd.item_sn, hd.total_price as item_total_price, hd. item_id
						, i.item_name, i.item_serial, i.item_type, i.primary_price "
                    .$FROM
                    .$WHERE
                    ."ORDER BY i.item_name " ,
                    $bind
                )
                ->queryAll();
    }

}