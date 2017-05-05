<?php
namespace SafoorSafdar\AuthorizeNet\Cim\Action;

use Payum\Core\Action\GatewayAwareAction;
use Payum\Core\ApiAwareInterface;
use Payum\Core\Exception\UnsupportedApiException;
use Payum\Core\Request\Capture;
use SafoorSafdar\AuthorizeNet\Cim\Bridge\AuthorizeNet\AuthorizeNetCIM;

class CaptureAction extends GatewayAwareAction implements ApiAwareInterface
{
    /**
     * @var AuthorizeNetAIM
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
     * @param Capture $request
     */
    public function execute($request)
    {

    }

    /**
     * {@inheritDoc}
     */
    public function supports($request)
    {
        return
            $request instanceof Capture
            && $request->getModel() instanceof \ArrayAccess;
    }
}
