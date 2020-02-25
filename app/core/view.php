<?php


class View
{
    const DEFAULT_VIEW_FILE = 'root.view.php';

    private $style_file;
    private $script_file;

    function __construct($style='', $script='')
    {
        $this->style_file = $style;
        $this->script_file = $script;
    }

    function show($content_view, $data = null, $template_view = self::DEFAULT_VIEW_FILE)
    {
        include VIEWS_DIR . '/' .$template_view;
    }
}