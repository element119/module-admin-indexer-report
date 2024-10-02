<?php
/**
 * Copyright © element119. All rights reserved.
 * See LICENCE.txt for licence details.
 */
declare(strict_types=1);

namespace Element119\AdminIndexerReport\Ui\DataProvider;

use Element119\AdminIndexerReport\Model\IndexerCronInfo;
use Hyva\Admin\Api\HyvaGridArrayProviderInterface;

class IndexerCronHistoryLog implements HyvaGridArrayProviderInterface
{
    public function __construct(
        private readonly IndexerCronInfo $indexerCronInfo,
    ) {
    }

    public function getHyvaGridData(): array
    {
        return $this->indexerCronInfo->getIndexerCronHistoryLogs();
    }
}
