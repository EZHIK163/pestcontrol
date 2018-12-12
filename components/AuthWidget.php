<?php
namespace app\components;

use yii\base\Widget;
use yii\helpers\Html;

class AuthWidget extends Widget
{
    public function run()
    {
        switch (\Yii::$app->controller->id) {
            case 'site':
                break;
            default:
        echo '<div class="authorization-indicator">';
            if (\Yii::$app->user->isGuest) {
                echo Html::tag('span', 'guest', ['class'   => 'authorization-indicator2']);
                echo Html::a('Войти', '/site/login');
            } else {
                echo Html::tag('span', \Yii::$app->user->identity->username, ['class'   => 'authorization-indicator2']);
                echo Html::a('Выход', '/site/logout');
            }
            echo '</div>';
        break;
    }
    }
}
