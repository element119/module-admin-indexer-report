<?php
/**
 * Copyright © element119. All rights reserved.
 * See LICENCE.txt for licence details.
 */
declare(strict_types=1);

namespace Element119\AdminIndexerReport\ViewModel;

use Element119\AdminIndexerReport\Model\IndexerInfo;
use Magento\Framework\View\Element\Block\ArgumentInterface;

class IndexerReport implements ArgumentInterface
{
    public function __construct(
        private readonly IndexerInfo $indexerInfo,
    ) {
    }

    public function getIndexerInfo(): IndexerInfo
    {
        return $this->indexerInfo;
    }
}
