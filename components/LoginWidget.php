<?php
namespace app\components;

use yii\base\Widget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

class LoginWidget extends Widget {
    public $model;
//    public function run() {
//        return '
//<div class="well ">
//<h3 class="page-header">Вход на сайт</h3>
//<form action="http://pestcontrol.lesnoe-ozero.com/" method="post" id="login-form" class="form-inline">
//<div class="userdata">
//<div id="form-login-username" class="control-group">
//    <div class="controls">
//        <div class="input-prepend">
//            <span class="add-on">
//                <span class="icon-user hasTooltip" title="" data-original-title="Логин"></span>
//                <label for="modlgn-username" class="element-invisible">Логин</label>
//            </span>
//            <input id="modlgn-username" name="username" class="input-small" tabindex="0" size="18" placeholder="Логин" type="text">
//        </div>
//    </div>
//</div>
//<div id="form-login-password" class="control-group">
//    <div class="controls">
//        <div class="input-prepend">
//                <span class="add-on">
//                    <span class="icon-lock hasTooltip" title="" data-original-title="Пароль"></span>
//                    <label for="modlgn-passwd" class="element-invisible">Пароль</label>
//                </span>
//            <input id="modlgn-passwd" name="password" class="input-small" tabindex="0" size="18" placeholder="Пароль" type="password">
//        </div>
//    </div>
//</div>
//<div id="form-login-remember" class="control-group checkbox">
//    <label for="modlgn-remember" class="control-label">Запомнить меня</label>
//    <input id="modlgn-remember" name="remember" class="inputbox" value="yes" type="checkbox">
//</div>
//<div id="form-login-submit" class="control-group">
//    <div class="controls">
//        <button type="submit" tabindex="0" name="Submit" class="btn btn-primary">Войти</button>
//    </div>
//</div>
//<ul class="unstyled">
//    <li>
//        <a href="http://pestcontrol.lesnoe-ozero.com/component/users/?view=remind">
//            Забыли логин?</a>
//    </li>
//    <li>
//        <a href="http://pestcontrol.lesnoe-ozero.com/component/users/?view=reset">
//            Забыли пароль?</a>
//    </li>
//</ul>
//<input name="option" value="com_users" type="hidden">
//<input name="task" value="user.login" type="hidden">
//<input name="return" value="aW5kZXgucGhwP0l0ZW1pZD0xMDE=" type="hidden">
//<input name="e74795ddef9ae340df2b1001c1106377" value="1" type="hidden">	</div>
//</form>
//</div>';
//    }

    public function run() {
        $params = ['id' => 'login-form',
            'fieldConfig' => [
                'options' => [
                    'tag' => false,
                ]
            ],
        ];
        if (\Yii::$app->controller->action->id != 'login') {
            $params = array_merge(['action' => 'site/login'], $params);
        }
        echo '<div class="well">';
        echo '<h3 class="page-header">Вход на сайт</h3>';
        if ($this->model->hasErrors()) {
            //echo $this->model->getErrors()['password'][0];
            echo '
            <div class="alert "><a class="close" data-dismiss="alert">×</a><h4 class="alert-heading">Предупреждение</h4>
			    <div>
			        <p class="alert-message">Имя пользователя и пароль не совпадают или у вас еще нет учетной записи на сайте</p>
			    </div>
			</div>';
        }
        $form = ActiveForm::begin($params);
        echo '<div class="userdata">';
        echo '<div class="controls"><div class="input-prepend"><span class="add-on"><span class="icon-user hasTooltip" title="" data-original-title="Логин"></span><label for="modlgn-username" class="element-invisible">Логин</label></span>';
        echo $form->field($this->model, 'username',
            ['inputOptions' => [
                'id'        => 'modlgn-username',
                'class'     => 'input-small',
                'placeholder'   => 'Логин'
            ]])->label(false);
        echo '</div></div>';
        echo '<div class="controls"><div class="input-prepend"><span class="add-on"><span class="icon-lock hasTooltip" title="" data-original-title="Пароль"></span><label for="modlgn-passwd" class="element-invisible">Пароль</label></span>';
        echo $form->field($this->model, 'password',
            ['inputOptions' => [
                'id'        => 'modlgn-passwd',
                'class'     => 'input-small',
                'placeholder'   => 'Пароль'
            ]])->passwordInput()->label(false);
        echo '</div></div>';
        echo '<div id="form-login-remember" class="control-group checkbox">';
        echo $form->field($this->model, 'rememberMe')->checkbox(['label'    => 'Запомнить меня']);
        echo '</div>';
        echo Html::submitButton(
            'Войти',
            [
                'class'    => 'btn btn-primary',
                'name'    => 'login-button'
            ]
        );
        echo '</div>';
        ActiveForm::end();
        echo '</div>';
    }


}