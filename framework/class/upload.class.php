<?php
/**
 * 文件上传类
 */
class upload
{
    public $file_dir = '';    //上传的目录
    public $attachurl = '';    //附件访问地址
    public $type = 'editor';  //文件分类
    public $filetype = '';    //文件类型 如 jpg gif png
    public $basename = '';    //唯一文件名
    public $imgname = '';     //带基本目录的文件名
    public $fullname = '';    //带根目录的全文件名
    public $isimg = 1;        //是否是图片
    public $filesize = 0;     //文件大小
    public $thumb_enable = false;  //是否可缩略
    public $water_stats = false;  //是否添加水印
    public $datedir = '';
    public $resize_stats = true;
    public $filepost = array();
    public $resize_quality = 80;   //图片缩略质量
    public $im = 0;  //文件源
    public $allow_upload_types = ['jpg','gif','png','bmp','jpeg', 'xls', 'xlsx', 'doc', 'docx', 'ppt', 'rar', 'zip','pdf'];

    public function __construct( $filepost){
        if(empty($filepost)){
            exit('no images!');
        }

        $this->file_dir = IA_ROOT . '/uploads';
        $this->attachurl = '/uploads';
        $this->filepost = $filepost;
        $filetype = @end(explode('.',$filepost['name']));
        $this->filetype = strtolower($filetype);
        $this->basename = md5(TIMESTAMP.$filepost['name']);
        $this->isimg = in_array($this->filetype,array('jpg','gif','png','bmp','jpeg')) ? 1 : 0;
        $this->filesize = $filepost['size'];
    }
    /**
     * 生成文件名
     */
    public function ext_filename(){
        $nowdate = date('Y-m-d H:i:s', TIMESTAMP);
        $datedir = substr($nowdate, 0, 7).'/'.substr($nowdate, 8, 2);
        $file_dir = $this->file_dir . '/' . $datedir;
        if(!file_exists($file_dir)){
            mkdir($file_dir,0777,true);
        }
        $this->datedir = $datedir;
        $new_imgname = $this->basename . '.' . $this->filetype;
        $this->imgname = $datedir . '/' . $new_imgname;
        $this->fullname = $this->file_dir.'/'.$this->imgname;
    } 
    /**
     * 文件上传方法
     */
    public function upload_files($width = 0, $height = 0)
    {
        if($this->filesize/1024 > 10*1024*1024){
            Common::printJson(['status'=>0, 'message'=>'Upload file should not exceed 10 MB']);
            exit();
        }
        $this->ext_filename();
        if(in_array($this->filetype,$this->allow_upload_types)) {
            $tmp = str_replace('\\\\', '\\', $this->filepost['tmp_name']);
            $r = move_uploaded_file($tmp,  $this->fullname  );
        }else{
            Common::printJson(['status'=>0, 'message'=>'File type not allowed!']);
            exit();
        }
    }

    public function isSuccess(){
        if( file_exists($this->fullname) ){
            return true;
        }
        return false;
    }

}
?>