<?php

/**
 * 模板类
 * @copyright   Copyright(c) 2011
 * @author      yuansir <yuansir@live.cn/yuansir-web.com>
 * @version     1.0
 */
final class Template {
        public $template_name = null;
        public $data = array();
        public $out_put = null;
        
        public function init($template_name,$data = array()) {
                $this->template_name = $template_name;
                $this->data = $data;
                $this->fetch();
        }
        /**
         * 加载模板文件
         * @access      public
         * @param       string  $file
         */
        public function fetch() {
                $view_file = VIEW_PATH . '/' . $this->template_name . '.php';
                if (file_exists($view_file)) {
                        extract($this->data);
                        ob_start();
                        include $view_file;
                        $content = ob_get_contents();
                        ob_end_clean();
                        $this->out_put =  $content;
                } else {
                        trigger_error('加载 ' . $view_file . ' 模板不存在');
                }
        }
        /**
         * 输出模板
         * @access      public  
         * @return      string
         */
        public function outPut(){
                echo $this->out_put;
        }
        /**
         * 写入静态化文件
         * @access      public  
         */
//        public function toHtml() {
//                if (!is_dir(ROOT_PATH . '/cache/template/')) {
//                        mkdir(ROOT_PATH . '/cache/template/', 0777);
//                }
//                if (!$fp = @fopen(ROOT_PATH . '/cache/template/' . $filename . '.html', 'w')) {
//                        trigger_error('文件 ' . ROOT_PATH . '/cache/template/' . $filename . '.html' . ' 不能打开');
//                }
//                if (fwrite($fp, $content) == FALSE) {
//                        trigger_error('文件 ' . ROOT_PATH . '/cache/template/' . $filename . '.html' . ' 写入失败');
//                }
//                fclose($fp);
//        }

}

