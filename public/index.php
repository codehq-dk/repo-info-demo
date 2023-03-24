<?php

use CodeHqDk\RepositoryInformation\DemoProvider;
use CodeHqDk\RepositoryInformation\InformationBlocks\RepositoryNameInformationBlock;
use CodeHqDk\RepositoryInformation\Services\RepositoryInformationService;

require_once('../config/config.php');
/**
 * @var $repo_info_service RepositoryInformationService
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Repository Information Demo</title>
    <link href="css/tables.css" rel='stylesheet' media="all">
</head>
<body>
    <?php
        $repository_information_list = $repo_info_service->list(DemoProvider::DEMO_FILTER_ID);
    ?>
    <div class="table-users">
        <div class="header">Repository Information Demo</div>
        <table class="">
            <thead>
            <tr>
                <?php foreach ($repository_information_list as $repository_information) { ?>
                    <?php foreach ($repository_information->listInformationBlocks() as $information_block) { ?>
                        <td>
                            <?php echo $information_block->getHeadline() ?>
                        </td>
                    <?php } ?>
                    <?php break; ?>
                <?php } ?>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($repository_information_list as $repository_information) { ?>
                <tr>
                    <?php foreach ($repository_information->listInformationBlocks() as $information_block) { ?>
                        <td>
                            <?php if ($information_block->getInfoTypeId() === RepositoryNameInformationBlock::class) { ?>
                                <img src="/images/software-package-png-7.png" style="width:40px;margin-right: 10px;">
                            <?php } ?>
                            <?php /* echo $information_block->getLabel() */ ?>
                            <?php echo $information_block->getValue() ?>
                            <br><?php echo "(" . date("Y-m-d", $information_block->getModifiedTimestamp()) . ")"; ?>
                            <br><?php echo $information_block->getDetails() ?>
                        </td>
                    <?php } ?>
                </tr>
            <?php } ?>
            </tbody>
        </table>
        </div>
    </div>
</body>
</html>
