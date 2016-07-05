<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace frontend\components\widgets;

use Yii;
use yii\base\Widget;

class RatingWidget extends Widget {

    public $rating;
    public $id;

    public function init() {
        
    }

    public function run() {
        $rating = $this->rating;
        ?>
        <span class="rating" >
            <input class="stars" type="radio" id="star5<?= $this->id ?>" name="rating" data="<?= $this->id ?>" value="5"  <?= ($rating == 5) ? "checked" : "" ?>/>
            <label class="full" for="star5<?= $this->id ?>" title="5 stars"></label>
            <input class="stars" type="radio" id="star4<?= $this->id ?>" name="rating" value="4" data="<?= $this->id ?>"  <?= ($rating == 4) ? "checked" : "" ?>/>
            <label class = "full" for="star4<?= $this->id ?>" title="4 stars"></label>
            <input class="stars" type="radio" id="star3<?= $this->id ?>" name="rating" value="3" data="<?= $this->id ?>" <?= ($rating == 3) ? "checked" : "" ?>/>
            <label class="full" for="star3<?= $this->id ?>" title="3 stars"></label>
            <input class="stars" type="radio" id="star2<?= $this->id ?>" name="rating" value="2" data="<?= $this->id ?>"  <?= ($rating == 2) ? "checked" : "" ?>/>
            <label class = "full" for="star2<?= $this->id ?>" title="2 star"></label>
            <input class="stars" type="radio" id="star1<?= $this->id ?>" name="rating" value="1" data="<?= $this->id ?>"  <?= ($rating == 1) ? "checked" : "" ?>/>
            <label class="full" for="star1<?= $this->id ?>" title="1 stars"></label>
        </span>
        <?php
    }

}
?>
<?= Yii::$app->view->registerJs('
  $(document).ready(function () {
                            $(".stars").click(function () {
                            var rate = $(this).val();
                            $("#review-star").val(rate);
//                                $.post("ajax/rating",{rate:$(this).val(),id:$(this).attr("data")},function(d){
//                                 
//                                });
                                $(this).attr("checked");
                            });
                        });
') ?>