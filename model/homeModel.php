<?php
/**
 * 
 * @copyright   Copyright(c) 2011
 * @author      yuansir <yuansir@live.cn/yuansir-web.com>
 * @version     1.0
 */
class homeModel extends Model{
        function test(){
                echo "this is test homeModel";
        }
        
        function testResult(){
                $this->db->show_databases();
        }
}


