<?php
/**
 * Copyright © element119. All rights reserved.
 * See LICENCE.txt for licence details.
 */
declare(strict_types=1);

namespace Element119\AdminIndexerReport\System;

use Magento\Framework\App\Config\ScopeConfigInterface;

class ModuleConfig
{
    private const XML_PATH_CRON_ENABLE = 'system/indexer_report/cron_enable';

    public function __construct(
        private readonly ScopeConfigInterface $scopeConfig,
    ) {
    }

    public function isIndexerHistoryCronEnabled(): bool
    {
        return (bool)$this->scopeConfig->isSetFlag(self::XML_PATH_CRON_ENABLE);
    }
}
