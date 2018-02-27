<?php
namespace app\controllers;
;
use stdClass;
use yii\filters\AccessControl;
use yii\web\Controller;

class AccountController extends Controller {


    public function actionIndex() {

        $widget = $this->getGeneralWidget();
        $widget_report = $this->getReportWidget();
        $widget_admin = $this->getAdminWidget();
        $widget_manager = $this->getManagerWidget();

        return $this->render('index', compact('widget', 'widget_report', 'widget_admin', 'widget_manager'));
    }

    public function behaviors()
    {
        return [
            'access'    => [
                'class' => AccessControl::class,
                'only'  => ['index'],
                'rules' => [
                    [
                        'actions'   => ['index'],
                        'roles'     => ['admin'],
                        'allow'     => true
                    ]
                ]
            ]
        ];
    }

    private function getManagerWidget() {
        $widget_manager = new stdClass();
        if (\Yii::$app->user->can('manager')) {
            $widget_manager->title = "Менеджер";
            $widget_manager->class_li = "item";
            $widget_manager->class_ul = "nav menu";
            $widget_manager->items = [
                [
                    'url' => \Yii::$app->urlManager->createAbsoluteUrl(['/']) . 'manager/customers',
                    'name' => 'Клиенты'
                ]
            ];
        }
        return $widget_manager;
    }

    private function getAdminWidget() {
        $widget_admin = new stdClass();
        if (\Yii::$app->user->can('admin')) {
            $widget_admin->title = "Админка";
            $widget_admin->class_li = "item";
            $widget_admin->class_ul = "nav menu";
            $widget_admin->items = [
                [
                    'url' => \Yii::$app->urlManager->createAbsoluteUrl(['/']) . 'admin/users',
                    'name' => 'Пользователи'
                ]
            ];
        }
        return $widget_admin;
    }

    private function getReportWidget() {
        $widget_report = new stdClass();
        $widget_report->title = "Меню отчетности";
        $widget_report->class_li = "item";
        $widget_report->class_ul = "nav menu";
        $widget_report->items = [
            [
                'url'   => \Yii::$app->urlManager->createAbsoluteUrl(['/']).'skhemy-tochek-kontrolya',
                'name'  => 'Схемы точек контроля'
            ],
            [
                'url'   => \Yii::$app->urlManager->createAbsoluteUrl(['/']).'informatsiya-po-monitoringu',
                'name'  => 'Информация по мониторингу'
            ],
            [
                'url'   => \Yii::$app->urlManager->createAbsoluteUrl(['/']).'otchet-po-tochkam-kontrolya',
                'name'  => 'Отчет по точкам контроля'
            ],
            [
                'url'   => \Yii::$app->urlManager->createAbsoluteUrl(['/']).'otchet-po-dezsredstvam-baltika',
                'name'  => 'Отчет по дезсредствам'
            ],
            [
                'url'   => \Yii::$app->urlManager->createAbsoluteUrl(['/']).'otsenka-riskov-po-tochkam-kontrolya-2',
                'name'  => 'Оценка рисков по точкам контроля'
            ],
            [
                'url'   => \Yii::$app->urlManager->createAbsoluteUrl(['/']).'grafik-zaselennosti-ob-ekta',
                'name'  => 'График заселенности объекта'
            ],
            [
                'url'   => \Yii::$app->urlManager->createAbsoluteUrl(['/']).'rekomendatsii-dlya-zakazchika',
                'name'  => 'Рекомендации для Заказчика'
            ],
            [
                'url'   => \Yii::$app->urlManager->createAbsoluteUrl(['/']).'otchet-obshchej-zaselennosti-ob-ekta-vreditelyami',
                'name'  => 'Отчет общей заселенности объекта вредителями'
            ],
            [
                'url'   => \Yii::$app->urlManager->createAbsoluteUrl(['/']).'vykhoz-brigady-pestkontrolya',
                'name'  => 'Вызов бригады пестконтроля'
            ]
        ];

        return $widget_report;
    }

    public function getGeneralWidget() {
        $widget = new stdClass();
        $widget->title = "Основное меню";
        $widget->class_li = "item";
        $widget->class_ul = "nav menu";
        $widget->items = [
            [
                'url'   => \Yii::$app->urlManager->createAbsoluteUrl(['/']),
                'name'  => 'Главная'
            ],
            [
                'url'   => \Yii::$app->urlManager->createAbsoluteUrl(['/']),
                'name'  => 'Программа пестконтроля'
            ],
            [
                'url'   => \Yii::$app->urlManager->createAbsoluteUrl(['/']).'svedeniya-o-postavshchike-uslug',
                'name'  => 'Учредительные документы поставщика услуг'
            ],
            [
                'url'   => \Yii::$app->urlManager->createAbsoluteUrl(['/']).'litsenzii-sertifikaty-sro-iso',
                'name'  => 'Лицензии и сертификаты'
            ],
            [
                'url'   => \Yii::$app->urlManager->createAbsoluteUrl(['/']).'spisok-dez-sredstv',
                'name'  => 'Список дез. средств'
            ],
            [
                'url'   => \Yii::$app->urlManager->createAbsoluteUrl(['/']).'sert-dezsr',
                'name'  => 'Сертификаты на дез.средства'
            ],
            [
                'url'   => \Yii::$app->urlManager->createAbsoluteUrl(['/']).'dokt-sotrudn',
                'name'  => 'Документы на сотрудников'
            ],
            [
                'url'   => \Yii::$app->urlManager->createAbsoluteUrl(['/']).'kontakty',
                'name'  => 'Контакты',
            ]
        ];

        return $widget;
    }
}