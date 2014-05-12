<?php
/**
 * Created by PhpStorm.
 * User: Y.Gavenchuk
 * Date: 09.05.14
 * Time: 16:09
 */ 

namespace QueryHelper;

interface IExtendInfo 
{
    /**
     * Explain qeury by DB engine
     * 
     * @param string $query - query string which need to explain by db engine
     * @param array $additionalOptions - additional options of explain
     *
     * @return string - explained query
     */
    public function explain($query, array $additionalOptions=array());

    /**
     * Return list of db indexes
     * 
     * @param string $tableName - name of table
     *
     * @return array - list of indexes
     */
    public function getTableIndexes($tableName);
}
