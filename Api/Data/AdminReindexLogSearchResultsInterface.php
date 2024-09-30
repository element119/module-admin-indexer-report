<?php
/**
 * Copyright © element119. All rights reserved.
 * See LICENCE.txt for licence details.
 */
declare(strict_types=1);

namespace Element119\AdminIndexerReport\Api\Data;

use Element119\AdminIndexerReport\Api\Data\AdminReindexLogInterface;
use Magento\Framework\Api\SearchResultsInterface;

interface AdminReindexLogSearchResultsInterface extends SearchResultsInterface
{
    /**
     * @return AdminReindexLogInterface[]
     */
    public function getItems(): array;

    /**
     * @param AdminReindexLogInterface[] $items
     * @return self
     */
    public function setItems(array $items): self;
}
