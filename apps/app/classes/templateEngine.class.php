<?php declare(strict_types = 1);

# extends Data

class templateEngine
{
    protected $template = null;

    public function __construct($driver = 'smarty', $dir = '')
    {
        $driver = strtolower($driver);
        
        if (strstr($dir, '#'))
        {
            $dir = str_replace('#', $driver, $dir);
        }

        if (file_exists(PATH_DRIVERS.DS.$driver.'.templateEngine.php'))
        {
            if (!class_exists('templateRender'))
            {
                include PATH_DRIVERS.DS.$driver.'.templateEngine.php';

                $this->template = new templateRender($dir);
            }
        }
    }

    protected function assign($key = '', $value = '', $cache = false)
    {
        $this->template->assign($key, $value, $cache);
    }

    protected function fetch($template = '', $cache_id = '', $compile_id = '')
    {
        return $this->template->fetch($template);
    }

    protected function display($pattern = '')
    {
        if (DEV_MODE)
        {
            $cache = new Cache;
            $cache->clearMemory();
        }

        $this->template->display($pattern);
    }
}