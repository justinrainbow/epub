<?php

namespace ePub\Resource;

use SimpleXMLElement;

class OpfResource
{
    private $xml;

    public function __construct($data)
    {
        if ($data instanceof SimpleXMLElement) {
        	$this->xml = $data;
        } else if (is_string($data)) {
        	$this->xml = simplexml_load_string($data);
        } else {
        	throw new \RuntimeException(sprintf('Invalid data type for OpfResource'));
        }
    }
}