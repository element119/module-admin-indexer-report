<?php
/**
 * Copyright © element119. All rights reserved.
 * See LICENCE.txt for licence details.
 */
declare(strict_types=1);

namespace Element119\AdminIndexerReport\Api;

use Element119\AdminIndexerReport\Api\Data\IndexerCronHistoryLogInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResults;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

interface IndexerCronHistoryLogRepositoryInterface
{
    public const MAIN_TABLE = 'e119_indexer_cron_history';

    /**
     * @param IndexerCronHistoryLogInterface $indexerCronHistoryLog
     * @return IndexerCronHistoryLogInterface
     * @throws CouldNotSaveException
     */
    public function save(IndexerCronHistoryLogInterface $indexerCronHistoryLog): IndexerCronHistoryLogInterface;

    /**
     * @param int $logId
     * @return IndexerCronHistoryLogInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $logId): IndexerCronHistoryLogInterface;

    /**
     * @param string $date
     * @return array
     */
    public function getByDate(string $date): array;

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return SearchResults
     */
    public function getList(SearchCriteriaInterface $searchCriteria): SearchResults;

    /**
     * @param IndexerCronHistoryLogInterface $indexerCronHistoryLog
     * @return bool true on success
     * @throws CouldNotDeleteException
     */
    public function delete(IndexerCronHistoryLogInterface $indexerCronHistoryLog): bool;

    /**
     * @param int $logId
     * @return bool true on success
     * @throws NoSuchEntityException
     * @throws CouldNotDeleteException
     */
    public function deleteById(int $logId): bool;
}
