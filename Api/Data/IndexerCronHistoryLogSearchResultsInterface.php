<?php
/**
 * Copyright © element119. All rights reserved.
 * See LICENCE.txt for licence details.
 */
declare(strict_types=1);

namespace Element119\AdminIndexerReport\Api\Data;

use Element119\AdminIndexerReport\Api\Data\IndexerCronHistoryLogInterface;
use Magento\Framework\Api\SearchResultsInterface;

interface IndexerCronHistoryLogSearchResultsInterface extends SearchResultsInterface
{
    /**
     * @return IndexerCronHistoryLogInterface[]
     */
    public function getItems(): array;

    /**
     * @param IndexerCronHistoryLogInterface[] $items
     * @return self
     */
    public function setItems(array $items): self;
}
