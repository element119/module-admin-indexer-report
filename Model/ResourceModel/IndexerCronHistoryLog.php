<?php
/**
 * Copyright © element119. All rights reserved.
 * See LICENCE.txt for licence details.
 */
declare(strict_types=1);

namespace Element119\AdminIndexerReport\Model\ResourceModel;

use Element119\AdminIndexerReport\Api\Data\IndexerCronHistoryLogInterface;
use Element119\AdminIndexerReport\Api\IndexerCronHistoryLogRepositoryInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class IndexerCronHistoryLog extends AbstractDb
{
    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(IndexerCronHistoryLogRepositoryInterface::MAIN_TABLE, IndexerCronHistoryLogInterface::LOG_ID);
    }
}
