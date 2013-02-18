<?php


namespace ePub\Definition;


class Chapter
{
    public $title;
    public $src;
    public $position;
    public $children;
    
    public function __construct($title, $pos, $src = null)
    {
        $this->title = str_replace(array("\n", "\r"), ' ', $title);
        $this->src = $src;
        $this->position = (int) $pos;
        $this->children = array();
    }
    
    
    public function addChild(Chapter $child)
    {
        $this->children[] = $child;
    }
}
