<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace frontend\components\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\db\Query;
use yii\widgets\Menu;

class ManagerWidget extends Widget {

    public function init() {
        
    }

    public function run() {
        ?>
        <ul class="list-unstyled list-item">
            <li>San pham da dang</li>
            <li>San pham da duyet</li>
            <li>San pham da mua</li>
            <li>San pham mua nhieu</li>
            <li>San pham duoc danh gia</li>
        </ul>
        <?php
    }

}
