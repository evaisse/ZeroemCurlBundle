<?php

/*
 * (c) Darrell Hamilton <darrell.noice@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zeroem\CurlBundle\Curl;

/**
 * A service class for generating Curl\Request objects with an initial
 * set of CURLOPT_* options set
 */
class RequestGenerator
{
    private $options=array();

    public function __construct(array $options=array()) {
        foreach($options as $token=>$value) {
            if(is_string($token)) {
                $token = constant($token);
            }

            $this->addOption($token,$value);
        }
    }

    /**
     * Add an option to be applied to all Request objects
     * generated by this object
     *
     * @param int $token cURL option constant
     * @param mixed $value the cURL option value
     * @return $this
     */
    public function addOption($token, $value) {
        $this->options[$token] = $value;
        return $this;
    }

    /**
     * Remove an option from the list of options to be applied to
     * all request objects generated by this object
     *
     * @param mixed $value the cURL option value
     * @return mixed the value the option was set to or false 
     *               if the option was not set
     */
    public function removeOption($token) {
        $result = false;

        if(array_key_exists($token, $this->options)) {
            $result = $this->options[$token];
            unset($this->options[$token]);
        }

        return $result;
    }

    /**
     * Generate a Request object with preset options
     *
     * @return Request a cURL Request object
     */
    public function getRequest() {
        $request = new Request();

        $request->setOptionArray($this->options);

        return $request;
    }
}
