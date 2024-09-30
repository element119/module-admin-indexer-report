<?php
/**
 * Copyright © element119. All rights reserved.
 * See LICENCE.txt for licence details.
 */
declare(strict_types=1);

namespace Element119\AdminIndexerReport\Controller\Adminhtml\Indexer;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Indexer\IndexerRegistry;

class Reindex extends Action
{
    public const ADMIN_RESOURCE = 'Element119_AdminIndexerReport::reindex_data';

    public function __construct(
        private readonly Context $context,
        private readonly IndexerRegistry $indexerRegistry,
    ) {
        parent::__construct($context);
    }

    public function execute(): void
    {
        $indexers = $this->getRequest()->getParam('indexer_ids');

        if (!$indexers) {
            $this->messageManager->addErrorMessage(__('Please select indexer(s).'));
        }

        foreach ($indexers as $indexer) {
            $indexer = $this->indexerRegistry->get($indexer);

            try {
                $indexer?->reindexAll();
                $this->messageManager->addSuccessMessage(
                    __('%1 data successfully reindexed.', $indexer->getTitle())
                );
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__(
                    'An error occurred when reindexing the %1 indexer: %2',
                    $indexer->getTitle(),
                    $e->getMessage()
                ));
            }
        }

        $this->_redirect('*/*/list');
    }
}
