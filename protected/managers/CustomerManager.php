<?php
class CustomerManager{

    /**
     * 訂單列表
     * @param unknown $pageVO
     * @param unknown $search
     * @return [分頁, 資料]
     */
    public function findList($pageVO, $search = []){
        $customerDAO = new CustomerDAO();
        $result = $customerDAO->findOrderList($pageVO, 'TOTAL', $search);
        $pageVO->total = empty($result)? 0: $result['count'];
        $pageVO->createStartRange();
        $list = $customerDAO->findOrderList($pageVO, 'PAGE', $search);
        return [$pageVO, $list];
    }
	
	public function findId($id){
        $customerDAO = new CustomerDAO();
		return $customerDAO->findUserId($id);
	}
	
	public function findCustomerByCreateOrder($name, $phone){
		if($name == '' && $phone == '') return [];
        $customerDAO = new CustomerDAO();
		$search = [
			'name' => $name,
			'phone' => $phone
		];
		return $customerDAO->findCustomerByCreateOrder($search);
	}
	
	public function findItemByCreateOrder($item_name = '', $item_serial = ''){
		if($item_name == '' && $item_serial == '') return [];
        $customerDAO = new CustomerDAO();
		$search = [
			'item_serial' => $item_serial,
			'item_name' => $item_name
		];
		return $customerDAO->findItemByCreateOrder($search);
	}
	
	public function add($data){
        $customerDAO = new CustomerDAO();
		$customerDAO->add($data);
	}
	
	public function edit($id, $data){
        $customerDAO = new CustomerDAO();
		$customerDAO->edit($id, $data);
	}
	
    public function findItemList($pageVO, $search = []){
		$userVO = UserManager::getLogin();
		$search['user_id'] = $userVO->userId;
        $customerDAO = new CustomerDAO();
        $result = $customerDAO->findItemList($pageVO, 'TOTAL', $search);
        $pageVO->total = empty($result)? 0: $result['count'];
        $pageVO->createStartRange();
        $list = $customerDAO->findItemList($pageVO, 'PAGE', $search);
        return [$pageVO, $list];
    }
	
	public function addItem($data){
        $customerDAO = new CustomerDAO();
		$customerDAO->addItem($data);
	}
	
	public function editItem($id, $data){
        $customerDAO = new CustomerDAO();
		$customerDAO->editItem($id, $data);
	}
	
	public function findItemId($id){
        $customerDAO = new CustomerDAO();
		return $customerDAO->findItemId($id);
	}
	
	public function addHistory($data, $history_type){
		$gen_type = [
			0 => 'P',
			1 => 'O',
			2 => 'F'
		];
		$userVO = UserManager::getLogin();
		$insert = [
			'history_serial' => (string)trim($data['history_serial']),
			'process_date' => (string)trim($data['process_date']),
			'customer_id' => (string)trim($data['customer_id']),
			'total_price' => 0,
			'user_id' => $userVO->userId,
			'serial_numbers' => (string)trim($data['serial_numbers']),
			'remark' => (string)trim($data['remark']),
			'history_type' => $history_type,
			'details' => []
		];
		$details = [];
		$items = $data['itemId'];
		if(is_array($items) && !empty($items)){
			foreach($items as $item_key=>$item_id){
				if($item_id < 1) continue;
				$item_count = $data['itemCount'][$item_key];
				$item_price = $data['itemPrice'][$item_key];
				if($item_count < 0 || $item_price < 0) continue;
				$details[] = [
					'history_id' 	=> '',
					'price' 		=> $item_price,
					'item_id' 		=> $item_id,
					'item_count' 	=> $item_count,
					'total_price' 	=> $item_count*$item_price,
				];
				$insert['total_price'] += $item_count*$item_price;
			}
			$insert['details'] = $details;
		}
        $customerDAO = new CustomerDAO();
		if($insert['history_serial'] == ''){
			$insert['history_serial'] = date('Ymd').$gen_type[$history_type].sprintf('%05d', $customerDAO->countHistoryForToday()+1);
		}
		$customerDAO->addHistory($insert);
	}
	
	public function editHistory($data, $history_id){
		$insert = [
			'history_serial' => (string)trim($data['history_serial']),
			'process_date' => (string)trim($data['process_date']),
			'customer_id' => (string)trim($data['customer_id']),
			'total_price' => 0,
			'serial_numbers' => (string)trim($data['serial_numbers']),
			'remark' => (string)trim($data['remark']),
			'details' => []
		];
		$details = [];
		$items = $data['itemId'];
		if(is_array($items) && !empty($items)){
			foreach($items as $item_key=>$item_id){
				if($item_id < 1) continue;
				$item_count = $data['itemCount'][$item_key];
				$item_price = $data['itemPrice'][$item_key];
				if($item_count < 0 || $item_price < 0) continue;
				$details[] = [
					'history_id' 	=> '',
					'price' 		=> $item_price,
					'item_id' 		=> $item_id,
					'item_count' 	=> $item_count,
					'total_price' 	=> $item_count*$item_price,
				];
				$insert['total_price'] += $item_count*$item_price;
			}
			$insert['details'] = $details;
		}
        $customerDAO = new CustomerDAO();
		$customerDAO->editHistory($history_id, $insert);
	}
	
    public function deleteHistory($history_id){
        $customerDAO = new CustomerDAO();
		$customerDAO->deleteHistory($history_id);
    }
	
    public function findHistoryList($pageVO, $search = []){
		$userVO = UserManager::getLogin();
		$search['user_id'] = $userVO->userId;
		
        $customerDAO = new CustomerDAO();
        $result = $customerDAO->findHistoryList($pageVO, 'TOTAL', $search);
        $pageVO->total = empty($result)? 0: $result['count'];
        $pageVO->createStartRange();
        $list = $customerDAO->findHistoryList($pageVO, 'PAGE', $search);
        $total_money = $customerDAO->findHistoryList($pageVO, 'MONEY', $search);
        return [$pageVO, $list, $total_money['total_money']];
    }
	
    public function findHistoryPrint($ids = []){
		$customerDAO = new CustomerDAO();
		return $customerDAO->findHistoryDetail($ids);
	}
	
}