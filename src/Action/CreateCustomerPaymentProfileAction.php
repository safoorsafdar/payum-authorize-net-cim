<?php
namespace SafoorSafdar\AuthorizeNet\Cim\Action;

use Payum\Core\Action\GatewayAwareAction;
use Payum\Core\ApiAwareInterface;
use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\Exception\UnsupportedApiException;
use Payum\Core\Exception\RequestNotSupportedException;

use SafoorSafdar\AuthorizeNet\Cim\Bridge\AuthorizeNet\AuthorizeNetCIM;
use SafoorSafdar\AuthorizeNet\Cim\Request\CreateCustomerPaymentProfile;

class CreateCustomerPaymentProfileAction extends GatewayAwareAction implements
    ApiAwareInterface
{
    /**
     * @var AuthorizeNetAuthentication
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
     * @param CreateCustomerPaymentProfile $request
     */
    public function execute($request)
    {
        RequestNotSupportedException::assertSupports($this, $request);
        $model = ArrayObject::ensureArrayObject($request->getModel());
        $api   = clone $this->api;
        $api->setRefId('ref'.time());
        $response
            = $api->createCustomerPaymentProfile($model->get('customerProfileId'),
            [
                'billTo'  => [],
                'payment' => [
                    /*'creditCard' => [
                        'cardNumber'     => 4111111111111111,
                        'expirationDate' => "2023-12",
                        'cardCode'       => "321",
                    ],*/
                ],
            ]);
        dd($response);

        if (($response != null) && ($response->isOk())) {
            $model->replace(get_object_vars($response));
        }
    }

    /**
     * {@inheritDoc}
     */
    public function supports($request)
    {
        return $request instanceof CreateCustomerPaymentProfile
        && $request->getModel() instanceof \ArrayAccess;
    }
}