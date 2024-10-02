<?php
/**
 * Copyright © element119. All rights reserved.
 * See LICENCE.txt for licence details.
 */
declare(strict_types=1);

namespace Element119\AdminIndexerReport\HyvaGridProcessor;

use Element119\AdminIndexerReport\Api\Data\IndexerCronHistoryLogInterface;
use Hyva\Admin\Model\GridSource\AbstractGridSourceProcessor;
use Magento\Framework\Api\SearchCriteriaInterface;

class IndexerCronJobDataProcessor extends AbstractGridSourceProcessor
{
    public function afterLoad($rawResult, SearchCriteriaInterface $searchCriteria, string $gridName)
    {
        $gridData = [];

        /** @var IndexerCronHistoryLogInterface $cronHistoryLog */
        foreach ($rawResult as $cronHistoryLog) {
            $gridData[] = [
                IndexerCronHistoryLogInterface::LOG_ID => $cronHistoryLog->getLogId(),
                IndexerCronHistoryLogInterface::DATE => $cronHistoryLog->getDate(),
                IndexerCronHistoryLogInterface::JOB_DATA => $this->getJobDataHtml($cronHistoryLog->getJobDataAsArray()),
            ];
        }

        return $gridData;
    }

    public function getJobDataHtml(array $jobData): string
    {
        $html = '';

        foreach ($jobData as $status => $data) {
            $html .= '<b>' . $status . ':</b><br>';

            foreach ($data as $jobCode => $cronScheduleIds) {
                $html .= '<span class="job-code">' . $jobCode . ':</span><br>';
                $html .= '<ul class="cron-id-list">';

                foreach ($cronScheduleIds as $id) {
                    $html .= '<li>' . $id . '</li>';
                }

                $html .= '</ul><br>';
            }
        }

        return $html;
    }
}
