<?php
/**
 * Copyright © element119. All rights reserved.
 * See LICENCE.txt for licence details.
 */
declare(strict_types=1);

namespace Element119\AdminIndexerReport\Model;

use Element119\AdminIndexerReport\Api\Data\IndexerCronHistoryLogInterface;
use Element119\AdminIndexerReport\Api\Data\IndexerCronHistoryLogInterfaceFactory;
use Element119\AdminIndexerReport\Api\Data\IndexerCronHistoryLogSearchResultsInterfaceFactory;
use Element119\AdminIndexerReport\Api\IndexerCronHistoryLogRepositoryInterface;
use Element119\AdminIndexerReport\Model\ResourceModel\IndexerCronHistoryLog as IndexerCronHistoryLogResource;
use Element119\AdminIndexerReport\Model\ResourceModel\IndexerCronHistoryLog\CollectionFactory as IndexerCronHistoryLogCollectionFactory;
use Exception;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResults;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

class IndexerCronHistoryLogRepository implements IndexerCronHistoryLogRepositoryInterface
{
    public function __construct(
        private readonly IndexerCronHistoryLogCollectionFactory $indexerCronHistoryLogCollectionFactory,
        private readonly IndexerCronHistoryLogInterfaceFactory $indexerCronHistoryLogFactory,
        private readonly IndexerCronHistoryLogResource $resource,
        private readonly IndexerCronHistoryLogSearchResultsInterfaceFactory $searchResultsFactory,
        private readonly CollectionProcessorInterface $collectionProcessor,
    ) {
    }

    /**
     * @inheritDoc
     */
    public function save(IndexerCronHistoryLogInterface $indexerCronHistoryLog): IndexerCronHistoryLogInterface
    {
        try {
            $this->resource->save($indexerCronHistoryLog);
        } catch (Exception $e) {
            throw new CouldNotSaveException(__('Could not save the log: %1', $e->getMessage()));
        }

        return $indexerCronHistoryLog;
    }

    /**
     * @inheritDoc
     */
    public function getById($logId): IndexerCronHistoryLogInterface
    {
        $indexerCronHistoryLog = $this->indexerCronHistoryLogFactory->create();
        $this->resource->load($indexerCronHistoryLog, $logId);

        if (!$indexerCronHistoryLog->getId()) {
            throw new NoSuchEntityException(__('Indexer cron history log with ID "%1" does not exist.', $logId));
        }

        return $indexerCronHistoryLog;
    }

    /**
     * @inheritDoc
     */
    public function getList(SearchCriteriaInterface $searchCriteria): SearchResults
    {
        $collection = $this->indexerCronHistoryLogCollectionFactory->create();

        $this->collectionProcessor->process($searchCriteria, $collection);

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);

        $items = [];

        foreach ($collection as $indexerCronHistoryLog) {
            $items[] = $indexerCronHistoryLog;
        }

        $searchResults->setItems($items);
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }

    /**
     * @inheritDoc
     */
    public function delete(IndexerCronHistoryLogInterface $indexerCronHistoryLog): bool
    {
        try {
            /** @var IndexerCronHistoryLogInterface $indexerCronHistoryLogModel */
            $indexerCronHistoryLogModel = $this->indexerCronHistoryLogFactory->create();

            $this->resource->load($indexerCronHistoryLogModel, $indexerCronHistoryLog->getEntityId());
            $this->resource->delete($indexerCronHistoryLogModel);
        } catch (Exception $e) {
            throw new CouldNotDeleteException(
                __('Could not delete the indexer cron history log with ID: %1', $e->getMessage())
            );
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    public function deleteById($logId): bool
    {
        return $this->delete($this->getById($logId));
    }
}
