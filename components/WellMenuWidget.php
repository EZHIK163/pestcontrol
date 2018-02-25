<?php
namespace app\components;

use yii\base\Widget;

class WellMenuWidget extends Widget {
    public function run() {
        return '
<div class="well _menu">
    <h3 class="page-header">Основное меню</h3>
    <ul class="nav menu">
        <li class="item-203 current active">
            <a href="http://pestcontrol.lesnoe-ozero.com/">• Программа пестконтроля</a>
        </li>
        <li class="item-118">
            <a href="http://pestcontrol.lesnoe-ozero.com/kontakty">• Контакты</a>
        </li>
    </ul>
</div>';
    }
}