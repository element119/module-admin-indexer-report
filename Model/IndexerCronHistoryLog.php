<?php
/**
 * Copyright © element119. All rights reserved.
 * See LICENCE.txt for licence details.
 */
declare(strict_types=1);

namespace Element119\AdminIndexerReport\Model;

use DateTime;
use Element119\AdminIndexerReport\Api\Data\IndexerCronHistoryLogInterface;
use Element119\AdminIndexerReport\Model\ResourceModel\IndexerCronHistoryLog as IndexerCronHistoryLogResourceModel;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Stdlib\DateTime as MagentoDateTime;

class IndexerCronHistoryLog extends AbstractModel implements IndexerCronHistoryLogInterface
{
    /**
     * @inheritDoc
     */
    public function _construct()
    {
        $this->_init(IndexerCronHistoryLogResourceModel::class);
    }

    /**
     * @inheritDoc
     */
    public function getDate(): string
    {
        return (new DateTime($this->getData(self::DATE)))->format(MagentoDateTime::DATE_PHP_FORMAT);
    }

    /**
     * @inheritDoc
     */
    public function setDate(string $date = 'now'): IndexerCronHistoryLogInterface
    {
        return $this->setData(self::DATE, (new DateTime($date))->format(MagentoDateTime::DATE_PHP_FORMAT));
    }

    /**
     * @inheritDoc
     */
    public function getJobData(): string
    {
        return $this->getData(self::JOB_DATA);
    }

    /**
     * @inheritDoc
     */
    public function getJobDataAsArray(): array
    {
        return json_decode($this->getJobData(), true);
    }

    /**
     * @inheritDoc
     */
    public function setJobData(array $jobData): self
    {
        return $this->setData(self::JOB_DATA, json_encode($jobData));
    }

    /**
     * @inheritDoc
     */
    public function getLogId(): int
    {
        return (int)$this->getData(self::LOG_ID);
    }

    /**
     * @inheritDoc
     */
    public function setLogId(int $logId): IndexerCronHistoryLogInterface
    {
        return $this->setData(self::LOG_ID, $logId);
    }
}
