<?php


namespace View;


class View
{

    private $view;
    private $variables = array();

    public function __construct($view)
    {
        $this->view = $view;
    }

    public function __set($key, $variable)
    {
        $this->variables[$key] = $variable;
    }

    public function __get($key)
    {
        return $this->variables[$key];
    }

    public function __isset($key)
    {
        if (!array_key_exists($key, $this->variables))
            return false;
        return isset($this->variables[$key]);
    }

    public static function NoHTML($input, $bEncodeAll = true, $encoding = "UTF-8")
    {
        if ($bEncodeAll)
            return htmlentities($input, ENT_QUOTES | ENT_HTML5, $encoding);
        return htmlspecialchars($input, ENT_QUOTES | ENT_HTML5, $encoding);
    }

    public function Render()
    {
        extract($this->variables);
        ob_start();
        require($this->view);
        return ob_get_clean();
    }
}
