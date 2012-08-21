<?php
/**
 * 核心控制器类
 * @copyright   Copyright(c) 2011
 * @author      yuansir <yuansir@live.cn/yuansir-web.com>
 * @version     1.0
 */
class Model {
        protected $db = null;
        
        final public function __construct() {
                header('Content-type:text/html;chartset=utf-8');
                $this->db = $this->load('mysql'); 
                $config_db = $this->config('db');
                $this->db->init(
                        $config_db['db_host'],
                        $config_db['db_user'],
                        $config_db['db_password'],
                        $config_db['db_database'],
                        $config_db['db_conn'],
                        $config_db['db_charset']
                        );                                            //初始话数据库类
        }
        /**
         * 根据表前缀获取表名
         * @access      final   protected
         * @param       string  $table_name    表名
         */
        final protected function table($table_name){
                $config_db = $this->config('db');
                return $config_db['db_table_prefix'].$table_name;
        }
        /**
         * 加载类库
         * @param string $lib   类库名称
         * @param Bool  $my     如果FALSE默认加载系统自动加载的类库，如果为TRUE则加载自定义类库
         * @return type 
         */
        final protected function load($lib,$my = FALSE){
                if(empty($lib)){
                        trigger_error('加载类库名不能为空');
                }elseif($my === FALSE){
                        return Application::$_lib[$lib]; 
                }elseif($my === TRUE){
                        return  Application::newLib($lib);
                }
        }
        /**
         * 加载系统配置,默认为系统配置 $CONFIG['system'][$config]
         * @access      final   protected
         * @param       string  $config 配置名  
         */
        final   protected function config($config=''){
                return Application::$_config[$config];
        }
        
        
        

}


