<?php

namespace app\components;

use app\forms\LoginForm;
use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * Class LoginWidget
 * @package app\components
 */
class LoginWidget extends Widget
{
    /**
     * @var LoginForm
     */
    public $model;

    /**
     * @inheritdoc
     */
    public function run()
    {
        $params = ['id'   => 'login-form',
            'fieldConfig' => [
                'options' => [
                    'tag' => false,
                ]
            ],
        ];
        if (Yii::$app->controller->action->id != 'login') {
            $params = array_merge(['action' => 'site/login'], $params);
        }
        echo '<div class="well">';
        echo '<h3 class="page-header">Вход на сайт</h3>';
        if ($this->model->hasErrors()) {
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
        echo $form->field(
            $this->model,
            'username',
            ['inputOptions' => [
                'id'            => 'modlgn-username',
                'class'         => 'input-small',
                'placeholder'   => 'Логин'
            ]]
        )->label(false);
        echo '</div></div>';
        echo '<div class="controls"><div class="input-prepend"><span class="add-on"><span class="icon-lock hasTooltip" title="" data-original-title="Пароль"></span><label for="modlgn-passwd" class="element-invisible">Пароль</label></span>';
        echo $form->field(
            $this->model,
            'password',
            ['inputOptions' => [
                'id'            => 'modlgn-passwd',
                'class'         => 'input-small',
                'placeholder'   => 'Пароль'
            ]]
        )->passwordInput()->label(false);
        echo '</div></div>';
        echo '<div id="form-login-remember" class="control-group checkbox">';
        echo $form->field($this->model, 'rememberMe')->checkbox(['label'    => 'Запомнить меня']);
        echo '</div>';
        echo Html::submitButton(
            'Войти',
            [
                'class'    => 'btn btn-primary',
                'name'     => 'login-button'
            ]
        );
        echo '</div>';
        ActiveForm::end();
        echo '</div>';
    }
}
