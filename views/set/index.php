<?php

/* @var $this yii\web\View */

?>
<div class="site-index container">
    <div class="body-content">
        <form action="/set/update" method="post">
          <div class="form-group">
            <label>昵称</label>
            <input class="form-control" id="nickname" name="nickname" value="<?=$user['nickname']?>">
          </div>
          <div class="form-group">
            <label>每月预算</label>
            <input class="form-control" id="month_plan" name="month_plan" value="<?=$month_plan?>">
          </div>
          <button type="submit" class="btn btn-default">保存</button>
        </form>
    </div>
</div>
