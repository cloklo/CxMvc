<?php
/**
 * Created by PhpStorm.
 * User: chenxiong
 * Date: 16/4/13
 * Time: 下午10:06
 */
class Rmcache extends CxMysql {

    /**
     * @var CxRedis
     */
    protected $redis;

    protected $enable;

    /**
     * 添加数据到redis
     * @param $key
     * @param null $content
     * @param int $timeout
     * @return bool
     */
    public function set($key,$content,$timeout=0) {
        if(is_object($content)){
            $content = call_user_func($content,$key);
        }
        return $this->redis->set($key,$content,$timeout);
    }

    /**
     * 将数据添加到redis之前,先转化为json
     * @param $key
     * @param null $content
     * @param int $timeout
     * @return bool
     */
    public function setJson($key,$content=null,$timeout=0) {
        if(is_object($content)){
            $content = call_user_func($content,$key);
        }
        $content = json_encode($content);
        return $this->redis->set($key,$content,$timeout);
    }

    /**
     * 根据key从redis中获取数据,获取不到将判断$content是否为函数
     * 如果$content是函数,将吧$content函数到返回值存储到redis并返回
     * 如果$content非函数,则直接把$content存入redis并返回
     * @param $key
     * @param int $timeout
     * @param null $content
     * @return array|bool|mixed|null|string
     */
    public function get($key,$content=null,$timeout=0) {
        $result = $this->redis->get($key);
        if($result === null) {
            return $result;
        }
        if(is_object($content)){
            $content = call_user_func($content,$key);
            $this->set($key,$content,$timeout);
        }
        else if($content != null){
            $this->set($key,$content,$timeout);
        }
        return $content;
    }

    /**
     * 同get方法类似,只是会对返回值先进行json_decode
     * @param $key
     * @param int $timeout
     * @param null $content
     * @return mixed
     */
    public function getJson($key,$content=null,$timeout=0) {
        $result = $this->redis->get($key);
        if($result === null) {
            return json_decode($result);
        }
        $this->setJson($key,$content,$timeout);
        return $content;
    }

    public function hget($key,$timeout=0,$content=null) {
        //$this->redis->hset()
        return $content;
    }

    public function hset($key,$timeout=0,$content=null) {

        return $content;
    }

    public function hgetJson($key,$timeout=0,$content=null) {

        return $content;
    }

    public function hsetJson($key,$timeout=0,$content=null) {

        return $content;
    }



}