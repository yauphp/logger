<?php
namespace Yauphp\Logger;

/**
 * 日志记录接口
 * @author Tomix
 *
 */
interface ILogger
{
    /**
     * 写入日志
     * @param string $message
     * @param string $type
     * @param string $prefix
     */
    function log($message,$type="error", $prefix="err");

    /**
     * 写入异常日志
     * @param \Exception $ex
     * @param string $prefix
     */
    function logException(\Exception $ex, $prefix="ex");
}