<?php

namespace app\models\widget;

use stdClass;

class Widget {

    public static function getWidgetsForAccount() {
        $widget = self::getGeneralWidget();
        $widget_report = self::getReportWidget();
        $widget_admin = self::getAdminWidget();
        $widget_manager = self::getManagerWidget();
        return compact('widget', 'widget_report', 'widget_admin', 'widget_manager');
    }

    public static function getSiteWidget() {
        $widget = new stdClass();
        $widget->title = "Основное меню";
        $widget->class_li = "item";
        $widget->class_ul = "nav menu";
        $widget->items = [
            [
                'url'   => 'http://pestcontrol.lesnoe-ozero.com/',
                'name'  => 'Программа пестконтроля'
            ],
            [
                'url'   => 'http://pestcontrol.lesnoe-ozero.com/kontakty',
                'name'  => 'Контакты'
            ]
        ];

        return $widget;
    }

    private static function getManagerWidget() {
        $widget_manager = new stdClass();
        if (\Yii::$app->user->can('manager')) {
            $widget_manager->title = "Менеджер";
            $widget_manager->class_li = "item";
            $widget_manager->class_ul = "nav menu";
            $widget_manager->items = [
                [
                    'url' => \Yii::$app->urlManager->createAbsoluteUrl(['/']) . 'manager/customers',
                    'name' => 'Клиенты'
                ],
                [
                    'url' => \Yii::$app->urlManager->createAbsoluteUrl(['/']) . 'manager/upload-files',
                    'name' => 'Загрузка файлов'
                ],
                [
                    'url' => \Yii::$app->urlManager->createAbsoluteUrl(['/']) . 'manager/recommendations',
                    'name' => 'Рекомендации'
                ],
                [
                    'url' => \Yii::$app->urlManager->createAbsoluteUrl(['/']) . 'manager/scheme-point-control',
                    'name' => 'Схемы точек контроля'
                ]
            ];
        }
        return $widget_manager;
    }

    private static function getAdminWidget() {
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

    private static function getReportWidget() {
        $widget_report = new stdClass();
        $widget_report->title = "Меню отчетности";
        $widget_report->class_li = "item";
        $widget_report->class_ul = "nav menu";
        $widget_report->items = [
            [
                'url'   => \Yii::$app->urlManager->createAbsoluteUrl(['/']).'account/scheme',
                'name'  => 'Схемы точек контроля'
            ],
            [
                'url'   => \Yii::$app->urlManager->createAbsoluteUrl(['/']).'account/info-on-monitoring',
                'name'  => 'Информация по мониторингу'
            ],
            [
                'url'   => \Yii::$app->urlManager->createAbsoluteUrl(['/']).'account/report-on-point',
                'name'  => 'Отчет по точкам контроля'
            ],
            [
                'url'   => \Yii::$app->urlManager->createAbsoluteUrl(['/']).'account/report-on-material',
                'name'  => 'Отчет по дезсредствам'
            ],
            [
                'url'   => \Yii::$app->urlManager->createAbsoluteUrl(['/']).'account/risk-assessment',
                'name'  => 'Оценка рисков по точкам контроля'
            ],
            [
                'url'   => \Yii::$app->urlManager->createAbsoluteUrl(['/']).'account/occupancy-schedule',
                'name'  => 'График заселенности объекта'
            ],
            [
                'url'   => \Yii::$app->urlManager->createAbsoluteUrl(['/']).'account/recommendations',
                'name'  => 'Рекомендации для Заказчика'
            ],
            [
                'url'   => \Yii::$app->urlManager->createAbsoluteUrl(['/']).'account/general-report',
                'name'  => 'Отчет общей заселенности объекта вредителями'
            ],
            [
                'url'   => \Yii::$app->urlManager->createAbsoluteUrl(['/']).'account/call-employee',
                'name'  => 'Вызов бригады пестконтроля'
            ]
        ];

        return $widget_report;
    }

    private static function getGeneralWidget() {
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
                'url'   => \Yii::$app->urlManager->createAbsoluteUrl(['/']).'site/information-about-the-service-provider',
                'name'  => 'Учредительные документы поставщика услуг'
            ],
            [
                'url'   => \Yii::$app->urlManager->createAbsoluteUrl(['/']).'site/licenses-and-certificates',
                'name'  => 'Лицензии и сертификаты'
            ],
            [
                'url'   => \Yii::$app->urlManager->createAbsoluteUrl(['/']).'site/list-of-disinfectants',
                'name'  => 'Список дез. средств'
            ],
            [
                'url'   => \Yii::$app->urlManager->createAbsoluteUrl(['/']).'site/certificates-of-disinfectants',
                'name'  => 'Сертификаты на дез.средства'
            ],
            [
                'url'   => \Yii::$app->urlManager->createAbsoluteUrl(['/']).'site/documents-for-employees',
                'name'  => 'Документы на сотрудников'
            ],
            [
                'url'   => \Yii::$app->urlManager->createAbsoluteUrl(['/']).'site/contacts',
                'name'  => 'Контакты',
            ]
        ];

        return $widget;
    }

}