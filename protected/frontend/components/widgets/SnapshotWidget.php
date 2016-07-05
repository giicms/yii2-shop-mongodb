<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace frontend\components\widgets;

use Yii;
use yii\base\Widget;
use common\models\Review;

class SnapshotWidget extends Widget {

    public $id;
    public $star;

    public function init() {
        
    }

    public function run() {
        $count = Review::find()->where(['post_id' => $this->id, 'star' => (string) $this->star])->count();
        ?>
        <div class="row">
            <div class="col-sm-1"><?= $this->star ?> <i class="fa fa-star" style="color:#f7b142"></i></div>
            <div class="col-sm-9">
                <div class="progress">
                    <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="<?= $count ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $count ?>%">
                        <span class="sr-only"><?= $count ?>% Complete (warning)</span>
                    </div>
                </div>
            </div>
            <div class="col-sm-2"><?= $count ?></div>
        </div>

        <?php
    }

}
?>
