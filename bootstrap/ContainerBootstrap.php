<?php

namespace app\bootstrap;

use app\repositories\CustomerRepository;
use app\repositories\CustomerRepositoryInterface;
use app\repositories\DisinfectantRepository;
use app\repositories\DisinfectantRepositoryInterface;
use app\repositories\DisinfectorRepository;
use app\repositories\DisinfectorRepositoryInterface;
use app\repositories\EventRepository;
use app\repositories\EventRepositoryInterface;
use app\repositories\ExtensionRepository;
use app\repositories\ExtensionRepositoryInterface;
use app\repositories\FileCustomerRepository;
use app\repositories\FileCustomerRepositoryInterface;
use app\repositories\FileRepository;
use app\repositories\FileRepositoryInterface;
use app\repositories\PointRepository;
use app\repositories\PointRepositoryInterface;
use app\repositories\PointStatusRepository;
use app\repositories\PointStatusRepositoryInterface;
use app\repositories\UserRepository;
use app\repositories\UserRepositoryInterface;
use Yii;
use yii\base\Application;
use yii\base\BootstrapInterface;

/**
 * Class ContainerBootstrap
 *
 * Class contains setup application
 *
 * @author Samarkin Mikhail <m.e.samarkin@gmail.com>
 */
class ContainerBootstrap implements BootstrapInterface
{
    /**
     * Custom bootstrap application
     *
     * @param Application $app Экземпляр приложения
     *
     * @return void
     */
    public function bootstrap($app)
    {
        $container = Yii::$container;
        $container->setSingleton(
            CustomerRepositoryInterface::class,
            CustomerRepository::class
        );
        $container->setSingleton(
            DisinfectantRepositoryInterface::class,
            DisinfectantRepository::class
        );
        $container->setSingleton(
            DisinfectorRepositoryInterface::class,
            DisinfectorRepository::class
        );
        $container->setSingleton(
            EventRepositoryInterface::class,
            EventRepository::class
        );
        $container->setSingleton(
            PointRepositoryInterface::class,
            PointRepository::class
        );
        $container->setSingleton(
            PointStatusRepositoryInterface::class,
            PointStatusRepository::class
        );
        $container->setSingleton(
            FileCustomerRepositoryInterface::class,
            FileCustomerRepository::class
        );
        $container->setSingleton(
            FileRepositoryInterface::class,
            FileRepository::class
        );
        $container->setSingleton(
            ExtensionRepositoryInterface::class,
            ExtensionRepository::class
        );
        $container->setSingleton(
            UserRepositoryInterface::class,
            UserRepository::class
        );
    }
}
