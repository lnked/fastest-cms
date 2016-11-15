<?php declare(strict_types = 1);

class Initialize extends templateEngine
{
    use Tools, Singleton;

    protected $request  = null;
    protected $locale   = null;
    
    protected $template = null;
    protected $template_dir = null;
    protected $template_driver = null;

    protected $is_admin   = false;
    protected $csrf_token = null;
    protected $csrf_param = 'authenticity_token';

    protected $controller = null;
    protected $action = null;
    protected $params = null;

    public $domain  = null;
    public $path    = [];
    public $page    = ['id' => 0];

    public function __construct()
    {
        $this->domain   = $_SERVER['HTTP_HOST'];
        $this->request  = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
        $this->path     = preg_split('/\/+/', $this->request, -1, PREG_SPLIT_NO_EMPTY);
        $this->locale   = $this->getLocale($this->request, $this->path);
        $this->tpath    = $this->path;

        $this->checkAdmin();
        $this->initTemplate();

        $this->csrf();
    }

    protected function initMVC()
    {
        if ($this->is_admin)
        {
            array_shift($this->tpath);
        }

        if (isset($this->tpath[0]))
        {
            $this->controller = $this->tpath[0];
        }

        if (isset($this->tpath[1]))
        {
            $this->action = $this->tpath[1];
        }

        if (count($this->tpath) > 2)
        {
            $this->params = array_slice($this->tpath, 2, count($this->tpath));
        }
    }
    
    protected function initHooks()
    {
        if ($this->controller == CAPTCHA_URL)
        {
            return new Captcha();
        }
    }

    protected static function headers($cache = false)
    {
        header("Last-Modified: " . gmdate('D, d M Y H:i:s', (time() - 3600)) . " GMT");
        header("Cache-control: public");
        
        if ($cache)
        {
            header("Cache-control: max-age=31536000");
        }
        else
        {
            header("Strict-Transport-Security: max-age=31536000");
            header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0, post-check=0, pre-check=0');
            header("Pragma: no-cache");
            header("Expires: " . date("r", time() + 2592000));
    
            // header("Cache-Control: no-cache, must-revalidate");
            // header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Дата в прошлом
        }

        if (extension_loaded('zlib') && (!defined('GZIP_COMPRESS') || defined('GZIP_COMPRESS') && GZIP_COMPRESS))
        {
            ini_set("zlib.output_compression", "On");
            ini_set('zlib.output_compression_level', "7");
        }
    }

    private function initTemplate()
    {
        if ($this->is_admin)
        {
            $this->template_dir = PATH_BACKEND;
            $this->template_driver = TEMPLATING_BACKEND;
        }
        else
        {
            $this->template_dir = PATH_FRONTEND;
            $this->template_driver = TEMPLATING_FRONTEND;
        }
        
        $this->template = new templateEngine($this->template_driver, $this->template_dir);

        if ($this->is_admin)
        {
            $this->template->assign('ADMIN_DIR', ADMIN_DIR);
        }
    }

    private function csrf()
    {
        if (!count($_POST) && defined('CSRF_PROTECTION') && CSRF_PROTECTION)
        {
            unset($_SESSION['csrf_param']);
            unset($_SESSION[$this->csrf_param]);
            
            if (empty($_SESSION[$this->csrf_param]))
            {
                if (function_exists('mcrypt_create_iv'))
                {
                    $token = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
                }
                else
                {
                    $token = bin2hex(openssl_random_pseudo_bytes(32));
                }

                $_SESSION['csrf_param'] = $this->csrf_param;
                $_SESSION[$this->csrf_param] = base64_encode($token);
            }

            $this->csrf_token = $_SESSION[$this->csrf_param];
        }
    }

    private function checkAdmin()
    {
        $this->is_admin = isset($this->path[0]) && $this->path[0] == ADMIN_DIR;
    }
}