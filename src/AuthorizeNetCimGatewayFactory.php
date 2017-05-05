<?php
namespace SafoorSafdar\AuthorizeNet\Cim;

#Actions
use SafoorSafdar\AuthorizeNet\Cim\Action\GetCustomerProfileAction;
use SafoorSafdar\AuthorizeNet\Cim\Action\CreateCustomerProfileAction;
use SafoorSafdar\AuthorizeNet\Cim\Action\CreateCustomerPaymentProfileAction;
#Bridge
use SafoorSafdar\AuthorizeNet\Cim\Bridge\AuthorizeNet\AuthorizeNetCIM;
#Core
use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\GatewayFactory;

class AuthorizeNetCimGatewayFactory extends GatewayFactory
{
    /**
     * {@inheritDoc}
     */
    protected function populateConfig(ArrayObject $config)
    {
        if ( ! class_exists(\AuthorizeNetCIM::class)) {
            throw new \LogicException('You must install "authorizenet/authorizenet" library.');
        }

        $config->defaults(array(
            'payum.factory_name'                   => 'authorize_net_cim',
            'payum.factory_title'                  => 'Authorize.NET CIM',
            //need to organize according to Authorize.NET CIM
            'payum.action.get_customer_profile'    => new GetCustomerProfileAction(),
            'payum.action.create_customer_profile' => new CreateCustomerProfileAction(),
            'payum.action.create_customer_payment_profile' => new CreateCustomerPaymentProfileAction(),
        ));

        if (false == $config['payum.api']) {
            $config['payum.default_options'] = array(
                'login_id'        => '',
                'transaction_key' => '',
                'sandbox'         => true,
            );
            $config->defaults($config['payum.default_options']);
            $config['payum.required_options'] = array(
                'login_id',
                'transaction_key',
            );

            $config['payum.api'] = function (ArrayObject $config) {
                $config->validateNotEmpty($config['payum.required_options']);
                $api = new AuthorizeNetCIM($config['login_id'],
                    $config['transaction_key']);
                $api->setSandbox($config['sandbox']);

                return $api;
            };
        }
    }
}
