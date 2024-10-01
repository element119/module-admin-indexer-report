<?php
/**
 * Copyright © element119. All rights reserved.
 * See LICENCE.txt for licence details.
 */
declare(strict_types=1);

namespace Element119\AdminIndexerReport\Cron;

use DateTime;
use Element119\AdminIndexerReport\Api\Data\IndexerCronHistoryLogInterface;
use Element119\AdminIndexerReport\Api\Data\IndexerCronHistoryLogInterfaceFactory;
use Element119\AdminIndexerReport\Api\IndexerCronHistoryLogRepositoryInterface;
use Element119\AdminIndexerReport\Model\IndexerCronInfo;
use Element119\AdminIndexerReport\System\ModuleConfig;
use Magento\Framework\Exception\CouldNotSaveException;

class LogIndexerCronData
{
    public function __construct(
        private readonly IndexerCronHistoryLogInterfaceFactory $indexerCronHistoryLogFactory,
        private readonly IndexerCronHistoryLogRepositoryInterface $indexerCronHistoryLogRepository,
        private readonly IndexerCronInfo $indexerCronInfo,
        private readonly ModuleConfig $moduleConfig,
    ) {
    }

    /**
     * @throws CouldNotSaveException
     */
    public function execute(): void
    {
        if (!$this->moduleConfig->isIndexerHistoryCronEnabled()) {
            return;
        }

        $data = [];

        foreach ($this->getIndexerCronDataForPreviousDay() as $cronData) {
            if (isset($cronData['schedule_id']) && isset($cronData['status']) && isset($cronData['job_code'])) {
                if (!isset($data[$cronData['status']])) {
                    $data[$cronData['status']] = [];
                }

                if (!isset($data[$cronData['status']][$cronData['job_code']])) {
                    $data[$cronData['status']][$cronData['job_code']] = [];
                }

                $data[$cronData['status']][$cronData['job_code']][] = $cronData['schedule_id'];
            }
        }

        /** @var IndexerCronHistoryLogInterface $indexerCronHistoryLog */
        $indexerCronHistoryLog = $this->indexerCronHistoryLogFactory->create();
        $indexerCronHistoryLog->setJobData($data);
        $indexerCronHistoryLog->setDate('yesterday');
        $this->indexerCronHistoryLogRepository->save($indexerCronHistoryLog);
    }

    public function getIndexerCronDataForPreviousDay(): array
    {
        $yesterdayStart = (new DateTime('yesterday'))->setTime(0, 0);
        $yesterdayEnd = (new DateTime('yesterday'))->setTime(23, 59, 59);

        return array_filter(
            $this->indexerCronInfo->getIndexerCronData(),
            function ($data) use ($yesterdayEnd, $yesterdayStart) {
                return isset($data['created_at'])
                    && ($createdAt = strtotime($data['created_at']))
                    && $createdAt >= $yesterdayStart->getTimestamp()
                    && $createdAt <= $yesterdayEnd->getTimestamp();
            }
        );
    }
}
