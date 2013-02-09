<?php


namespace ePub\Resource;

use SimpleXMLElement;
use ePub\Definition\Package;
use ePub\Definition\Chapter;


class NcxResource
{
    /**
     * @var \SimpleXMLElement
     */
    private $xml;
    
    /**
     * Array of XML namespaces found in document
     *
     * @var array
     */
    private $namespaces;

    /**
     * Constructor
     *
     * @param \SimpleXMLElement|string $data
     * @throws InvalidArgumentException
     */
    public function __construct($data)
    {
        if ($data instanceof SimpleXMLElement) {
            $this->xml = $data;
        } else if (is_string($data)) {
            $this->xml = new SimpleXMLElement($data);
        } else {
            throw new InvalidArgumentException(sprintf('Invalid data type for OpfResource'));
        }
        
        $this->namespaces = $this->xml->getNamespaces(true);
    }
    
    
    /**
     * Processes the XML data and puts the data into a Package object
     *
     * @param Package $package
     *
     * @return Package
     */
    public function bind(Package $package = null)
    {
        $package = $package ?: new Package();
        
        $navMap = $this->xml->navMap;
        
        $this->consumeNavMap($navMap, $package->navigation->chapters);
        
        return $package;
    }
    
    
    private function consumeNavMap($navMap, &$chapters)
    {
        foreach ($navMap->navPoint as $navPoint) {
            $chapters[] = $this->consumeNavPoint($navPoint);
        }
    }
    
    
    private function consumeNavPoint($navPoint)
    {
        $chapter = new Chapter((string) $navPoint->navLabel->text, $navPoint['playOrder'], (string) $navPoint->content['src']);
        
        foreach ($navPoint->navPoint as $child) {
            $chapter->addChild($this->consumeNavPoint($child));
        }
        
        return $chapter;
    }
    
}