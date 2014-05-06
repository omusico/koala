<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   Lunnlew <Lunnlew@gmail.com>
 */
/**
 * ServiceProvider 
 *
 * 处理基于请求数据和响应行为的逻辑服务提供类
 */
class ServiceProvider{
    /**
     * 包含请求数据和请求行为的请求实例
     *
     * @var Request
     * @access protected
     */
    protected $request;

    /**
     * 包含响应数据和响应行为的响应实例
     *
     * @var Response
     * @access protected
     */
    protected $response;

    /**
     * 当前请求的PHP SESSION ID
     *
     * @var string
     * @access protected
     */
    protected $session_id;

    /**
     * 视图布局文件
     *
     * @var string
     * @access protected
     */
    protected $layout;

    /**
     * 视图文件
     *
     * @var string
     * @access protected
     */
    protected $view;

    /**
     * 数据搜集
     *
     * @var DataCollection\DataCollection
     * @access protected
     */
    protected $shared_data;

    /**
     * 构造器
     *
     * @param Request $request              包含所有请求数据和请求行为的请求对象
     * @param AbstractResponse $response    包含所有响应数据和响应行为的响应对象
     * @access public
     */
    public function __construct(Request $request = null, AbstractResponse $response = null)
    {
        //绑定数据对象
        $this->bind($request, $response);
        //实例化数据搜集器
        $this->shared_data = Collection::factory('data');
    }

    /**
     * 绑定对象数据到当前服务
     *
     * @@param Request $request              包含所有请求数据和请求行为的请求对象
     * @param AbstractResponse $response    包含所有响应数据和响应行为的响应对象
     * @access public
     * @return ServiceProvider
     */
    public function bind(Request $request = null, AbstractResponse $response = null)
    {
        // Keep references
        $this->request  = $request  ?: $this->request;
        $this->response = $response ?: $this->response;

        return $this;
    }

    /**
     * 返回搜集器对象
     *
     * @access public
     * @return DataCollection\DataCollection
     */
    public function sharedData()
    {
        return $this->shared_data;
    }

    /**
     * 获取当前session id
     *
     * 如果session id 为null则会启动session
     *
     * @access public
     * @return string|false
     */
    public function startSession()
    {
        if (session_id() === '') {
            //尝试启动会话
            session_start();
            $this->session_id = session_id() ?: false;
        }
        return $this->session_id;
    }

    /**
     * 存放$type类型的紧急信息
     *
     * @param string $msg       紧急信息
     * @param string $type      紧急类型
     * @param array $params     markdown格式的可解析参数
     * @access public
     * @return void
     */
    public function flash($msg, $type = 'info', $params = null)
    {
        $this->startSession();
        if (is_array($type)) {
            $params = $type;
            $type = 'info';
        }
        if (!isset($_SESSION['__flashes'])) {
            $_SESSION['__flashes'] = array($type => array());
        } elseif (!isset($_SESSION['__flashes'][$type])) {
            $_SESSION['__flashes'][$type] = array();
        }
        $_SESSION['__flashes'][$type][] = $this->markdown($msg, $params);
    }

    /**
     * 返回并清空$type类型的紧急信息
     *
     * @param string $type  紧急类型
     * @access public
     * @return array
     */
    public function flashes($type = null)
    {
        $this->startSession();
        if (!isset($_SESSION['__flashes'])) {
            return array();
        }
        if (null === $type) {
            $flashes = $_SESSION['__flashes'];
            unset($_SESSION['__flashes']);
        } elseif (null !== $type) {
            $flashes = array();
            if (isset($_SESSION['__flashes'][$type])) {
                $flashes = $_SESSION['__flashes'][$type];
                unset($_SESSION['__flashes'][$type]);
            }
        }
        return $flashes;
    }

    /**
     * 渲染markdown文本
     *
     * 
     * @param string $str   需要解析的文本
     * @param array $args   markdown文本中需替换的参数
     * @static
     * @access public
     * @return string
     */
    public static function markdown($str, $args = null)
    {
        // 分析正则
        $md = array(
            '/\[([^\]]++)\]\(([^\)]++)\)/' => '<a href="$2">$1</a>',
            '/\*\*([^\*]++)\*\*/'          => '<strong>$1</strong>',
            '/\*([^\*]++)\*/'              => '<em>$1</em>'
        );
        $args = func_get_args();
        $str = array_shift($args);
        if (isset($args[0]) && is_array($args[0])) {
            $args = $args[0];
        }

        //编码以便于插入html中
        foreach ($args as &$arg) {
            $arg = htmlentities($arg, ENT_QUOTES, 'UTF-8');
        }
        return vsprintf(preg_replace(array_keys($md), $md, $str), $args);
    }

    /**
     * 忽略无法被utf-8识别的字符
     *
     * @param string $str   要处理得字符串
     * @param int $flags    兼容htmlentities()的flags参数
     * @static
     * @access public
     * @return string
     */
    public static function escape($str, $flags = ENT_QUOTES)
    {
        return htmlentities($str, $flags, 'UTF-8');
    }

    /**
     * 重新请求当前
     *
     * @access public
     * @return ServiceProvider
     */
    public function refresh()
    {
        $this->response->redirect(
            $this->request->uri()
        );

        return $this;
    }

    /**
     * 返回上一个请求
     *
     * @access public
     * @return ServiceProvider
     */
    public function back()
    {
        $referer = $this->request->server()->get('HTTP_REFERER');

        if (null !== $referer) {
            return $this->response->redirect($referer);
        }

        $this->refresh();

        return $this;
    }

    /**
     * 获取或者设置视图布局
     *
     * @param string $layout    视图布局
     * @access public
     * @return string|ServiceProvider
     */
    public function layout($layout = null)
    {
        if (null !== $layout) {
            $this->layout = $layout;

            return $this;
        }

        return $this->layout;
    }

    /**
     * 渲染当前视图
     *
     * @access public
     * @return void
     */
    public function yieldView()
    {
        require $this->view;
    }

    /**
     * 渲染视图和布局
     *
     * @param string $view  要渲染的视图
     * @param array $data   视图数据
     * @access public
     * @return void
     */
    public function render($view, array $data = array())
    {
        $original_view = $this->view;

        if (!empty($data)) {
            $this->shared_data->merge($data);
        }

        $this->view = $view;

        if (null === $this->layout) {
            $this->yieldView();
        } else {
            require $this->layout;
        }

        if (false !== $this->response->chunked) {
            $this->response->chunk();
        }
        //复原父render()状态
        $this->view = $original_view;
    }

    /**
     * 渲染无布局视图
     *
     * @param string $view  要渲染的视图
     * @param array $data   视图数据
     * @access public
     * @return void
     */
    public function partial($view, array $data = array())
    {
        $layout = $this->layout;
        $this->layout = null;
        $this->render($view, $data);
        $this->layout = $layout;
    }

    /**
     * 增加自定义校验方法
     *
     * @param string $method        校验器方法名
     * @param callable $callback    回调内容
     * @access public
     * @return void
     */
    public function addValidator($method, $callback)
    {
        Validator::addValidator($method, $callback);
    }

    /**
     * 为字符串开启校验
     *
     * @param string $string    要校验的字符串
     * @param string $err       自定义错误
     * @access public
     * @return Validator
     */
    public function validate($string, $err = null)
    {
        return new Validator($string, $err);
    }

    /**
     * 针对请求参数的校验
     *
     * @param string $param     要校验的参数名
     * @param string $err       自定义错误
     * @access public
     * @return Validator
     */
    public function validateParam($param, $err = null)
    {
        return $this->validate($this->request->param($param), $err);
    }


    /**
     * 魔术方法 "__isset" 
     *
     * @param string $key     数据字段名
     * @access public
     * @return boolean
     */
    public function __isset($key)
    {
        return $this->shared_data->exists($key);
    }

    /**
     * 魔术方法 "__get" 
     *
     * @param string $key     数据字段名
     * @access public
     * @return string
     */
    public function __get($key)
    {
        return $this->shared_data->get($key);
    }

    /**
     * 魔术方法 "__set" 
     *
     *
     * @param string $key    数据字段名
     * @param mixed $value    数据值
     * @access public
     * @return void
     */
    public function __set($key, $value)
    {
        $this->shared_data->set($key, $value);
    }

    /**
     * 魔术方法 "__unset"
     *
     * @param string $key     数据字段名
     * @access public
     * @return void
     */
    public function __unset($key)
    {
        $this->shared_data->remove($key);
    }
}
