<?php

namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\mongodb\ActiveRecord;
use yii\mongodb\Collection;
use backend\components\Resize;

class UploadController extends Controller {

    public $enableCsrfValidation = false;

    public function actionMultiple() {

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $output_dir = '../uploads/';
        $fileCount = count($_FILES["myfile"]["name"]);
        $ret = array();
        $error = $_FILES["myfile"]["error"];
        for ($i = 0; $i < $fileCount; $i++) {
            $fileName = $_FILES["myfile"]["name"][$i];
            list($name, $ext) = explode(".", $fileName);
            list($width, $height) = getimagesize($_FILES["myfile"]["tmp_name"][$i]);
            $new_name = md5($name . time());
            if (move_uploaded_file($_FILES["myfile"]["tmp_name"][$i], $output_dir . $new_name . '.png')) {
                $fileNameArray = explode('.', $fileName);
                $fileTypeArray = explode('/', $_FILES["myfile"]["type"][$i]);
                if ($width >= $height) {
                    $x1 = $x2 = ($width - $height) / 2;
                    $y1 = $y2 = 0;
                    $w = $h = $height;
                } else {
                    $x1 = $x2 = 0;
                    $y1 = $y2 = ($height - $width) / 2;
                    $w = $h = $width;
                }

                if ($width > 200)
                    $scale = 150 / $w;
                else
                    $scale = $w / $w;

                if ($width > 500)
                    $scale1 = 500 / $w;
                else
                    $scale1 = $w / $w;
                $cropped = Resize::resizeThumbnailImage($output_dir . 'thumbs/' . $new_name . '.png', $output_dir . $new_name . '.png', $w, $h, $x1, $y1, $scale);
                $cropped1 = Resize::resizeThumbnailImage($output_dir . 'smalls/' . $new_name . '.png', $output_dir . $new_name . '.png', $w, $h, $x1, $y1, $scale1);
                $data[] = ['url' => '/uploads/thumbs/' . $new_name . '.png', 'name' => $new_name . '.png', 'id' => $new_name];
            }
        }
        return ['data' => $data];
    }

}
