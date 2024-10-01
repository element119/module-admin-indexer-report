<?php
/**
 * Copyright © element119. All rights reserved.
 * See LICENCE.txt for licence details.
 */
declare(strict_types=1);

namespace Element119\AdminIndexerReport\Model\ResourceModel\IndexerCronHistoryLog;

use Element119\AdminIndexerReport\Model\IndexerCronHistoryLog;
use Element119\AdminIndexerReport\Model\ResourceModel\IndexerCronHistoryLog as IndexerCronHistoryLogResourceModel;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /** @inheritDoc */
    protected $_idFieldName = 'log_id';

    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(IndexerCronHistoryLog::class, IndexerCronHistoryLogResourceModel::class);
    }
}
