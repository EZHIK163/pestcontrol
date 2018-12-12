<?php
namespace app\controllers;

use app\services\SynchronizeService;
use yii\base\Module;
use yii\console\Controller;

/**
 * Class ConsoleController
 * @package app\controllers
 */
class ConsoleController extends Controller
{
    private $synchronizeService;

    /**
     * ConsoleController constructor.
     * @param $id
     * @param Module $module
     * @param SynchronizeService $synchronizeService
     * @param array $config
     */
    public function __construct($id, Module $module, SynchronizeService $synchronizeService, array $config = [])
    {
        $this->synchronizeService = $synchronizeService;
        parent::__construct($id, $module, $config);
    }

    /**
     * Sync rows from old database
     * @throws \yii\base\InvalidConfigException
     */
    public function actionSynchronizeDataBase()
    {
        $this->synchronizeService->sync();
    }
}
