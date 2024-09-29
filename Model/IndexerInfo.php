<?php
/**
 * Copyright © element119. All rights reserved.
 * See LICENCE.txt for licence details.
 */
declare(strict_types=1);

namespace Element119\AdminIndexerReport\Model;

use Magento\Indexer\Model\Indexer;
use Magento\Indexer\Model\Indexer\CollectionFactory as IndexerCollectionFactory;

class IndexerInfo
{
    private array $indexers = [];

    public function __construct(
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
}
