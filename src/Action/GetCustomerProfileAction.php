<?php
namespace SafoorSafdar\AuthorizeNet\Cim\Action;

use Payum\Core\Action\GatewayAwareAction;
use Payum\Core\ApiAwareInterface;

use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\Exception\UnsupportedApiException;
use Payum\Core\Exception\RequestNotSupportedException;

use SafoorSafdar\AuthorizeNet\Cim\Bridge\AuthorizeNet\AuthorizeNetCIM;
use SafoorSafdar\AuthorizeNet\Cim\Request\GetCustomerProfile;

use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;

class GetCustomerProfileAction extends GatewayAwareAction implements
    ApiAwareInterface
{
    /**
     * @var AuthorizeNetCIM
     */
    protected $api;

    /**
     * {@inheritDoc}
     */
    public function setApi($api)
    {
        if (false == $api instanceof AuthorizeNetCIM) {
            throw new UnsupportedApiException('Not supported.');
        }
        $this->api = $api;
    }

    /**
     * {@inheritDoc}
     *
     * @param GetCustomerProfile $request
     */
    public function execute($request)
    {
        RequestNotSupportedException::assertSupports($this, $request);
        $model    = ArrayObject::ensureArrayObject($request->getModel());
        $response = $this->api->getCustomerProfile($model->get('customer_id'));
        //$response = $this->api->getCustomerProfileIds();
        if ($response->isOk()) {
            $model->replace(get_object_vars($response->xml));
        }
        if($response->isError()){
            return $response->getErrorMessage();
        }
    }

    /**
     * {@inheritDoc}
     */
    public function supports($request)
    {
        return $request instanceof GetCustomerProfile;
        //&& $request->getModel() instanceof \ArrayAccess;
    }

}