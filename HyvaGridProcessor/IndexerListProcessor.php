<?php
/**
 * Copyright © element119. All rights reserved.
 * See LICENCE.txt for licence details.
 */
declare(strict_types=1);

namespace Element119\AdminIndexerReport\HyvaGridProcessor;

use Element119\AdminIndexerReport\Api\Data\AdminReindexLogInterface;
use Hyva\Admin\Model\GridSource\AbstractGridSourceProcessor;
use Magento\Framework\Api\SearchCriteriaInterface;

class IndexerListProcessor extends AbstractGridSourceProcessor
{
    public function afterLoad($rawResult, SearchCriteriaInterface $searchCriteria, string $gridName)
    {
        foreach ($rawResult as &$data) {
            $data[AdminReindexLogInterface::SUCCESSFUL_INDEXERS] = $this->getIndexerListHtml(
                $data[AdminReindexLogInterface::SUCCESSFUL_INDEXERS] ?? ''
            );
            $data[AdminReindexLogInterface::UNSUCCESSFUL_INDEXERS] = $this->getIndexerListHtml(
                $data[AdminReindexLogInterface::UNSUCCESSFUL_INDEXERS] ?? ''
            );
        }

        return $rawResult;
    }

    public function getIndexerListHtml(string $indexerList): string
    {
        return str_replace(',', '<br>', $indexerList);
    }
}
