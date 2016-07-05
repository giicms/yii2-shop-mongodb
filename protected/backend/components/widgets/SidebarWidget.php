<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace backend\components\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\db\Query;
use yii\widgets\Menu;
use common\models\User;

class SidebarWidget extends Widget {

    public function init() {
        
    }

    public function run() {
        ?>
        <aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">

                <?php
                echo Menu::widget([
                    'items' => [
                        ['label' => '<i class="fa fa-dashboard"></i> <span>Dashboard</span>', 'url' => ['/site/index']],
                        ['label' => '<i class="fa fa-thumb-tack"></i> <span>Category</span> <i class="fa fa-angle-left pull-right"></i>', 'url' => 'javascript:void(0)', 'items' => [
                                ['label' => '<i class="fa fa-circle-o"></i> Categories', 'url' => ['/category']],
                                ['label' => '<i class="fa fa-circle-o"></i> Add Category', 'url' => ['/category/create']],
                            ],
                        ],
                        ['label' => '<i class="fa fa-thumb-tack"></i> <span>Posts</span> <i class="fa fa-angle-left pull-right"></i>', 'url' => 'javascript:void(0)', 'items' => [

                                ['label' => '<i class="fa fa-circle-o"></i> Posts', 'url' => ['/post']],
                                ['label' => '<i class="fa fa-circle-o"></i> Add post', 'url' => ['/post/create']],
                            ],
                        ],
                        ['label' => '<i class="fa fa-thumb-tack"></i> <span>Blog</span> <i class="fa fa-angle-left pull-right"></i>', 'url' => 'javascript:void(0)', 'items' => [
                                ['label' => '<i class="fa fa-circle-o"></i> Blog', 'url' => ['/blog']],
                                ['label' => '<i class="fa fa-circle-o"></i> Add post', 'url' => ['/blog/create']],
                            ],
                        ],
                        ['label' => '<i class="fa fa-shopping-cart"></i> <span>Orders</span>', 'url' => ['/order/index']],
                        ['label' => '<i class="fa fa-user"></i> <span>Users</span>', 'url' => ['/user/index']],
                        ['label' => '<i class="fa fa-user"></i> <span>Account</span> <i class="fa fa-angle-left pull-right"></i>', 'url' => 'javascript:void(0)', 'items' => [
                                ['label' => '<i class="fa fa-circle-o"></i> Users', 'url' => ['/account']],
                                ['label' => '<i class="fa fa-circle-o"></i> Add user', 'url' => ['/account/create']],
                                ['label' => '<i class="fa fa-circle-o"></i> Profile', 'url' => ['/account/profile']],
                                ['label' => '<i class="fa fa-circle-o"></i> Change password', 'url' => ['/account/changepassword']],
                            ],
                        ],
                    ],
                    'encodeLabels' => false,
                    'submenuTemplate' => "\n<ul class='treeview-menu'>\n{items}\n</ul>\n",
                    'options' => array('class' => 'sidebar-menu')
                ]);
                ?>

            </section>
            <!-- /.sidebar -->
        </aside>


        <?php
    }

}
