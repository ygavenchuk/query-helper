<?php
/**
 * Created by PhpStorm.
 * User: Y.Gavenchuk
 * Date: 09.05.14
 * Time: 17:07
 */

namespace QueryHelper;

class QueryHelper {

    /**
     * @var Factory - models factory
     */
    private $_factory = null;

    /**
     * Add extra info to each query
     * 
     * @param array $data - data from profiler
     *
     * @return array
     */
    private function _addExtraInfo(array $data) {
        $profiler = $this->_factory->getProfiler();
        $extraInfo = $this->_factory->getExtraInfo("postgre", $profiler->getConnector());
        foreach ($data as &$item) {
            $item["explain"] = $extraInfo->explain($item["query"]);
        }
        
        return $data;
    }

    public function __construct(array $config = array() ){
        if( empty($config["useExternalAutoload"]) ) {
            spl_autoload_register( __NAMESPACE__ . '\QueryHelper::autoLoad', false);
        }
        
        $this->_factory = new Factory();
    }

    /**
     * Internal autoload method
     * 
     * @param string $class - class to load
     */
    public static function autoLoad($class) {
        if(empty($class) or strpos($class, __NAMESPACE__) === false) {
            return;
        }

        $className = str_replace(__NAMESPACE__ . "\\", "", $class);

        if( class_exists($className, false) ) {
            return;
        }

        if( "I" === $className[0] ) {
            include_once(__DIR__ . "/interfaces/" . $className . ".php");
        } else {
            include_once(__DIR__ . "/models/" . $className . ".php" );
        } 
    }

    /**
     * Return profiler of db queries
     * 
     * @return DBProfiler
     */
    public function getProfiler() {
        return $this->_factory->getProfiler();
    }

    /**
     * Show profiler log
     */
    public function showLog() {
        $profiler = $this->getProfiler();
        $profilerData = $profiler->getData($profiler::LOG_ORDER_BY_TIME_DESC);
        $totalTime = $profiler->getTotalTime();
        
        $profilerData = $this->_addExtraInfo($profilerData);

        $view = $this->_factory->getView();
        $view->setTemplate("index");
        $view->render(array(
            "data" => $profilerData,
            "totalTime" => $totalTime,
        ));
    }
}
