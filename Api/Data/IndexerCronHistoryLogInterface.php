<?php
/**
 * Copyright © element119. All rights reserved.
 * See LICENCE.txt for licence details.
 */
declare(strict_types=1);

namespace Element119\AdminIndexerReport\Api\Data;

interface IndexerCronHistoryLogInterface
{
    public const DATE = 'date';
    public const JOB_DATA = 'job_data';
    public const LOG_ID = 'log_id';

    /**
     * @return string
     */
    public function getDate(): string;

    /**
     * @param string $date
     * @return self
     */
    public function setDate(string $date = 'now'): self;

    /**
     * @return string
     */
    public function getJobData(): string;

    /**
     * @return array
     */
    public function getJobDataAsArray(): array;

    /**
     * @param array $jobData
     * @return self
     */
    public function setJobData(array $jobData): self;

    /**
     * @return int
     */
    public function getLogId(): int;

    /**
     * @param int $logId
     * @return self
     */
    public function setLogId(int $logId): self;
}
