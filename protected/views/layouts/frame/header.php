<header>
    <div id="header">
        <div role="navigation">
          <ul class="nav nav-justified nav-orderSystem">
            <?php if($isLogin === true){ ?>
            <li class="<?=$navBarSendin ?>" ><a href="<?=Yii::app()->request->baseUrl; ?>/customer/historyIn">進貨</a></li>
            <li class="<?=$navBarSendout ?>" ><a href="<?=Yii::app()->request->baseUrl; ?>/customer/historyOut">出貨</a></li>
            <li class="<?=$navBarSendFuture ?>" ><a href="<?=Yii::app()->request->baseUrl; ?>/customer/historyFuture">估價</a></li>
            <li class="<?=$navBarItem ?>" ><a href="<?=Yii::app()->request->baseUrl; ?>/customer/item">商品</a></li>
            <li class="<?=$navBarCustomer ?>" ><a href="<?=Yii::app()->request->baseUrl; ?>/customer/index">客戶</a></li>
            <li class="<?=$navBarUser ?>" ><a href="<?=Yii::app()->request->baseUrl; ?>/user/index">使用者管理</a></li>
            <li ><a href="<?=Yii::app()->request->baseUrl; ?>/user/logout">登出&nbsp;<?=$user->name ?><br/><?=$user->account ?></a></li>
            <?php }else{ ?>
            <li><a href="#">使用者管理</a></li>
            <li class="<?=$navBarSendin ?>" ><a href="#">進貨</a></li>
            <li class="<?=$navBarSendout ?>" ><a href="#">出貨</a></li>
            <li class="<?=$navBarSendFuture ?>" ><a href="#">估價</a></li>
            <li class="<?=$navBarItem ?>" ><a href="#">商品</a></li>
            <li class="<?=$navBarCustomer ?>" ><a href="#">客戶</a></li>
            <li class="<?=$navBarUser ?>" ><a href="#">登入</a></li>
            <?php } ?>
          </ul>
        </div>
    </div>
</header>