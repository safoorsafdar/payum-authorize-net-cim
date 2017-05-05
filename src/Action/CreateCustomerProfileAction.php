<?php
namespace SafoorSafdar\AuthorizeNet\Cim\Action;

use Payum\Core\Action\GatewayAwareAction;
use Payum\Core\ApiAwareInterface;

use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\Security\SensitiveValue;
use Payum\Core\Request\ObtainCreditCard;

use Payum\Core\Exception\UnsupportedApiException;
use Payum\Core\Exception\RequestNotSupportedException;
use Payum\Core\Exception\LogicException;

use SafoorSafdar\AuthorizeNet\Cim\Bridge\AuthorizeNet\AuthorizeNetCIM;
use SafoorSafdar\AuthorizeNet\Cim\Request\CreateCustomerProfile;
use SafoorSafdar\AuthorizeNet\Cim\Request\CreateCustomerPaymentProfile;

class CreateCustomerProfileAction extends GatewayAwareAction implements
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
     * @param CreateCustomerProfile $request
     */
    public function execute($request)
    {
        //ensure security measurement
        RequestNotSupportedException::assertSupports($this, $request);
        $model = ArrayObject::ensureArrayObject($request->getModel());

        $api   = clone $this->api;
        $api->setRefId('ref'.time());

        //$response = $api->createCustomerProfile($model->getArray('profile')->toUnsafeArray());
        $response = $api->createCustomerProfile(
            array(
                'merchantCustomerId' => '12345',
                'email' => 'user@example.com',
                'paymentProfiles' => array(
                    'customerType'=>"",
                    'billTo' => array(
                        'firstName' => "John",
                        'lastName' => 'Smith',
                        'address' => '123 Main Street',
                        'city' => 'Townsville',
                        'state' => 'NJ',
                        'zip' => '12345',
                        'phoneNumber' => '800-555-1234'
                    ),
                    'payment' => array(
                        'creditCard' => array(
                            'cardNumber' => '4111111111111111',
                            'expirationDate' => '2016-08',
                            'cardCode' => '321',
                        ),
                    ),
                ),
                'shipToList' => array(
                    'firstName' => 'John',
                    'lastName' => 'Smith',
                    'address' => '123 Main Street',
                    'city' => 'Townsville',
                    'state' => 'NJ',
                    'zip' => '12345',
                    'phoneNumber' => '800-555-1234'
                ),
            )
        );
        dd($response);
        /*$response = $api->createCustomerProfile([
            "merchantCustomerId" => time(),
            "description"        => "Profile description here",
            "email"              => "customer-profile-email321@here.com",
        ]);*/
        //if (($response != null) && ($response->isOk()) ){
        if (true){
            //$model['customerProfileId'] = $response->getCustomerProfileId();
            //$model['customerProfileId'] = "1500285326";
            //$obtainToken = new CreateCustomerPaymentProfile($request->getToken());
            //$obtainToken->setModel($model);
            //$this->gateway->execute($obtainToken);
        }

        //$model->replace(get_object_vars($response));
    }

    /**
     * {@inheritDoc}
     */
    public function supports($request)
    {
        return $request instanceof CreateCustomerProfile
        && $request->getModel() instanceof \ArrayAccess;
    }

}