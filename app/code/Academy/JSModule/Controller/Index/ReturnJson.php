<?php

namespace Academy\JSModule\Controller\Index;

use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\JsonFactory;

class ReturnJson implements ActionInterface
{

    private $resultJsonFactory;
    private RequestInterface $request;

    public function __construct(JsonFactory $resultJsonFactory, Context $context, RequestInterface $request)
    {
        $this->resultJsonFactory = $resultJsonFactory;
        $this->request = $request;
    }

    public function execute()
    {
        $params = $this->request->getParams();

        $data = json_encode($params);


        $resultJson = $this->resultJsonFactory->create();
        return $resultJson->setData($data);

    }
}
