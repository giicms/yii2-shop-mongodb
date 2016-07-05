<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\helpers\Html;
?>
<div class="list-review">
    <?php
    if (!empty($model)) {
        foreach ($model as $value) {
            ?>
            <div class="list-group list-review-group">
                <div class="list-group-item">
                    <h4 class="list-group-item-heading"><?= $value->user->lastname . ' ' . $value->user->firstname ?></h4>
                    <div class="review-detail">
                        <label class="<?= ($value->star >= 1) ? "active" : "" ?>"></label>
                        <label class="<?= ($value->star >= 2) ? "active" : "" ?>"></label>
                        <label class="<?= ($value->star >= 3) ? "active" : "" ?>"></label>
                        <label class="<?= ($value->star >= 4) ? "active" : "" ?>"></label>
                        <label class="<?= ($value->star >= 5) ? "active" : "" ?>"></label>
                    </div>
                    <p class="list-group-item-text">
                        <?= $value->content ?>
                    </p>
                </div>
            </div>
            <?php
        }
    }
    ?>
</div>
<div class="text-right">
    <a href="javascript:void(0)" class="btn btn-danger modal-close">CLOSE</a>
</div>


