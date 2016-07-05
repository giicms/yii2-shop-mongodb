<?php

namespace backend\modules\upload\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\mongodb\ActiveRecord;
use yii\mongodb\Collection;
use backend\modules\upload\components\Resize;

class ImageController extends Controller {

    public function actionIndex() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $output_dir = '/uploads/';
        if (isset($_FILES["myfile"])) {
            $data = [];
            $error = $_FILES["myfile"]["error"];
            if ($error == 0) {
                $fileName = $_FILES["myfile"]["name"];
                $size = number_format($_FILES["myfile"]["size"] / 1024, 2);
                list($name, $ext) = explode(".", $fileName);
                list($width, $height) = getimagesize($_FILES["myfile"]["tmp_name"]);
                $new_name = time();
                if (move_uploaded_file($_FILES["myfile"]["tmp_name"], $output_dir . $new_name . '.' . $ext)) {
                    $fileNameArray = explode('.', $fileName);
                    $fileTypeArray = explode('/', $_FILES["myfile"]["type"]);
                    if ($width >= $height) {
                        $x1 = $x2 = ($width - $height) / 2;
                        $y1 = $y2 = 0;
                        $w = $h = $height;
                    } else {
                        $x1 = $x2 = 0;
                        $y1 = $y2 = ($height - $width) / 2;
                        $w = $h = $width;
                    }

                    if ($width > 400)
                        $scale = 500 / $w;
                    else
                        $scale = $w / $w;
                    $cropped = Resize::resizeThumbnailImage($output_dir . 'thumbnails/' . $new_name . '.png', $output_dir . $new_name . '.' . $ext, $w, $h, $x1, $y1, $scale);
                    $data = ['url' => Yii::$app->setting->value("url_file") . 'thumbnails/' . $new_name . '.png', 'size' => $size, 'name' => $new_name . '.png', 'img_id' => $new_name];
                }
            } else {
                $data = ['error' => 'Dung lượng upload quá 2 MB, hoặc hình không đúng định dạng (jpg,png,jpeg,gif). '];
            }
            return [
                'data' => $data
            ];
        }
    }

    public function actionMultiple() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $output_dir = 'products/';
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

                if ($width > 400)
                    $scale = 500 / $w;
                else
                    $scale = $w / $w;
                $cropped = Resize::resizeThumbnailImage($output_dir . 'thumbs/' . $new_name . '.png', $output_dir . $new_name . '.png', $w, $h, $x1, $y1, $scale);
                $data[] = ['url' => Yii::$app->getUrlManager()->getBaseUrl() . '/products/thumbs/' . $new_name . '.png', 'name' => $new_name . '.png', 'id' => $new_name];
            }
        }
        return ['data' => $data];
    }

    public function actionRemove() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (file_exists(Yii::$app->params['file'] . $_POST['file'])) {
            unlink(Yii::$app->params['file'] . $_POST['file']);
            return ['ok'];
        } else {
            return ['error'];
        }
    }

}
