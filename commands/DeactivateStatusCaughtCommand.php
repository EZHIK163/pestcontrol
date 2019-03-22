<?php
namespace app\commands;

use app\repositories\PointStatusRepositoryInterface;
use yii\base\Module;
use yii\console\Controller;
use yii\helpers\Console;

/**
 * Class ConsoleController
 * @package app\controllers
 */
class DeactivateStatusCaughtCommand extends Controller
{
    /**
     * @var PointStatusRepositoryInterface
     */
    private $pointStatusRepository;

    /**
     * ConsoleController constructor.
     * @param $id
     * @param Module $module
     * @param PointStatusRepositoryInterface $pointStatusRepository
     * @param array $config
     */
    public function __construct(
        $id,
        Module $module,
        PointStatusRepositoryInterface $pointStatusRepository,
        array $config = []
    ) {
        $this->pointStatusRepository = $pointStatusRepository;
        parent::__construct($id, $module, $config);
    }

    /**
     * Disable point status with code = caught
     */
    public function actionCaught()
    {
        $pointStatus = $this->pointStatusRepository->getByCode('caught');
        $pointStatus->setIsActive(false);
        $this->pointStatusRepository->save($pointStatus);

        $this->stdout('Статус "Вредить пойман" отключен' . PHP_EOL, Console::FG_GREEN);
    }
}
