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
		$data['address'] = $data['city1'].$data['city2'].$data['address'];
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
				$item_sn = $data['item_sn'][$item_key];
				if($item_count < 0 || $item_price < 0) continue;
				$details[] = [
					'history_id' 	=> '',
					'price' 		=> $item_price,
					'item_id' 		=> $item_id,
					'item_count' 	=> $item_count,
					'total_price' 	=> $item_count*$item_price,
					'item_sn' 		=> $item_sn,
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
				$item_sn = $data['item_sn'][$item_key];
				if($item_count < 0 || $item_price < 0) continue;
				$details[] = [
					'history_id' 	=> '',
					'price' 		=> $item_price,
					'item_id' 		=> $item_id,
					'item_count' 	=> $item_count,
					'total_price' 	=> $item_count*$item_price,
					'item_sn' 		=> $item_sn,
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
	
	public function getAddress(){
		return [	
				['金門縣', '金沙鎮', '金湖鎮', '金寧鄉', '金城鎮', '烈嶼鄉', '烏坵鄉'],
				['台北市', '中正區', '大同區', '中山區', '松山區', '大安區', '萬華區', '信義區', '士林區', '北投區', '內湖區', '南港區', '文山區'],
				['新北市', '萬里鄉', '金山鄉', '板橋市', '汐止市', '深坑鄉', '石碇鄉', '瑞芳鎮', '平溪鄉', '雙溪鄉', '貢寮鄉', '新店市', '坪林鄉', '烏來鄉', '永和市', '中和市', '土城市', '三峽鎮', '樹林市', '鶯歌鎮', '三重市', '新莊市', '泰山鄉', '林口鄉', '蘆洲市', '五股鄉', '新莊市', '八里鄉', '淡水鎮', '三芝鄉', '石門鄉'],
				['台中市', '中區', '東區', '南區', '西區', '北區', '北屯區', '西屯區', '南屯區'],
				['台中縣', '太平市', '大里市', '霧峰鄉', '烏日鄉', '豐原市', '后里鄉', '石岡鄉', '東勢鎮', '和平鄉', '新社鄉', '潭子鄉', '大雅鄉', '神岡鄉', '大肚鄉', '沙鹿鎮', '龍井鄉', '梧棲鎮', '清水鎮', '大甲鎮', '外埔鄉', '大安鄉'],
				['台東縣', '台東市', '綠島鄉', '蘭嶼鄉', '延平鄉', '卑南鄉', '鹿野鄉', '關山鎮', '海端鄉', '池上鄉', '東河鄉', '成功鎮', '長濱鄉', '太麻里鄉', '金峰鄉', '大武鄉', '達仁鄉'],
				['台南市', '中西區', '東區', '南區', '北區', '安平區', '安南區'],
				['台南縣', '永康市', '歸仁鄉', '新化鎮', '左鎮鄉', '玉井鄉', '楠西鄉', '南化鄉', '仁德鄉', '關廟鄉', '龍崎鄉', '官田鄉', '麻豆鎮', '佳里鎮', '西港鄉', '七股鄉', '將軍鄉', '學甲鎮', '北門鄉', '新營市', '後壁鄉', '白河鎮', '東山鄉', '六甲鄉', '下營鄉', '柳營鄉', '鹽水鎮', '善化鎮', '新市鄉', '大內鄉', '山上鄉', '新市鄉', '安定鄉'],
				['宜蘭縣', '宜蘭市', '頭城鎮', '礁溪鄉', '壯圍鄉', '員山鄉', '羅東鎮', '三星鄉', '大同鄉', '五結鄉', '冬山鄉', '蘇澳鎮', '南澳鄉', '釣魚台'],
				['花蓮縣', '花蓮市', '新城鄉', '秀林鄉', '吉安鄉', '壽豐鄉', '鳳林鎮', '光復鄉', '豐濱鄉', '瑞穗鄉', '萬榮鄉', '玉里鎮', '卓溪鄉', '富里鄉'],
				['南投縣', '南投市', '中寮鄉', '草屯鎮', '國姓鄉', '埔里鎮', '仁愛鄉', '名間鄉', '集集鎮', '水里鄉', '魚池鄉', '信義鄉', '竹山鎮', '鹿谷鄉'],
				['南海島', '東沙群島', '南沙群島'],
				['屏東縣', '屏東市', '三地門鄉', '霧台鄉', '瑪家鄉', '九如鄉', '里港鄉', '高樹鄉', '鹽埔鄉', '長治鄉', '麟洛鄉', '竹田鄉', '內埔鄉', '萬丹鄉', '潮州鎮', '泰武鄉', '來義鄉', '萬巒鄉', '崁頂鄉', '新埤鄉', '南州鄉', '林邊鄉', '東港鎮', '琉球鄉', '佳冬鄉', '新園鄉', '枋寮鄉', '枋山鄉', '春日鄉', '獅子鄉', '車城鄉', '牡丹鄉', '恆春鎮', '滿州鄉'],
				['苗栗縣', '竹南鎮', '頭份鎮', '三灣鄉', '南庄鄉', '獅潭鄉', '後龍鎮', '通霄鎮', '苑裡鎮', '苗栗市', '造橋鄉', '頭屋鄉', '公館鄉', '大湖鄉', '泰安鄉', '銅鑼鄉', '三義鄉', '西湖鄉', '卓蘭鎮'],
				['桃園縣', '中壢市', '平鎮市', '龍潭鄉', '楊梅鎮', '新屋鄉', '觀音鄉', '桃園市', '龜山鄉', '八德市', '大溪鎮', '復興鄉', '大園鄉', '蘆竹鄉'],
				['高雄市', '新興區', '前金區', '苓雅區', '鹽埕區', '鼓山區', '旗津區', '前鎮區', '三民區', '楠梓區', '小港區', '左營區', '東沙群島', '南沙群島'],
				['高雄縣', '仁武鄉', '大社鄉', '岡山鎮', '路竹鄉', '阿蓮鄉', '田寮鄉', '燕巢鄉', '橋頭鄉', '梓官鄉', '彌陀鄉', '永安鄉', '湖內鄉', '鳳山市', '大寮鄉', '林園鄉', '鳥松鄉', '大樹鄉', '旗山鎮', '美濃鎮', '六龜鄉', '內門鄉', '杉林鄉', '甲仙鄉', '桃源鄉', '那瑪夏鄉', '茂林鄉', '茄萣鄉'],
				['基隆市', '仁愛區', '信義區', '中正區', '中山區', '安樂區', '暖暖區', '七堵區'],
				['連江縣', '南竿鄉', '北竿鄉', '莒光鄉', '東引鄉'],
				['釣魚台', '釣魚台'],
				['雲林縣', '斗南鎮', '大埤鄉', '虎尾鎮', '土庫鎮', '褒忠鄉', '東勢鄉', '台西鄉', '崙背鄉', '麥寮鄉', '斗六市', '林內鄉', '古坑鄉', '莿桐鄉', '西螺鎮', '二崙鄉', '北港鎮', '水林鄉', '口湖鄉', '四湖鄉', '元長鄉'],
				['新竹市', '北區', '東區', '香山區'],
				['新竹縣', '寶山鄉', '竹北市', '湖口鄉', '新豐鄉', '新埔鎮', '關西鎮', '芎林鄉', '寶山鄉', '竹東鎮', '五峰鄉', '橫山鄉', '尖石鄉', '北埔鄉', '峨眉鄉'],
				['嘉義市', '西區', '東區'],
				['嘉義縣', '番路鄉', '梅山鄉', '竹崎鄉', '阿里山鄉', '中埔鄉', '大埔鄉', '水上鄉', '鹿草鄉', '太保市', '朴子市', '東石鄉', '六腳鄉', '新港鄉', '民雄鄉', '大林鎮', '溪口鄉', '義竹鄉', '布袋鎮'],
				['彰化縣', '彰化市', '芬園鄉', '花壇鄉', '秀水鄉', '鹿港鎮', '福興鄉', '線西鄉', '和美鎮', '伸港鄉', '員林鎮', '社頭鄉', '永靖鄉', '埔心鄉', '溪湖鎮', '大村鄉', '埔鹽鄉', '田中鎮', '北斗鎮', '田尾鄉', '埤頭鄉', '溪州鄉', '竹塘鄉', '二林鎮', '大城鄉', '芳苑鄉', '二水鄉'],
				['澎湖縣', '馬公市', '西嶼鄉', '望安鄉', '七美鄉', '白沙鄉', '湖西鄉']
			];
	}
}