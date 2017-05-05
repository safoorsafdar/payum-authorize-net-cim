<?php
namespace SafoorSafdar\AuthorizeNet\Cim\Bridge\AuthorizeNet;

// this is a fix of crappy auto loading in authorize.net lib.
class_exists('AuthorizeNetException', true);

class AuthorizeNetCIM extends \AuthorizeNetCIM
{
    public function getLoginID()
    {
        return $this->_api_login;
    }

    public function getTransactionKey()
    {
        return $this->_transaction_key;
    }

    public function setLoginID($value)
    {
        return $this->_api_login;
    }

    public function setTransactionKey($value)
    {
        return $this->_transaction_key;
    }
}
