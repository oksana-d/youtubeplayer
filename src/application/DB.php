<?php

namespace src\application;

class DB
{
	private static $pdo;
    private $sQuery;
    private $bConnected = false;
	
	private function __construct() {
        $config = require 'mysql_db.php';
		$this->pdo = new \PDO('mysql:dbname=' . $config['name'] . ';host=' . $config['host'] . ';port=' . $config['port'] . ';charset=utf8',
                $config['user'],
                $config['password'],
                array(
                    \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                    \PDO::ATTR_EMULATE_PREPARES => false,
                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                    \PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true
                )
	);
		return $this->pdo;
	}
	
	public function connect()
	{
		if (self::$pdo === Null) {
        self::$pdo = new self();
		}
		return self::$pdo;
	}

    private function Init($query, $parameters = "")
    {
        if (!$this->bConnected) {
            $this->Connect();
        }
        
        $this->parameters = $parameters;
        $this->sQuery     = $this->pdo->prepare($this->BuildParams($query, $this->parameters));

        if (!empty($this->parameters)) {
            if (array_key_exists(0, $parameters)) {
                $parametersType = true;
                array_unshift($this->parameters, "");
                unset($this->parameters[0]);
            } else {
                $parametersType = false;
            }
            foreach ($this->parameters as $column => $value) {
                $this->sQuery->bindParam($parametersType ? intval($column) : ":" . $column, $this->parameters[$column]); //It would be query after loop end(before 'sQuery->execute()').It is wrong to use $value.
            }
        }

        $this->succes = $this->sQuery->execute();
        $this->querycount++;
        $this->parameters = array();
    }

    private function BuildParams($query, $params = array()){
        if (!empty($params)) {
            $array_parameter_found = false;

            foreach ($params as $parameter_key => $parameter) {
                if (is_array($parameter)){
                    $array_parameter_found = true;
                    $in = "";
                    foreach ($parameter as $key => $value){
                        $name_placeholder = $parameter_key."_".$key;
                        // concatenates params as named placeholders
                        $in .= ":".$name_placeholder.", ";
                        // adds each single parameter to $params
                        $params[$name_placeholder] = $value;
                    }
                    $in = rtrim($in, ", ");
                    $query = preg_replace("/:".$parameter_key."/", $in, $query);
                    // removes array form $params
                    unset($params[$parameter_key]);
                }
            }
            // обновить $this->params если $params и $query были изменены
            if ($array_parameter_found) $this->parameters = $params;
        }
        return $query;
    }

    public function query($query, $params = null, $fetchmode = \PDO::FETCH_ASSOC)
    {
        $query        = trim($query);
        $rawStatement = explode(" ", $query);
        $this->Init($query, $params);
        $statement = strtolower($rawStatement[0]);

        if ($statement === 'select' || $statement === 'show') {
            return $this->sQuery->fetchAll($fetchmode);
        } elseif ($statement === 'insert' || $statement === 'update' || $statement === 'delete') {
            return $this->sQuery->rowCount();
        } else {
            return NULL;
        }
    }

    public function lastInsertId()
    {
        return $this->pdo->lastInsertId();
    }

    public function column($query, $params = null)
    {
        $this->Init($query, $params);
        $resultColumn = $this->sQuery->fetchAll(PDO::FETCH_COLUMN);
        $this->rowCount = $this->sQuery->rowCount();
        $this->columnCount = $this->sQuery->columnCount();
        $this->sQuery->closeCursor();
        return $resultColumn;
    }

    public function row($query, $params = null, $fetchmode = PDO::FETCH_ASSOC)
    {
        $this->Init($query, $params);
        $resultRow = $this->sQuery->fetch($fetchmode);
        $this->rowCount = $this->sQuery->rowCount();
        $this->columnCount = $this->sQuery->columnCount();
        $this->sQuery->closeCursor();
        return $resultRow;
    }

    public function single($query, $params = null)
    {
        $this->Init($query, $params);
        return $this->sQuery->fetchColumn();
    }
}