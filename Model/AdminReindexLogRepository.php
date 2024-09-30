<?php
/**
 * Copyright © element119. All rights reserved.
 * See LICENCE.txt for licence details.
 */
declare(strict_types=1);

namespace Element119\AdminIndexerReport\Model;

use Element119\AdminIndexerReport\Api\Data\AdminReindexLogInterface;
use Element119\AdminIndexerReport\Api\Data\AdminReindexLogInterfaceFactory;
use Element119\AdminIndexerReport\Api\Data\AdminReindexLogSearchResultsInterfaceFactory;
use Element119\AdminIndexerReport\Api\AdminReindexLogRepositoryInterface;
use Element119\AdminIndexerReport\Model\ResourceModel\AdminReindexLog as AdminReindexLogResource;
use Element119\AdminIndexerReport\Model\ResourceModel\AdminReindexLog\CollectionFactory as AdminReindexLogCollectionFactory;
use Exception;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResults;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

class AdminReindexLogRepository implements AdminReindexLogRepositoryInterface
{
    public function __construct(
        private readonly AdminReindexLogCollectionFactory $adminReindexLogCollectionFactory,
        private readonly AdminReindexLogInterfaceFactory $adminReindexLogFactory,
        private readonly AdminReindexLogResource $resource,
        private readonly AdminReindexLogSearchResultsInterfaceFactory $searchResultsFactory,
        private readonly CollectionProcessorInterface $collectionProcessor,
    ) {
    }

    /**
     * @inheritDoc
     */
    public function save(AdminReindexLogInterface $adminReindexLog): AdminReindexLogInterface
    {
        try {
            $this->resource->save($adminReindexLog);
        } catch (Exception $e) {
            throw new CouldNotSaveException(__('Could not save the log: %1', $e->getMessage()));
        }

        return $adminReindexLog;
    }

    /**
     * @inheritDoc
     */
    public function getById($logId): AdminReindexLogInterface
    {
        $adminReindexLog = $this->adminReindexLogFactory->create();
        $this->resource->load($adminReindexLog, $logId);

        if (!$adminReindexLog->getId()) {
            throw new NoSuchEntityException(__('Admin reindex log with ID "%1" does not exist.', $logId));
        }

        return $adminReindexLog;
    }

    /**
     * @inheritDoc
     */
    public function getList(SearchCriteriaInterface $searchCriteria): SearchResults
    {
        $collection = $this->adminReindexLogCollectionFactory->create();

        $this->collectionProcessor->process($searchCriteria, $collection);

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);

        $items = [];

        foreach ($collection as $adminReindexLog) {
            $items[] = $adminReindexLog;
        }

        $searchResults->setItems($items);
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }

    /**
     * @inheritDoc
     */
    public function delete(AdminReindexLogInterface $adminReindexLog): bool
    {
        try {
            /** @var AdminReindexLogInterface $adminReindexLogModel */
            $adminReindexLogModel = $this->adminReindexLogFactory->create();

            $this->resource->load($adminReindexLogModel, $adminReindexLog->getEntityId());
            $this->resource->delete($adminReindexLogModel);
        } catch (Exception $e) {
            throw new CouldNotDeleteException(
                __('Could not delete the admin reindex log with ID: %1', $e->getMessage())
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
