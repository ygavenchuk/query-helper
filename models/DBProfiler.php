<?php
/**
 * Created by PhpStorm.
 * User: Y.Gavenchuk
 * Date: 06.05.14
 * Time: 12:09
 */

namespace QueryHelper;

class DBProfiler 
{

    const LOG_ORDER_BY_CALL = 0;
    const LOG_ORDER_BY_TIME_ASC = 1;
    const LOG_ORDER_BY_TIME_DESC = 2;
    
    /**
     * @var Closure - callable function
     */
    private $_f;

    /**
     * @var array - call stack
     */
    private $_stack = array();

    /**
     * @var int - total execution time of queries
     */
    private $_totalTime = 0;

    /**
     * @var int - count of executed SQLs
     */
    private $_execCount = 0;

    /**
     * Define and return level of time execution of sql-query  
     * 
     * @param int $currTime - time of execution
     *
     * @return string
     */
    private function _getTimeLevel($currTime) {
        switch($currTime){
            case($currTime > 0.3):
                return "critical";
            case( $currTime > 0.1):
                return "warning";
            default:
                return "ok";
        }
    }

    /**
     * Sort log items by specified order
     * 
     * @param int $sortOrder -  sort order (as call, by default) or bu time
     *
     * @return array
     */
    private function _sortLogStack($sortOrder) {
        $result = $this->_stack;

        switch($sortOrder){
            case self::LOG_ORDER_BY_TIME_ASC:
                uasort($result, function($a, $b){
                    if( $a["time"] == $b["time"] ) {
                        return 0;
                    }

                    return ($a["time"] < $b["time"]) ? -1 : 1;
                });
                break;
            case self::LOG_ORDER_BY_TIME_DESC:
                uasort($result, function($a, $b){
                    if( $a["time"] == $b["time"] ) {
                        return 0;
                    }

                    return ($a["time"] < $b["time"]) ? 1 : -1;
                });
                break;
        }
        
        return $result;
    }

    /**
     * @param \Closure $func - main function, which need to decorate
     */
    public function init(\Closure $func) {
        $this->_f = $func;
    }

    /**
     * Return main function
     * 
     * @return \Closure
     */
    public function getConnector() {
        return $this->_f;
    }

    /**
     * Execute query, store execution time, result and query 
     * 
     * @param string $query - query to execute
     *
     * @return mixed - query result
     */
    public function run($query) {
        
        $t1 = microtime(1);
        $result = $this->_f->__invoke($query);
        $t2 = microtime(1);
        
        $currTime = $t2 - $t1;
        $this->_stack[] = array(
            "query" => $query,
            "time" => $currTime,
            "result" => $result,
            "order" => $this->_execCount,
            "level" => $this->_getTimeLevel($currTime),
        );
        
        $this->_totalTime += ($t2 - $t1);
        $this->_execCount++;
        
        return $result;
    }

    /**
     * Return log data
     *
     * @param int sortOrder - sort order (as call, by default) or by time
     *
     * @return array
     */
    public function getData($sortOrder = DBProfiler::LOG_ORDER_BY_CALL) {
        return $this->_sortLogStack($sortOrder);
    }
    
    /**
     * Return time of execution of all queries
     * 
     * @param int $precision - define count of decimal digits (after dot) to return
     * @return float
     */
    public function getTotalTime($precision=5) {
        return round($this->_totalTime, $precision);
    }
} 
