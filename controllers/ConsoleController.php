<?php
namespace app\controllers;

use app\services\SynchronizeService;
use yii\base\Module;
use yii\console\Controller;

/**
 * Содержит консольные команды
 */
class ConsoleController extends Controller
{
    /** @var SynchronizeService */
    private $synchronizeService;

    /**
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
     * Синхронизировать данные из старой БД в новую
     */
    public function actionSynchronizeDataBase()
    {
        $this->synchronizeService->sync();
    }
}
