<?php
namespace SafoorSafdar\AuthorizeNet\Cim\Model;
use Payum\Core\Exception\LogicException;
class CustomerProfileType extends
    \net\authorize\api\contract\v1\CustomerProfileType
{
    /**
     * @param array   $required
     * @param boolean $throwOnInvalid
     *
     * @throws LogicException when one of the required fields is empty
     *
     * @return bool
     */
    public function validateNotEmpty($required, $throwOnInvalid = true)
    {
        $required = is_array($required) ? $required : array($required);

        $empty = array();

        foreach ($required as $r) {
            $value = $this[$r];

            if (empty($value)) {
                $empty[] = $r;
            }
        }

        if ($empty && $throwOnInvalid) {
            throw new LogicException(sprintf('The %s fields are required.',
                implode(', ', $empty)));
        }

        if ($empty) {
            return false;
        }

        return true;
    }
}