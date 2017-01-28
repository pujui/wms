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
	
	
	public function add($data){
        $customerDAO = new CustomerDAO();
		$customerDAO->add($data);
	}
	
	public function edit($id, $data){
        $customerDAO = new CustomerDAO();
		$customerDAO->edit($id, $data);
	}
	
}