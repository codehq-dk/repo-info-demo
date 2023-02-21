<?php
require_once('../vendor/autoload.php');

use CodeHqDk\RepositoryInformation\DemoProvider;
use CodeHqDk\RepositoryInformation\Model\GitRepository;
use CodeHqDk\RepositoryInformation\Model\RepositoryCharacteristics;
use CodeHqDk\RepositoryInformation\Provider\HelloWorldInformationFactoryProvider;

$demo_provider = new DemoProvider(
    [
        new GitRepository(
            'repo-info-contracts',
            'Repository information contracts',
            'https://github.com/codehq-dk/repo-info-contracts.git',
            new RepositoryCharacteristics(true, true, true, false),
        ),
        new GitRepository(
            'repo-info-example-plugin',
            'Repository information example plugin',
            'https://github.com/codehq-dk/repo-info-example-plugin.git',
            new RepositoryCharacteristics(true, true, true, false)
        )
    ]
);
$demo_provider->initialize();
$demo_provider->addInformationFactoryProvider(new HelloWorldInformationFactoryProvider());
$repo_info_service = $demo_provider->getRepositoryInformationService();