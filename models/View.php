<?php
/**
 * Created by PhpStorm.
 * User: Y.Gavenchuk
 * Date: 09.05.14
 * Time: 16:44
 */

namespace QueryHelper;

class View {
    const DEFAULT_TEMPLATE_PATH = "/../templates";
    const DEFAULT_TEMPLATE_EXT = "php";

    /**
     * @var string - name of template
     */
    private $_template = "";
    private $_tplPath = View::DEFAULT_TEMPLATE_PATH;
    private $_tplExt = View::DEFAULT_TEMPLATE_EXT;

    /**
     * View template
     * @param string $tplPath - path to the template folder
     * @param string $tplExt - extension of template files (without leading dot)
     */
    public function __construct($tplPath=View::DEFAULT_TEMPLATE_PATH, 
                                $tplExt=View::DEFAULT_TEMPLATE_EXT) {
        $this->_tplPath = __DIR__ . $tplPath;
        $this->_tplExt = $tplExt;
    }

    /**
     * @param string $templateName - set template name
     */
    public function setTemplate($templateName){
        $this->_template = $templateName;
    }

    /**
     * Render template
     * 
     * @param array $data - data to put into template
     * @param bool  $return - True - return rendered template as function result, false (default)
     *                      echo it to output (browser)
     *
     * @return string
     */
    public function render(array $data=array(), $return=false){
        extract($data);
        ob_start();
        include_once($this->_tplPath . "/" .  $this->_template . "." . $this->_tplExt);
        $result = ob_get_contents();
        ob_end_clean();
        
        if($return) {
            return $result;
        }
        
        echo $result;
        
        return "";
    }

} 
