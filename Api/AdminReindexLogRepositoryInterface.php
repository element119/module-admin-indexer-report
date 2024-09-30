<?php
/**
 * Copyright © element119. All rights reserved.
 * See LICENCE.txt for licence details.
 */
declare(strict_types=1);

namespace Element119\AdminIndexerReport\Api;

use Element119\AdminIndexerReport\Api\Data\AdminReindexLogInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResults;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

interface AdminReindexLogRepositoryInterface
{
    public const MAIN_TABLE = 'e119_admin_reindex_history';

    /**
     * @param AdminReindexLogInterface $adminReindexLog
     * @return AdminReindexLogInterface
     * @throws CouldNotSaveException
     */
    public function save(AdminReindexLogInterface $adminReindexLog): AdminReindexLogInterface;

    /**
     * @param int $logId
     * @return AdminReindexLogInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $logId): AdminReindexLogInterface;

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return SearchResults
     */
    public function getList(SearchCriteriaInterface $searchCriteria): SearchResults;

    /**
     * @param AdminReindexLogInterface $adminReindexLog
     * @return bool true on success
     * @throws CouldNotDeleteException
     */
    public function delete(AdminReindexLogInterface $adminReindexLog): bool;

    /**
     * @param int $logId
     * @return bool true on success
     * @throws NoSuchEntityException
     * @throws CouldNotDeleteException
     */
    public function deleteById(int $logId): bool;
}
