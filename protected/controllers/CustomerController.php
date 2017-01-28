<?php
class CustomerController extends FrameController{

    
    public function __construct(){
    
        $userManager = new UserManager;
    
        $isLogin = $userManager->isLogin();
        $this->setVariable('isLogin', $isLogin);
        if($isLogin === true){
            $this->setVariable('user', $userManager->getLogin());
        }
        $this->BreadCrumbs[Yii::app()->request->baseUrl] = '首頁';
        $this->setCSS('/js/jquery/jquery-ui-1.10.3.custom/ui-lightness/jquery-ui-1.10.3.custom.min.css');
        $this->setVariable('navBarCustomer', 'active');

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
            'phone'    => $_GET['phone'],
            'name'     => $_GET['name'],
            'address'  => $_GET['address']
        ];
        $this->BreadCrumbs['last'] = '客戶管理';

        $this->pageTitle = '客戶管理：列表';

        $this->setJS('/js/customer/index.js');
        $this->setCSS('/css/order.css');
		
		$customerManager = new CustomerManager;
        list($pageVO, $customers) = $customerManager->findList($pageVO, $search);
        $this->layout('customer/index', array(
			'customers' => $customers,
			'pageVO' => $pageVO
        ));
    }

	public function actionAdd(){
        if(isset($_POST['name'], $_POST['name'])){
			$customerManager = new CustomerManager;
			$customerManager->add($_POST);
			$this->redirect(Yii::app()->request->baseUrl.'/customer/');
		}
        $this->BreadCrumbs['last'] = '客戶管理';

        $this->pageTitle = '客戶管理：新增';
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
        $this->setJS('/js/customer/add.js');
		
        $this->layout('customer/edit', array(
			'customer' => $customer
        ));
	}
	
	
}