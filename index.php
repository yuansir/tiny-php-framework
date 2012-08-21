<?php
/**
 * 应用入口文件
 * @copyright   Copyright(c) 2011
 * @author      yuansir <yuansir@live.cn/yuansir-web.com>
 * @version     1.0
 */
require dirname(__FILE__).'/system/app.php';
require dirname(__FILE__).'/config/config.php';
Application::run($CONFIG);



