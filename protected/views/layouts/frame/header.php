<header>
    <div id="header">
        <div role="navigation">
          <ul class="nav nav-justified nav-orderSystem">
            <?php if($isLogin === true){ ?>
            <li class="<?=$navBarSendin ?>" ><a href="<?=Yii::app()->request->baseUrl; ?>/customer/sendin">進貨</a></li>
            <li class="<?=$navBarSendout ?>" ><a href="<?=Yii::app()->request->baseUrl; ?>/customer/sendout">出貨</a></li>
            <li class="<?=$navBarItem ?>" ><a href="<?=Yii::app()->request->baseUrl; ?>/customer/item">商品</a></li>
            <li class="<?=$navBarCustomer ?>" ><a href="<?=Yii::app()->request->baseUrl; ?>/customer/index">客戶</a></li>
            <li class="<?=$navBarUser ?>" ><a href="<?=Yii::app()->request->baseUrl; ?>/user/index">使用者管理</a></li>
            <li ><a href="<?=Yii::app()->request->baseUrl; ?>/user/logout">登出<?=$user->account ?></a></li>
            <?php }else{ ?>
            <li><a href="#">使用者管理</a></li>
            <li class="<?=$navBarSendin ?>" ><a href="#">進貨</a></li>
            <li class="<?=$navBarSendout ?>" ><a href="#">出貨</a></li>
            <li class="<?=$navBarItem ?>" ><a href="#">商品</a></li>
            <li class="<?=$navBarCustomer ?>" ><a href="#">客戶</a></li>
            <li class="<?=$navBarUser ?>" ><a href="#">登入</a></li>
            <?php } ?>
          </ul>
        </div>
    </div>
</header>