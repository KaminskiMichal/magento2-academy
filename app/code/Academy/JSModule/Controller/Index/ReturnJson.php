<?php

namespace Academy\JSModule\Controller\Index;

use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\EntityManager\EventManager;

class ReturnJson implements ActionInterface
{

    private $resultJsonFactory;
    private RequestInterface $request;
    private EventManager $eventManager;

    public function __construct(JsonFactory      $resultJsonFactory,
                                RequestInterface $request,
                                EventManager     $eventManager)
    {
        $this->resultJsonFactory = $resultJsonFactory;
        $this->request = $request;
        $this->eventManager = $eventManager;
    }

    public function execute()
    {
        $params = $this->request->getParams();


        $data = json_encode($params);

        $this->eventManager->dispatch('jsmodule_event', [$data]);

        $resultJson = $this->resultJsonFactory->create();
        return $resultJson->setData($data);
    }
}
