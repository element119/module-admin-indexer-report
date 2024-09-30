<?php
/**
 * Copyright © element119. All rights reserved.
 * See LICENCE.txt for licence details.
 */
declare(strict_types=1);

namespace Element119\AdminIndexerReport\Model;

use Magento\Framework\App\ResourceConnection;
use Psr\Log\LoggerInterface;
use Zend_Db_Statement_Exception;

class IndexerCronInfo
{
    public function __construct(
        private readonly ResourceConnection $resourceConnection,
        private readonly LoggerInterface $logger,
        private readonly array $cronScheduleColumns = [],
        private readonly array $indexerCronJobs = [],
    ) {
    }

    public function getIndexerCronData(): array
    {
        $data = [];
        $cronScheduleColumns = $this->getEnabledOptions($this->cronScheduleColumns);
        $connection = $this->resourceConnection->getConnection();
        $indexerCronSelect = $connection->select()
            ->from($this->resourceConnection->getTableName('cron_schedule'), $cronScheduleColumns)
            ->where('job_code IN (?)', $this->getEnabledOptions($this->indexerCronJobs));

        try {
            $data = $connection->query($indexerCronSelect)->fetchAll();
        } catch (Zend_Db_Statement_Exception $e) {
            $this->logger->error(
                sprintf('An error occurred when trying to fetch indexer cron data: %s', $e->getMessage())
            );
        }

        return $data ?: [array_fill_keys($cronScheduleColumns, __('N/A'))];
    }

    private function getEnabledOptions(array $options): array
    {
        return array_keys(array_filter($options, fn($option) => $option === true));
    }
}
