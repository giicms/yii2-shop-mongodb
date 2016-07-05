<?php
/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>
<div class="page">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h1><?= Html::encode($this->title) ?></h1>

                <div class="alert alert-danger">
                    <?= nl2br(Html::encode($message)) ?>
                </div>

                <p>
                    The above error occurred while the Web server was processing your request.
                </p>
                <p>
                    Please contact us if you think this is a server error. Thank you.
                </p>
                <p>Contact: huynhtuvinh87@gmail.com, Phone: 0905 951699</p>
            </div>
        </div>
    </div>
</div>
