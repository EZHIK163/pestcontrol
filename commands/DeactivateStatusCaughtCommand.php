<?php
namespace app\commands;

use app\repositories\PointStatusRepositoryInterface;
use yii\base\Module;
use yii\console\Controller;
use yii\helpers\Console;

/**
 * Команда деактивации старого статуса пойман вредитель
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

    public function actionCaught()
    {
        $pointStatus = $this->pointStatusRepository->getByCode('caught');
        $pointStatus->setIsActive(false);
        $this->pointStatusRepository->save($pointStatus);

        $this->stdout('Статус "Вредитель пойман" отключен' . PHP_EOL, Console::FG_GREEN);
    }
}
