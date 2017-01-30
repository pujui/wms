<?php
class CustomerController extends FrameController{

	private $item_types = [ 0 => '電器', 1 => '材料'];
    
    public function __construct(){
    
        $userManager = new UserManager;
    
        $isLogin = $userManager->isLogin();
        $this->setVariable('isLogin', $isLogin);
        if($isLogin === true){
            $this->setVariable('user', $userManager->getLogin());
        }
        $this->BreadCrumbs[Yii::app()->request->baseUrl] = '首頁';
        $this->setCSS('/js/jquery/jquery-ui-1.10.3.custom/ui-lightness/jquery-ui-1.10.3.custom.min.css');

        $this->__check_login();

        parent::__construct();
    }
    
    private function __check_login(){
        if(UserManager::isLogin() !== true){
            $this->actionErrorPage();
        }
    }

    public function actionIndex(){
        $pageVO = new PageVO;
        $pageVO->page = intval($_GET['p']);
        $pageVO->params = $_GET;
        $pageVO->limit = 30;
        $search = [
            'phone'    => trim($_GET['phone']),
            'name'     => trim($_GET['name']),
            'address'  => trim($_GET['address'])
        ];
        $this->BreadCrumbs['last'] = '客戶管理';

        $this->pageTitle = '客戶管理：列表';
        $this->setVariable('navBarCustomer', 'active');

        $this->setJS('/js/customer/index.js');
        $this->setCSS('/css/order.css');
		
		$customerManager = new CustomerManager;
        list($pageVO, $customers) = $customerManager->findList($pageVO, $search);
        $this->layout('customer/index', array(
			'customers' => $customers,
			'pageVO' => $pageVO
        ));
    }

    public function actionRequestCustomer($name = '', $phone = ''){
		$customerManager = new CustomerManager;
		$customers = $customerManager->findCustomerByCreateOrder($name, $phone);
        $this->renderPartial('customer/requestCustomer', [ 'customers' => $customers]);
    }
	
    public function actionRequestItem($item_name = '', $item_serial = ''){
		$customerManager = new CustomerManager;
		$items = $customerManager->findItemByCreateOrder($item_name, $item_serial);
        $this->renderPartial('customer/requestItem', [ 
			'items' => $items,
			'item_types' => $this->item_types
		]);
    }

	public function actionAdd(){
        if(isset($_POST['name'], $_POST['name'])){
			$customerManager = new CustomerManager;
			$customerManager->add($_POST);
			$this->redirect(Yii::app()->request->baseUrl.'/customer/');
		}
        $this->BreadCrumbs['last'] = '客戶管理';

        $this->pageTitle = '客戶管理：新增';
        $this->setVariable('navBarCustomer', 'active');
        $this->setJS('/js/customer/add.js');
		
        $this->layout('customer/add', array(
        ));
	}

	public function actionEdit($id){
		$customerManager = new CustomerManager;
		$customer = $customerManager->findId($id);
		if(empty($customer)){
			$this->redirect(Yii::app()->request->baseUrl.'/customer/');
		}
        if(isset($_POST['name'], $_POST['name'])){
			$customerManager->edit($id, $_POST);
			$this->redirect(Yii::app()->request->baseUrl.'/customer/');
		}
        $this->BreadCrumbs['last'] = '客戶管理';

        $this->pageTitle = '客戶管理：編輯';
        $this->setVariable('navBarCustomer', 'active');
        $this->setJS('/js/customer/add.js');
		
        $this->layout('customer/edit', array(
			'customer' => $customer
        ));
	}
	
	public function actionItem(){
        $pageVO = new PageVO;
        $pageVO->page = intval($_GET['p']);
        $pageVO->params = $_GET;
        $pageVO->limit = 30;
        $search = [
            'name' => trim($_GET['name']),
            'item_serial' => trim($_GET['item_serial']),
        ];
        $this->BreadCrumbs['last'] = '商品管理';

        $this->pageTitle = '商品管理：列表';
        $this->setVariable('navBarItem', 'active');

        $this->setJS('/js/customer/index.js');
        $this->setCSS('/css/order.css');
		
		$customerManager = new CustomerManager;
        list($pageVO, $items) = $customerManager->findItemList($pageVO, $search);
        $this->layout('customer/item', array(
			'customers' => $items,
			'pageVO' => $pageVO,
			'item_types' => $this->item_types
        ));
	}
	
	public function actionItemAdd(){
        if(isset($_POST['item_serial'], $_POST['item_serial'])){
			$customerManager = new CustomerManager;
			$customerManager->addItem($_POST);
			$this->redirect(Yii::app()->request->baseUrl.'/customer/item');
		}
        $this->BreadCrumbs['last'] = '商品管理';

        $this->pageTitle = '商品管理：新增';
        $this->setVariable('navBarItem', 'active');
        $this->setJS('/js/customer/addItem.js');
		
        $this->layout('customer/itemAdd', array(
			'item_types' => $this->item_types
        ));
	}

	public function actionItemEdit($id){
		$customerManager = new CustomerManager;
		$item = $customerManager->findItemId($id);
		if(empty($item)){
			$this->redirect(Yii::app()->request->baseUrl.'/customer/item');
		}
        if(isset($_POST['item_serial'], $_POST['item_serial'])){
			$customerManager->editItem($id, $_POST);
			$this->redirect(Yii::app()->request->baseUrl.'/customer/item');
		}
        $this->BreadCrumbs['last'] = '商品管理';

        $this->pageTitle = '商品管理：編輯';
        $this->setVariable('navBarItem', 'active');
        $this->setJS('/js/customer/addItem.js');
		
        $this->layout('customer/itemEdit', array(
			'item' => $item,
			'item_types' => $this->item_types
        ));
	}
	
	/**
	 * 進貨入口
	 **/
	public function actionHistoryIn(){
        $this->BreadCrumbs['last'] = '歷程管理';
        $this->pageTitle = '進貨管理：列表';
        $this->setVariable('navBarSendin', 'active');
		$this->__History(0);
	}
	
	/**
	 * 出貨入口
	 **/
	public function actionHistoryOut(){
        $this->BreadCrumbs['last'] = '歷程管理';
        $this->pageTitle = '出貨管理：列表';
        $this->setVariable('navBarSendout', 'active');
		$this->__History(1);
	}
	
	/**
	 * 估價入口
	 **/
	public function actionHistoryFuture(){
        $this->BreadCrumbs['last'] = '歷程管理';
        $this->pageTitle = '估價管理：列表';
        $this->setVariable('navBarSendFuture', 'active');
		$this->__History(2);
	}
	
	private function __History($history_type = 0){
		$template = [
			0 => 'historyIn',
			1 => 'historyOut',
			2 => 'historyFuture',
		];
        $pageVO = new PageVO;
        $pageVO->page = intval($_GET['p']);
        $pageVO->params = $_GET;
        $pageVO->limit = 30;
        $search = [
            'create_start' 		=> trim($_GET['create_start']),
            'create_end' 		=> trim($_GET['create_end']),
            'start' 			=> trim($_GET['start']),
            'end' 				=> trim($_GET['end']),
            'history_serial' 	=> trim($_GET['history_serial']),
            'item_serial' 		=> trim($_GET['item_serial']),
            's' 				=> trim($_GET['s']),
			'history_type'      => $history_type
        ];
        $this->setJS('/js/jquery/jquery.blockUI.js');
        $this->setJS('/js/customer/history.js');
        $this->setCSS('/css/order.css');
		
		$customerManager = new CustomerManager;
        list($pageVO, $histories, $total_money) = $customerManager->findHistoryList($pageVO, $search);
		$ids = [];
		foreach($histories as $row){
			$ids[] = 'ids[]='.$row['history_id'];
		}
        $this->layout('customer/'.$template[$history_type], array(
			'histories' => $histories,
			'total_money' => $total_money,
			'pageVO' => $pageVO,
			'ids' => $ids,
        ));
	}
	
	public function actionHistoryInAdd(){
        $this->BreadCrumbs['last'] = '商品管理';
        $this->pageTitle = '進貨管理：新增';
        $this->setVariable('navBarSendin', 'active');
		$this->__actionHistoryAdd(0);
	}

	public function actionHistoryOutAdd(){
        $this->BreadCrumbs['last'] = '商品管理';
        $this->pageTitle = '出貨管理：新增';
        $this->setVariable('navBarSendout', 'active');
		$this->__actionHistoryAdd(1);
	}

	public function actionHistoryFutureAdd(){
        $this->BreadCrumbs['last'] = '商品管理';
        $this->pageTitle = '估價管理：新增';
        $this->setVariable('navBarSendFuture', 'active');
		$this->__actionHistoryAdd(2);
	}

	private function __actionHistoryAdd($history_type = 0){
		$template = [
			0 => 'In',
			1 => 'Out',
			2 => 'Future',
		];
        if(isset($_POST['process_date'], $_POST['process_date'])){
			$customerManager = new CustomerManager;
			$customerManager->addHistory($_POST, $history_type);
			$this->redirect(Yii::app()->request->baseUrl.'/customer/history'.$template[$history_type]);
		}
        $this->setJS('/js/jquery/jquery.blockUI.js');
        $this->setJS('/js/customer/addHistoryAdd.js');
		
        $this->layout('customer/history'.$template[$history_type].'Add', array(
        ));
	}
	
	
	public function actionHistoryInEdit(){
        $this->BreadCrumbs['last'] = '商品管理';
        $this->pageTitle = '進貨管理：編輯';
        $this->setVariable('navBarSendin', 'active');
		$this->__actionHistoryEdit(0);
	}

	public function actionHistoryOutEdit(){
        $this->BreadCrumbs['last'] = '商品管理';
        $this->pageTitle = '出貨管理：編輯';
        $this->setVariable('navBarSendout', 'active');
		$this->__actionHistoryEdit(1);
	}

	public function actionHistoryFutureEdit(){
        $this->BreadCrumbs['last'] = '商品管理';
        $this->pageTitle = '估價管理：編輯';
        $this->setVariable('navBarSendFuture', 'active');
		$this->__actionHistoryEdit(2);
	}
	
	private function __actionHistoryEdit($history_type = 0){
		$history_id = (string) trim($_GET['id']);
		$template = [
			0 => 'In',
			1 => 'Out',
			2 => 'Future',
		];
		$customerManager = new CustomerManager;
		$list = $customerManager->findHistoryPrint([$history_id]);
		$data = [];
		foreach($list as $row){
			if(!isset($data[$row['history_id']])){
				$row['details'] = [];
				$data[$row['history_id']] = $row;
			}
			$data[$row['history_id']]['details'][] = $row;
		}
		if(empty($data)){
			$this->redirect(Yii::app()->request->baseUrl.'/customer/history'.$template[$history_type]);
		}
		$history = array_pop($data);
		$userVO = UserManager::getLogin();
		if($history['user_id'] != $userVO->userId){
			$this->redirect(Yii::app()->request->baseUrl.'/customer/history'.$template[$history_type]);
		}
		if($_POST['is_del'] == 'deleted'){
			$customerManager = new CustomerManager;
			$customerManager->deleteHistory($history_id);
			$this->redirect(Yii::app()->request->baseUrl.'/customer/history'.$template[$history_type]);
		}
		
        if(isset($_POST['process_date'], $_POST['process_date'])){
			$customerManager = new CustomerManager;
			$customerManager->editHistory($_POST, $history_id);
			$this->redirect(Yii::app()->request->baseUrl.'/customer/history'.$template[$history_type]);
		}
        $this->setJS('/js/jquery/jquery.blockUI.js');
        $this->setJS('/js/customer/addHistoryAdd.js');
		
        $this->layout('customer/history'.$template[$history_type].'Edit', array(
			'history' => $history
        ));
	}
	
	public function actionPrintHistory(){
		$ids = $_GET['ids'];
        if(empty($ids)){
			$this->redirect(Yii::app()->request->baseUrl.'/customer/historyIn');
		}
		$customerManager = new CustomerManager;
		$list = $customerManager->findHistoryPrint($ids);
		$data = [];
		foreach($list as $row){
			if(!isset($data[$row['history_id']])){
				$row['details'] = [];
				$data[$row['history_id']] = $row;
			}
			$data[$row['history_id']]['details'][] = $row;
		}
		$this->renderPartial('customer/printHistory', [ 
			'data' => $data
		]);
	}
}