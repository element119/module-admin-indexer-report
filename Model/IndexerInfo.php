<?php
/**
 * Copyright © element119. All rights reserved.
 * See LICENCE.txt for licence details.
 */
declare(strict_types=1);

namespace Element119\AdminIndexerReport\Model;

use Magento\Catalog\Model\Indexer\Product\Eav\AbstractAction as ProductEavIndexerAction;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\DeploymentConfig;
use Magento\Indexer\Model\Indexer;
use Magento\Indexer\Model\Indexer\CollectionFactory as IndexerCollectionFactory;

class IndexerInfo
{
    private array $indexers = [];

    public function __construct(
        private readonly ScopeConfigInterface $scopeConfig,
        private readonly DeploymentConfig $deploymentConfig,
        private readonly IndexerCollectionFactory $indexerCollectionFactory,
    ) {
    }

    public function getAllIndexers(): array
    {
        if (!$this->indexers) {
            $this->indexers = $this->indexerCollectionFactory->create()->getItems();
        }

        return $this->indexers;
    }

    public function getRealTimeIndexers(): array
    {
        $indexers = [];

        /** @var Indexer $indexer */
        foreach ($this->getAllIndexers() as $indexer) {
            if (!$indexer->isScheduled()) {
                $indexers[$indexer->getId()] = $indexer->getTitle();
            }
        }

        return $indexers;
    }

    public function getScheduledIndexers(): array
    {
        $indexers = [];

        /** @var Indexer $indexer */
        foreach ($this->getAllIndexers() as $indexer) {
            if ($indexer->isScheduled()) {
                $indexers[$indexer->getId()] = $indexer->getTitle();
            }
        }

        return $indexers;
    }

    public function getIndexerBatchSizeDeploymentConfig(string $indexer): array|string
    {
        $indexerConfig = $this->deploymentConfig->get('indexer');

        if ($indexerConfig
            && array_key_exists('batch_size', $indexerConfig)
            && array_key_exists($indexer, $indexerConfig['batch_size'])
        ) {
            $batchSize = $indexerConfig['batch_size'][$indexer];

            return is_array($batchSize) ? $batchSize : (string)$batchSize;
        }

        return '';
    }

    public function isProductEavIndexerEnabled(): bool
    {
        return $this->scopeConfig->isSetFlag(ProductEavIndexerAction::ENABLE_EAV_INDEXER);
    }

    public function isIndexerApplicationLockEnabled(): bool
    {
        $indexerConfig = $this->deploymentConfig->get('indexer');

        return $indexerConfig
            && array_key_exists('use_application_lock', $indexerConfig)
            && $indexerConfig['use_application_lock'];
    }
}
