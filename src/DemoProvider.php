<?php

namespace CodeHqDk\RepositoryInformation;

use CodeHqDk\RepositoryInformation\Factory\InformationFactoryProvider;
use CodeHqDk\RepositoryInformation\InformationBlocks\DirectDependenciesBlock;
use CodeHqDk\RepositoryInformation\InformationBlocks\HelloWorldInformationBlock;
use CodeHqDk\RepositoryInformation\InformationBlocks\RepositoryNameInformationBlock;
use CodeHqDk\RepositoryInformation\InformationBlocks\RepositoryTypeInformationBlock;
use CodeHqDk\RepositoryInformation\Model\Repository;
use CodeHqDk\RepositoryInformation\Service\InformationBlockFilterService;
use CodeHqDk\RepositoryInformation\Services\InformationBlockService;
use CodeHqDk\RepositoryInformation\Services\RepositoryInformationService;
use CodeHqDk\RepositoryInformation\Services\SimpleInformationBlockFilterService;
use Slince\Di\Container;

class DemoProvider
{
    public const DEMO_FILTER_ID = '8f3251c1-d998-41d6-a45f-1e56513191ed';

    private Container $dependency_injection_container;
    private RepositoryInformationProvider $repository_information_provider;

    /**
     * @param Repository[] $repository_list
     */
    public function __construct(private readonly array $repository_list
    ) {
    }

    public function initialize(): void
    {
        $this->dependency_injection_container = new Container();
        $this->dependency_injection_container->setDefaults(
            [
                'share' => true,
                'autowire' => true,
                'autoregister' => true
            ]
        );

        $this->setupFilteringService();

        $this->repository_information_provider = new RepositoryInformationProvider(
            dirname(__FILE__, 2) . DIRECTORY_SEPARATOR . "data",
            $this->repository_list,
            $this->dependency_injection_container
        );

        $this->repository_information_provider->registerDependencies();
    }

    private function setupFilteringService(): void {
        $this->dependency_injection_container->register(SimpleInformationBlockFilterService::class)->setArguments([
            'information_block_service' => $this->dependency_injection_container->get(InformationBlockService::class),
            'uuid_to_information_block_class_name_list_map' => [
                self::DEMO_FILTER_ID => [
                    RepositoryNameInformationBlock::class,
                    RepositoryTypeInformationBlock::class,
                    HelloWorldInformationBlock::class,
                    DirectDependenciesBlock::class
                ]
            ]
        ]);

        $this->dependency_injection_container->setAlias(InformationBlockFilterService::class, SimpleInformationBlockFilterService::class);
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
        $service = $this->dependency_injection_container->get(RepositoryInformationService::class);

        return $service;
    }
}