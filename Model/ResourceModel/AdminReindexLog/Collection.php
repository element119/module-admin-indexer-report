<?php
/**
 * Copyright © element119. All rights reserved.
 * See LICENCE.txt for licence details.
 */
declare(strict_types=1);

namespace Element119\AdminIndexerReport\Model\ResourceModel\AdminReindexLog;

use Element119\AdminIndexerReport\Model\AdminReindexLog;
use Element119\AdminIndexerReport\Model\ResourceModel\AdminReindexLog as AdminReindexLogResourceModel;
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
        $this->_init(AdminReindexLog::class, AdminReindexLogResourceModel::class);
    }
}
