<?php
namespace app\bootstrap;

use app\repositories\CustomerRepository;
use app\repositories\CustomerRepositoryInterface;
use Yii;
use yii\base\BootstrapInterface;

/**
 * Class ContainerBootstrap
 *
 * Class contains setup application
 *
 * @package app\bootstrap
 */
class ContainerBootstrap implements BootstrapInterface
{
    /**
     * Custom bootstrap application
     *
     * @param \yii\base\Application $app
     */
    public function bootstrap($app)
    {
        $container = Yii::$container;
        $container->setSingleton(CustomerRepositoryInterface::class, CustomerRepository::class);
    }
}