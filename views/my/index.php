<?php

/* @var $this yii\web\View */

?>
<div class="site-index container">
    <div class="body-content">
        <div class="row">
            <div class="col-lg-8">
                <h4>本月统计</h4>
                <div class="row">
                  <div class="col-xs-4"><i class="glyphicon glyphicon-plus"></i> 收入</div>
                  <div class="col-xs-8"><?=$month_account_income_all?></div>
                </div>
                <div class="row">
                  <div class="col-xs-4"><i class="glyphicon glyphicon-minus"></i> 支出</div>
                  <div class="col-xs-8"><?=$month_account_all?></div>
                </div>
                <div class="row">
                  <div class="col-xs-4"><i class="glyphicon glyphicon-resize-small"></i> 剩余</div>
                  <div class="col-xs-8"><?=$month_balance?> (<?=$month_plan?>)</div>
                </div>
            </div>
        </div>
        <div class="row">
            &nbsp;
        </div>
        <div class="row">
            <div class="col-lg-8">
                <h4>日消费统计</h4>
                <table class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>日期</th>
                      <th>消费</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php foreach( $month_account_list as $account ){ ?>
                   <tr>
                    <td>
                      <?=$account->date?>
                    </td>
                    <td>
                      <?=$account->value?>
                    </td>
                   </tr>
                  <?php } ?>    
                  </tbody>
                 </table>
            </div>
        </div>
    </div>
</div>
