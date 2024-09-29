<?php
/**
 * Copyright © element119. All rights reserved.
 * See LICENCE.txt for licence details.
 */
declare(strict_types=1);

namespace Element119\AdminIndexerReport\ViewModel;

use Element119\AdminIndexerReport\Model\IndexerInfo;
use Magento\Framework\Module\ModuleListInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;

class IndexerReport implements ArgumentInterface
{
    public function __construct(
        private readonly IndexerInfo $indexerInfo,
        private readonly ModuleListInterface $moduleList,
    ) {
    }

    public function getIndexerInfo(): IndexerInfo
    {
        return $this->indexerInfo;
    }

    public function isIndexerDeployConfigModuleInstalled(): bool
    {
        return $this->moduleList->has('Element119_IndexerDeployConfig');
    }
}
