# yaf-skeleton

常用功能和一些的类库

## Yaf的php.ini配置

因为本项目未使用命名空间，所以在php.ini里配置上

	[yaf]
	extension=yaf.so
	yaf.use_namespace = 0


## 项目目录

	├── application           //应用目录
	│   ├── actions           //action目录
	│   ├── Bootstrap.php     //启动文件
	│   ├── controllers       //控制器目录
	│   ├── models            //数据库模型
	│   ├── Services.php      //依赖注入
	│   └── views             //视图文件目录
	├── composer.json
	├── composer.lock
	├── config
	│   ├── application.ini   //配置文件
	│   └── routes.php        //路由
	├── data
	│   ├── cache             //缓存目录
	│   ├── log               //日志存储目录
	│   ├── session           //session目录
	│   └── view              //视图文件缓存目录
	├── library               //核心库目录
	│   ├── ActionBase.php            //action基类
	│   ├── ControllerBase.php        //controller基类
	│   ├── Helpers.php               //功能函数
	│   └── ViewBase.php              //视图基类
	├── public
	│   ├── assets                    //静态文件
	│   ├── index.php                 //入口文件
	│   └── uploads                   //上传目录
	├── README.md
	└── vendor                        //composer脚手架目录
	    ├── autoload.php
	    ├── bin
	    ├── composer
	    ├── doctrine
	    ├── guzzlehttp
	    ├── illuminate
	    ├── league
	    ├── leeoniya
	    ├── monolog
	    ├── nesbot
	    ├── paragonie
	    ├── pimple
	    ├── psr
	    ├── symfony
	    ├── tracy
	    └── twig


## ActionBase基类

继承Yaf_Action_Abstract类，

包涵方法：

	$this->params($param = null, $defaultValue = null)

	$this->post($param = null, $defaultValue = null)

	$this->get($param = null, $defaultValue = null)

	$this->cookie($param = null, $defaultValue = null)

	$this->server($param = null, $defaultValue = null)

以及成员属性：

	$this->config，配置参数信息
	$this->request，请求信息
	$this->logger，日志记录
	$this->view，视图部分
	$this->di，依赖注入


## 数据库

使用`illuminate/database`,详细文档见：<http://d.laravel-china.org/docs/5.4/database>
