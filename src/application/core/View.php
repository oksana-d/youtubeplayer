<?php
namespace src\application\core;

class View
{
    public function generate($content_view, $template_view, $data = null)
    {
        if(is_array($data)) {
            extract($data);
        }

        include 'src/application/views/'.$template_view;
    }

    public function ajaxGenerate($content_view, $data = null)
    {
        if(is_array($data)) {
            extract($data);
        }

        include 'src/application/views/'.$content_view;
    }
}