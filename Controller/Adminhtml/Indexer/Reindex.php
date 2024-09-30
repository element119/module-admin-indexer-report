<?php
/**
 * Copyright © element119. All rights reserved.
 * See LICENCE.txt for licence details.
 */
declare(strict_types=1);

namespace Element119\AdminIndexerReport\Controller\Adminhtml\Indexer;

use Element119\AdminIndexerReport\Api\Data\AdminReindexLogInterface;
use Element119\AdminIndexerReport\Api\Data\AdminReindexLogInterfaceFactory;
use Element119\AdminIndexerReport\Api\AdminReindexLogRepositoryInterface;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\Auth\Session as AdminSession;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Indexer\IndexerRegistry;
use Psr\Log\LoggerInterface;

class Reindex extends Action
{
    public const ADMIN_RESOURCE = 'Element119_AdminIndexerReport::reindex_data';

    public function __construct(
        private readonly Context $context,
        private readonly AdminReindexLogInterfaceFactory $adminReindexLogFactory,
        private readonly AdminReindexLogRepositoryInterface $adminReindexLogRepository,
        private readonly AdminSession $adminSession,
        private readonly IndexerRegistry $indexerRegistry,
        private readonly LoggerInterface $logger,
    ) {
        parent::__construct($context);
    }

    public function execute(): void
    {
        $indexers = $this->getRequest()->getParam('indexer_ids');
        $successfullyReindexed = [];
        $unsuccessfullyReindexed = [];

        if (!$indexers) {
            $this->messageManager->addErrorMessage(__('Please select indexer(s).'));
        }

        foreach ($indexers as $indexer) {
            $indexer = $this->indexerRegistry->get($indexer);

            try {
                $indexer?->reindexAll();
                $successfullyReindexed[] = $indexer->getId();
                $this->messageManager->addSuccessMessage(
                    __('%1 data successfully reindexed.', $indexer->getTitle())
                );
            } catch (\Exception $e) {
                $unsuccessfullyReindexed[] = $indexer->getId();
                $this->messageManager->addErrorMessage(__(
                    'An error occurred when reindexing the %1 indexer: %2',
                    $indexer->getTitle(),
                    $e->getMessage()
                ));
            }
        }

        try {
            /** @var AdminReindexLogInterface $adminReindexLog */
            $adminReindexLog = $this->adminReindexLogFactory->create();
            $adminReindexLog->setAdminId($this->adminSession->getUser()->getId());
            $adminReindexLog->setSuccessfulIndexers(implode(',', $successfullyReindexed));
            $adminReindexLog->setUnsuccessfulIndexers(implode(',', $unsuccessfullyReindexed));
            $this->adminReindexLogRepository->save($adminReindexLog);
        } catch (CouldNotSaveException $e) {
            $this->logger->error(sprintf('Could not save admin reindex log: %s', $e->getMessage()));
        }

        $this->_redirect('*/*/list');
    }
}
