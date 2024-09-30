<?php
/**
 * Copyright © element119. All rights reserved.
 * See LICENCE.txt for licence details.
 */
declare(strict_types=1);

namespace Element119\AdminIndexerReport\Model\ResourceModel;

use Element119\AdminIndexerReport\Api\Data\AdminReindexLogInterface;
use Element119\AdminIndexerReport\Api\AdminReindexLogRepositoryInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class AdminReindexLog extends AbstractDb
{
    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(AdminReindexLogRepositoryInterface::MAIN_TABLE, AdminReindexLogInterface::LOG_ID);
    }
}
