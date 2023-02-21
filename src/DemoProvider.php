<?php

namespace CodeHqDk\RepositoryInformation;

use CodeHqDk\RepositoryInformation\Factory\InformationFactoryProvider;
use CodeHqDk\RepositoryInformation\Model\Repository;
use CodeHqDk\RepositoryInformation\Services\RepositoryInformationService;
use Slince\Di\Container;

class DemoProvider
{
    private Container $dependecy_injection_container;
    private RepositoryInformationProvider $repository_information_provider;

    /**
     * @param Repository[] $repository_list
     */
    public function __construct(private readonly array $repository_list
    ) {
    }

    public function initialize(): void
    {
        $this->dependecy_injection_container = new Container();
        $this->dependecy_injection_container->setDefaults(
            [
                'share' => true,
                'autowire' => false,
                'autoregister' => true
            ]
        );

        $this->repository_information_provider = new RepositoryInformationProvider(
            dirname(__FILE__, 2) . DIRECTORY_SEPARATOR . "data",
            $this->repository_list,
            $this->dependecy_injection_container
        );

        $this->repository_information_provider->registerDependencies();
    }

    public function addInformationFactoryProvider(InformationFactoryProvider $information_factory_provider): void
    {
        $this->repository_information_provider->addInformationFactoryProvider($information_factory_provider);
    }

    public function getRepositoryInformationService(): RepositoryInformationService
    {
        /**
         * @var $service RepositoryInformationService
         */
        $service = $this->dependecy_injection_container->get(RepositoryInformationService::class);

        return $service;
    }
}