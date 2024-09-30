<?php
/**
 * Copyright © element119. All rights reserved.
 * See LICENCE.txt for licence details.
 */
declare(strict_types=1);

namespace Element119\AdminIndexerReport\Ui\DataProvider;

use Element119\AdminIndexerReport\Api\Data\AdminReindexLogInterface;
use Element119\AdminIndexerReport\Api\AdminReindexLogRepositoryInterface;
use Hyva\Admin\Api\HyvaGridArrayProviderInterface;
use Magento\Framework\Api\SearchCriteriaBuilderFactory;
use Magento\Framework\App\ResourceConnection;
use Psr\Log\LoggerInterface;
use Zend_Db_Statement_Exception;

class AdminReindexLog implements HyvaGridArrayProviderInterface
{
    public function __construct(
        private readonly AdminReindexLogRepositoryInterface $adminReindexLogRepository,
        private readonly SearchCriteriaBuilderFactory $searchCriteriaBuilderFactory,
        private readonly ResourceConnection $resourceConnection,
        private readonly LoggerInterface $logger,
    ) { }

    public function getHyvaGridData(): array
    {
        $data = [];
        $connection = $this->resourceConnection->getConnection();
        $adminInfoSelect = $connection->select()
            ->from(
                $this->resourceConnection->getTableName('admin_user'),
                ['user_id', 'CONCAT(firstname, \' \', lastname) AS admin_name']
            )->where(
                'user_id IN (SELECT admin_id FROM ' . AdminReindexLogRepositoryInterface::MAIN_TABLE . ')'
            );

        try {
            $adminInfo = $connection->query($adminInfoSelect)->fetchAll();
        } catch (Zend_Db_Statement_Exception $e) {
            $this->logger->error(sprintf(
                'An error occurred trying to fetch admin info for the admin reindex history report: %s',
                $e->getMessage()
            ));

            return $data;
        }

        $adminMap = array_combine(
            array_column($adminInfo, 'user_id'),
            array_column($adminInfo, 'admin_name')
        );

        $searchCriteria = $this->searchCriteriaBuilderFactory->create();
        $reindexLogs = $this->adminReindexLogRepository->getList($searchCriteria->create());

        /** @var AdminReindexLogInterface $reindexLog */
        foreach ($reindexLogs->getItems() as $reindexLog) {
            $data[] = [
                AdminReindexLogInterface::LOG_ID => $reindexLog->getLogId(),
                'admin_name' => $adminMap[$reindexLog->getAdminId()],
                AdminReindexLogInterface::SUCCESSFUL_INDEXERS => $reindexLog->getSuccessfulIndexers(),
                AdminReindexLogInterface::UNSUCCESSFUL_INDEXERS => $reindexLog->getUnsuccessfulIndexers(),
                AdminReindexLogInterface::EXECUTED_AT => $reindexLog->getExecutedAt(),
            ];
        }

        return $data;
    }
}
