<?php
/**
 * Created by PhpStorm.
 * User: Y.Gavenchuk
 * Date: 09.05.14
 * Time: 21:42
 */

namespace QueryHelper;


class Factory {
    /**
     * @var View
     */
    private $_view = null;

    /**
     * @var DBProfiler
     */
    private $_profiler = null;

    /**
     * @var IExtraInfo
     */
    private $_extraInfo = null;

    /**
     * Return render of templates
     * 
     * @return View
     */
    public function getView() {
        if( empty($this->_view) ) {
            $this->_view = new View();
        }
        
        return $this->_view;
    }

    /**
     * Return profiler of db queries
     *
     * @return DBProfiler
     */
    public function getProfiler() {
        if( empty($this->_profiler) ) {
            $this->_profiler = new DBProfiler();
        }

        return $this->_profiler;
    }

    /**
     * @param  string  $itemType
     * @param callable $connect
     *
     * @return IExtendInfo
     */
    public function getExtraInfo($itemType, \Closure $connect) {
        $className = __NAMESPACE__ .  '\ExtraInfo';
        
        switch($itemType) {
            case "postgre":
                $className .= "Pg";
                break;
        }
        
        if( empty($this->_extraInfo) ) {
            $this->_extraInfo = new $className($connect);
        }

        if( get_class($this->_extraInfo) !== $className ) {
            return new $className($connect);
        }
        
        return $this->_extraInfo;
    }
} 
