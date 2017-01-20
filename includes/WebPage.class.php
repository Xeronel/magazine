<?php
/**
 * WebPage object
 */
class WebPage
{
    public $page;
    public $views;

    function __construct($page, $views)
    {
        $this->page = $page;
        $this->views = $views;
    }
}

?>
