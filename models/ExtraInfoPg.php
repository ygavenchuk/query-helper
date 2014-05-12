<?php
/**
 * Created by PhpStorm.
 * User: Y.Gavenchuk
 * Date: 09.05.14
 * Time: 22:17
 */

namespace QueryHelper;


class ExtraInfoPg implements IExtendInfo {

    /**
     * @var \Closure - closure, which can execute queries
     */
    private $_connect = null;
    
    
    public function __construct(\Closure $connector) {
        $this->_connect = $connector;
    }

    /**
     * Explain qeury by DB engine
     *
     * @param string $query             - query string which need to explain by db engine
     * @param array  $additionalOptions - additional options of explain
     *
     * @return string - explained query
     */
    public function explain($query, array $additionalOptions = array()) {
        $extraQuery = "EXPLAIN ";
        
        if( !empty($additionalOptions) ) {
            $extraQuery .= "(" . implode(",", $additionalOptions) . ") ";
        }
        
        $explainData = $this->_connect->__invoke($extraQuery . $query);
        $result = array();
        
        foreach($explainData as $item) {
            $result[] = reset($item);
        }
        
        return implode(PHP_EOL, $result);
    }

    /**
     * Return list of db indexes
     *
     * @param string $tableName - name of table
     *
     * @return array - list of indexes
     */
    public function getTableIndexes($tableName) {
        return array();
    }
} 
