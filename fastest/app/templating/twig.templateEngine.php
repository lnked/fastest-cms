<?php

class templateRender extends Renderer
{
    // protected $extension = '.twig';

	public function __construct($templateDir = '')
	{
		$loader = new Twig_Loader_Filesystem($templateDir);

        // $loader->addPath(FASTEST_ROOT.PUBLIC_ROOT.DS.ADMIN_DIR.DS.'frontend'.DS);

        $this->template = new Twig_Environment($loader, [
        	'cache'             =>	PATH_RUNTIME,
            'debug'             => 	TEMPLATING_DEBUG,
            'auto_reload'       =>  FORCE_COMPILE,
            'autoescape'        => 	true,
            'strict_variables'  => 	false,
            'optimizations'     => 	true,
            'charset'           => 	$this->charset
        ]);

        $this->template->addExtension(new Twig_Extension_Escaper('html'));
        $this->template->addExtension(new Twig_Extension_Optimizer(Twig_NodeVisitor_Optimizer::OPTIMIZE_FOR));
        $this->template->addExtension(new Twig_Extension_Debug());

        $lexer = new Twig_Lexer($this->template, [
        	'tag_comment'   => ['{#', '#}'],
        	'tag_block'     => ['{%', '%}'],
        	'tag_variable'  => ['{{', '}}'],
        	'interpolation' => ['#{', '}'],
        ]);

        $this->template->setLexer($lexer);
	}

	public function assign($key = '', $data = '', $cache = false)
    {
		if (is_array($data) || is_object($data))
		{
		    $this->data[$key] = $data;
		}
		else
		{
		    $this->data[$key] = htmlspecialchars($data, ENT_QUOTES, $this->charset);
		}
    }

    public function fetch($template = '', $cache_id = '', $compile_id = '')
    {
        $twig = clone $this->template;
        $twig->setLoader(new Twig_Loader_String());

        if (file_exists($template . $this->extension))
        {
            $rendered = $twig->render(
                file_get_contents($template . $this->extension),
                $this->data
            );

            unset($twig);

            return $rendered;
        }
        else if (file_exists($template))
        {
            $rendered = $twig->render(
                file_get_contents($template),
                $this->data
            );

            unset($twig);

            return $rendered;
        }
    }

    public function display($template = '')
    {
        $this->template->addGlobal("session", $_SESSION);
  		$this->template->loadTemplate($template . $this->extension)->display($this->data);
    }
}