<?php
/**
 * Copyright © element119. All rights reserved.
 * See LICENCE.txt for licence details.
 */
declare(strict_types=1);

namespace Element119\AdminIndexerReport\Block\Backend\Grid\Column\Renderer;

use Element119\AdminIndexerReport\Model\IndexerInfo;
use Magento\Backend\Block\Context;
use Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer;
use Magento\Framework\DataObject;

class BatchSize extends AbstractRenderer
{
    public function __construct(
        private readonly Context $context,
        private readonly IndexerInfo $indexerInfo,
        private readonly array $indexerBatchSizeClassMap = [],
        private readonly array $data = [],
    ) {
        parent::__construct($context, $data);
    }

    public function render(DataObject $row): string
    {
        $batchSize = $this->indexerInfo->getIndexerBatchSizeDeploymentConfig($row->getIndexerId());

        if (!$batchSize) {
            return $this->getIndexerBatchSize($row->getIndexerId());
        }

        if (is_array($batchSize)) {
            return $this->flattenBatchSizeArray($batchSize);
        }

        return $batchSize;
    }

    public function getIndexerBatchSize(string $indexer): string
    {
        $batchSize = '';

        if (array_key_exists($indexer, $this->indexerBatchSizeClassMap)
            && isset($this->indexerBatchSizeClassMap[$indexer]['object'])
            && isset($this->indexerBatchSizeClassMap[$indexer]['batchSizeKeyName'])
        ) {
            foreach ((array)$this->indexerBatchSizeClassMap[$indexer]['object'] as $key => $value) {
                if (str_contains($key, $this->indexerBatchSizeClassMap[$indexer]['batchSizeKeyName'])) {
                    $batchSize = $value;
                    break;
                }
            }
        }

        return is_array($batchSize)
            ? $this->flattenBatchSizeArray($batchSize)
            : $batchSize;
    }

    public function flattenBatchSizeArray(array $batchData): string
    {
        $batchSize = '';

        foreach ($batchData as $key => $value) {
            $batchSize .= $key . ': ' . $value . '<br>';
        }

        return $batchSize;
    }
}
