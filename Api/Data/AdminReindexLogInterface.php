<?php
/**
 * Copyright © element119. All rights reserved.
 * See LICENCE.txt for licence details.
 */
declare(strict_types=1);

namespace Element119\AdminIndexerReport\Api\Data;

interface AdminReindexLogInterface
{
    public const ADMIN_ID = 'admin_id';
    public const EXECUTED_AT = 'executed_at';
    public const LOG_ID = 'log_id';
    public const SUCCESSFUL_INDEXERS = 'successful_indexers';
    public const UNSUCCESSFUL_INDEXERS = 'unsuccessful_indexers';

    /**
     * @return int
     */
    public function getLogId(): int;

    /**
     * @param int|string $logId
     * @return self
     */
    public function setLogId(int|string $logId): self;

    /**
     * @return int
     */
    public function getAdminId(): int;

    /**
     * @param int|string $adminId
     * @return self
     */
    public function setAdminId(int|string $adminId): self;

    /**
     * @return string
     */
    public function getExecutedAt(): string;

    /**
     * @param string $executedAt
     * @return self
     */
    public function setExecutedAt(string $executedAt): self;

    /**
     * @return string
     */
    public function getSuccessfulIndexers(): string;

    /**
     * @param string $indexers
     * @return self
     */
    public function setSuccessfulIndexers(string $indexers): self;

    /**
     * @return string
     */
    public function getUnsuccessfulIndexers(): string;

    /**
     * @param string $indexers
     * @return self
     */
    public function setUnsuccessfulIndexers(string $indexers): self;
}
