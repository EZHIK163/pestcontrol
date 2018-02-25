<?php
namespace app\components;

use yii\base\Widget;
use yii\helpers\Html;

class AuthWidget extends Widget {

    public function run() {
        switch (\Yii::$app->controller->id) {
            case 'site':
                break;
            default:
        echo '<div class="authorization-indicator">';
            if (\Yii::$app->user->isGuest) {
                echo Html::tag('span', 'guest');
                echo Html::a('login', '/site/login');
            }
            else {
                echo Html::tag('span', \Yii::$app->user->identity->username);
                echo Html::a('logout', '/site/logout');
            }
            echo '</div>';
        break;
    }
    }


}