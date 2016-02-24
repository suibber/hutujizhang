<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="body-content">
        <div class="row">
            <div class="col-lg-8">
                <h2>month overview</h2>
                <ul>
                    <li>
                        <span><i class="glyphicon glyphicon-plus"></i>income</span>
                        <span><i class="glyphicon glyphicon-yen"></i><?=$month_account_income_all?></span>
                    </li>
                    <li>
                        <span><i class="glyphicon glyphicon-minus"></i>expenditure</span>
                        <span><i class="glyphicon glyphicon-yen"></i><?=$month_account_all?></span>
                    </li>
                    <li>
                        <span><i class="glyphicon glyphicon-resize-small"></i>budget balance</span>
                        <span><i class="glyphicon glyphicon-yen"></i><?=$month_balance?></span>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8">
                <h2>month detail</h2>
                <ul>
                    <?php foreach( $month_account_list as $account ){ ?>
                        <li>
                            <span><?=$account->date?></span>
                            <span><?=$account->value?></span>
                        </li>
                    <?php } ?>    
                </ul>
            </div>
        </div>
    </div>
</div>
