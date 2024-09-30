<?php
/**
 * Copyright © element119. All rights reserved.
 * See LICENCE.txt for licence details.
 */
declare(strict_types=1);

namespace Element119\AdminIndexerReport\Model;

use Element119\AdminIndexerReport\Api\Data\AdminReindexLogInterface;
use Element119\AdminIndexerReport\Model\ResourceModel\AdminReindexLog as AdminReindexLogResourceModel;
use Magento\Framework\Model\AbstractModel;

class AdminReindexLog extends AbstractModel implements AdminReindexLogInterface
{
    /**
     * @inheritDoc
     */
    public function _construct()
    {
        $this->_init(AdminReindexLogResourceModel::class);
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
    public function setLogId(int|string $logId): self
    {
        return $this->setData(self::LOG_ID, $logId);
    }

    /**
     * @inheritDoc
     */
    public function getAdminId(): int
    {
        return (int)$this->getData(self::ADMIN_ID);
    }

    /**
     * @inheritDoc
     */
    public function setAdminId(int|string $adminId): self
    {
        return $this->setData(self::ADMIN_ID, $adminId);
    }

    /**
     * @inheritDoc
     */
    public function getExecutedAt(): string
    {
        return $this->getData(self::EXECUTED_AT);
    }

    /**
     * @inheritDoc
     */
    public function setExecutedAt(string $executedAt): self
    {
        return $this->setData(self::EXECUTED_AT, $executedAt);
    }

    /**
     * @inheritDoc
     */
    public function getSuccessfulIndexers(): string
    {
        return $this->getData(self::SUCCESSFUL_INDEXERS);
    }

    /**
     * @inheritDoc
     */
    public function setSuccessfulIndexers(string $indexers): self
    {
        return $this->setData(self::SUCCESSFUL_INDEXERS, $indexers);
    }

    /**
     * @inheritDoc
     */
    public function getUnsuccessfulIndexers(): string
    {
        return $this->getData(self::UNSUCCESSFUL_INDEXERS);
    }

    /**
     * @inheritDoc
     */
    public function setUnsuccessfulIndexers(string $indexers): self
    {
        return $this->setData(self::UNSUCCESSFUL_INDEXERS, $indexers);
    }
}
