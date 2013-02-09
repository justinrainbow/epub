<?php


namespace ePub\Definition;

use ePub\Definition\Chapter;


class Navigation
{
    public $src;
    
    /**
     * Array of Chapters
     *
     * @var array
     */
    public $chapters;
    
    
    public function __construct()
    {
        $this->src = new ManifestItem();
        $this->chapters = array();
    }
}
