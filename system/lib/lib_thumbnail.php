<?php
/**
 * 生成缩略图(支持加载图片文件和字符串2种方式)
 * @param       $maxWidth       缩略图最大宽度
 * @param       $maxHeight      缩略图最大高度
 * @param       bool    $scale  是否按比例缩小，否则拉伸
 * @param       bool    $inflate        是否放大以来填充缩略图
 */
class Thumbnail {
 
        private $maxWidth;
        private $maxHeight;
        private $scale;
        private $inflate;
        private $types;
        private $imgLoaders;
        private $imgCreators;
        private $source;
        private $sourceWidth;
        private $sourceHeight;
        private $sourceMime;
        private $thumb;
        private $thumbWidth;
        private $thumbHeight;
        /**
         * 初始化
         * @param string $maxWidth      最大缩略宽度
         * @param string $maxHeight     最大缩略高度
         * @param type $scale
         * @param type $inflate 
         */
        public function init($maxWidth, $maxHeight, $scale = true, $inflate = true) {
                $this->maxWidth = $maxWidth;
                $this->maxHeight = $maxHeight;
                $this->scale = $scale;
                $this->inflate = $inflate;
                $this->types = array(
                    'image/jpeg',
                    'image/png',
                    'image/gif'
                );
                //加载MIME类型图像的函数名称
                $this->imgLoaders = array(
                    'image/jpeg'        =>      'imagecreatefromjpeg',
                    'image/png'         =>      'imagecreatefrompng',
                    'image/gif'         =>      'imagecreatefromgif'
                );
                //储存创建MIME类型图片的函数名称
                $this->imgCreators = array(
                    'image/jpeg'        =>      'imagejpeg',
                    'image/png'         =>      'imagepng',
                    'image/gif'         =>      'imagegif'
                );
        }
        /**
         * 文件方式加载图片
         * @param       string  $image 源图片
         * @return      bool
         */
        public function loadFile($image){
                if(!$dims = @getimagesize($image)){
                        trigger_error("源图片不存在");
                }
                if(in_array($dims['mime'], $this->types)){
                        $loader = $this->imgLoaders[$dims['mime']];
                        $this->source = $loader($image);
                        $this->sourceWidth = $dims[0];
                        $this->sourceHeight = $dims[1];
                        $this->sourceMime = $dims['mime'];
                        $this->initThumb();
                        return TRUE;
                }else{
                        trigger_error('不支持'.$dims['mime']."图片类型");
                }
        }
        /**
         * 字符串方式加载图片
         * @param       string $image  字符串
         * @param       string $mime    图片类型
         * @return type
         */
        public function loadData($image,$mime){
                if(in_array($mime, $this->types)){
                        if($this->source = @imagecreatefromstring($image)){
                                $this->sourceWidth = imagesx($this->source);
                                $this->sourceHeight = imagesy($this->source);
                                $this->sourceMime = $mime;
                                $this->initThumb();
                                return TRUE;
                        }else{
                                trigger_error("不能从字符串加载图片");
                        }
                }else{
                        trigger_error("不支持".$mime."图片格式");
                }
        }
        /**
         * 生成缩略图
         * @param       string  $file   文件名。如果不为空则储存为文件，否则直接输出到浏览器
         */
        public function buildThumb($file = null){
                $creator = $this->imgCreators[$this->sourceMime];
                if(isset($file)){
                        return $creator($this->thumb,$file);
                }else{
                        return $creator($this->thumb);
                }
        }
        /**
         * @access      public
         */
        public function initThumb(){
                if($this->scale){
                        if($this->sourceWidth > $this->sourceHeight){
                                $this->thumbWidth = $this->maxWidth;
                                $this->thumbHeight = floor($this->sourceHeight*($this->maxWidth/$this->sourceWidth));
                        }elseif($this->sourceWidth < $this->sourceHeight){
                                $this->thumbHeight = $this->maxHeight;
                                $this->thumbWidth = floor($this->sourceWidth*($this->maxHeight/$this->sourceHeight));
                        }else{
                                $this->thumbWidth = $this->maxWidth;
                                $this->thumbHeight = $this->maxHeight;
                        }
                }
                $this->thumb = imagecreatetruecolor($this->thumbWidth, $this->thumbHeight);
 
                if($this->sourceWidth <= $this->maxWidth && $this->sourceHeight <= $this->maxHeight && $this->inflate == FALSE){
                        $this->thumb = $this->source;
                }else{
                        imagecopyresampled($this->thumb, $this->source, 0, 0, 0, 0, $this->thumbWidth, $this->thumbHeight, $this->sourceWidth, $this->sourceHeight);
                }
        }
 
        public function getMine(){
                return $this->sourceMime;
        }
 
        public function getThumbWidth(){
                return $this->thumbWidth;
        }
 
        public function getThumbHeight(){
                return $this->thumbHeight;
        }
 
}
 
/**
 * 缩略图类调用示例(文件)
 */
//$thumb = new Thumbnail(200, 200);
//$thumb->loadFile('wap.gif');
//header('Content-Type:'.$thumb->getMine());
//$thumb->buildThumb();
///**
// * 缩略图类调用示例(字符串)
// */
//$thumb = new Thumbnail(200, 200);
//$image = file_get_contents('wap.gif');
//$thumb->loadData($image, 'image/jpeg');
//$thumb->buildThumb('wap_thumb.gif');