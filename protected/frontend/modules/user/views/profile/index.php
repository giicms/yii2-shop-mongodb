<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <h1>Ho so ca nhan</h1>

        <h4 class="h_title">Thong tin ca nhan <small class="pull-right">Chinh sua</small></h4>
        <dl class="dl-horizontal dl-profile">
            <dt>Name</dt><dd><?= $model->name ?></dd>
            <dt>Avatar</dt><dd>
                <div class="media">
                    <div class="media-left">
                        <a href="#">
                            <img class="media-object" src="..." alt="...">
                        </a>
                    </div>
                    <div class="media-body">
                        <h4 class="media-heading">Ảnh đại diện của bạn</h4>
                        Hãy tạo cảm giác thân thiện và gần gũi với khách hàng 
                        bằng ảnh đại diện của bạn.
                    </div>
                </div>
            </dd>
            <dt>Username</dt><dd><?= $model->username ?></dd>
            <dt>Email</dt><dd><?= $model->email ?></dd>
            <dt>Phone</dt><dd><?= $model->phone ?></dd>
            <dt>Address</dt><dd><?= $model->address ?></dd>
        </dl>
    </div>
</div>
<style>

    .dl-profile dt, .dl-profile dd{
        text-align: left;
        padding: 10px 0;
    }
    .h_title{
        border-bottom: 1px solid #ccc;
    }
</style>