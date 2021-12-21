<?php
namespace Yauphp\Logger\Internal;

use Yauphp\Logger\ILogger;
use Yauphp\Common\IO\File;
use Yauphp\Common\IO\Path;

/**
 * 文件日志记录
 * @author Tomix
 *
 */
class FileLogger implements ILogger
{
    /**
     * 日志记录位置
     * @var string
     */
    protected $m_logDir;

    /**
     * 获取日志记录位置(绝对目录)
     * @return string
     */
    public function getLogDir()
    {
        $dir=$this->m_logDir;
        if(empty($dir)){
            $dir=__DIR__."/../../../../../../_logs";
        }
        if(!file_exists($dir)){
            File::createDir($dir);
        }
        return $dir;
    }

    /**
     * 设置日志记录位置(相对应用根目录)
     * @param string $value
     */
    public function setLogDir($value)
    {
        $this->m_logDir=$value;
    }


    /**
     * 写入日志记录
     * @param $message	日志内容
     * @param $type		日志类型
     * @param $file		日志文件,写入文件时将会自动添加日期字串为后缀
     * @return void
     */
    public function log($message,$type="error",$prefix="err")
    {
        //msg
        $msg="time:".(string)date("Y-m-d H:i:s")."\r\n";
        $msg.="type:".$type."\r\n";
        $msg.="addr:".$_SERVER["REMOTE_ADDR"]."\r\n";
        $msg.="uri:".$_SERVER["REQUEST_URI"]."\r\n";
        $msg.="desc:".$message;
        $msg.="\r\n------------------------------------------------------------------------------------\r\n";

        //path
        $path=$this->getLogDir();
        $fn=Path::combinePath($path,str_replace(" ","_",$prefix)."_".(string)date("Ymd").".log");
        $fp=@fopen($fn,"ab");
        @fwrite($fp,$msg);
        @fclose($fp);
    }

    /**
     * 写入异常日志
     * @param \Exception $ex
     * @param string $prefix
     */
    public function logException(\Exception $ex,$prefix="ex")
    {
        $this->log($ex->getCode().":".$ex->getMessage()."\r\n".$ex->getTraceAsString(),get_class($ex),$prefix);
    }
}

