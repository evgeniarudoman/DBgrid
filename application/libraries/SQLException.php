<?php
class SQLException extends Exception {
    
    /* The SQL associated with this exception */
    private $sql;
    
    /* Create a new SQLException */
    function SQLException ($message, $code = "", $query = null)
    {
        parent::__construct($message, $code);
        if ($query != null)
            $this->sql = $query;
    }
    
    /* Return the query associated with this exception */
    function getQuery()
    {
        return $this->sql;
    }
    
    /* Convert the Exception to String */
    function __toString()
    {
        return "Code: ".$this->getCode()." Message: ".$this->getMessage()." Query: ".$this->getQuery();
    }
}