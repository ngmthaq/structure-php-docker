<?php

namespace Src\Helpers;

use PDO;
use PDOStatement;

class Database
{
    public const GLOBAL_KEY = "__DATABASE_GLOBAL_KEY__";

    /**
     * Database host
     */
    protected string $host;

    /**
     * Database port
     */
    protected string $port;

    /**
     * Database name
     */
    protected string $dbname;

    /**
     * Database username
     */
    protected string $username;

    /**
     * Database password
     */
    protected string $password;

    /**
     * SQL string template
     */
    protected string $sql;

    /**
     * Binding param values
     */
    protected array $params;

    /**
     * Database connection
     */
    protected PDO $conn;

    public function __construct()
    {
        $this->host = $_ENV["DB_HOST"];
        $this->port = $_ENV["DB_PORT"];
        $this->username = $_ENV["DB_USERNAME"];
        $this->password = $_ENV["DB_PASSWORD"];
        $this->dbname = $_ENV["DB_NAME"];
        $this->sql = "";
        $this->params = [];
        $this->connect();
    }

    /**
     * Connect to database server
     * 
     * @return void
     */
    protected function connect()
    {
        $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->dbname . ";port=" . $this->port;
        $conn = new PDO($dsn, $this->username, $this->password);
        $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->conn = $conn;
    }

    /**
     * Set SQL string template
     * 
     * @param string $sql sql template
     * @return void
     */
    public function setSql(string $sql)
    {
        $this->sql = $sql;
    }

    /**
     * Binding parameter
     * 
     * @param string $binding binding key
     * @param string|int $value binding value
     * @param int $type binding type (PDO::PARAM_STR | PDO::PARAM_INT)
     * @return void
     */
    public function setParam(string $binding, string|int $value, int $type = PDO::PARAM_STR)
    {
        $this->params[] = compact("binding", "value", "type");
    }

    /**
     * Begin transaction
     * 
     * @return bool
     */
    public function begin()
    {
        Dev::writeLog("BEGIN_TRANSACTION", "db", LOG_STATUS_INFO);
        return $this->conn->beginTransaction();
    }

    /**
     * Commit transaction
     * 
     * @return bool
     */
    public function commit()
    {
        if (!$this->conn->inTransaction()) return false;
        Dev::writeLog("COMMIT_TRANSACTION", "db", LOG_STATUS_INFO);
        return $this->conn->commit();
    }

    /**
     * Roll back transaction
     * 
     * @return bool
     */
    public function rollBack()
    {
        if (!$this->conn->inTransaction()) return false;
        Dev::writeLog("ROLL_BACK_TRANSACTION", "db", LOG_STATUS_INFO);
        return $this->conn->rollBack();
    }

    /**
     * Prepare execute
     * 
     * @return PDOStatement|null
     */
    public function execute()
    {
        try {
            DEV::writeLog("SQL: " . $this->sql . ", params: " . json_encode($this->params), "db", LOG_STATUS_INFO);
            $stm = $this->conn->prepare($this->sql);
            if ($stm) {
                foreach ($this->params as $param) {
                    $stm->bindParam($param["binding"], $param["value"], $param["type"]);
                }
                $stm->execute();
                return $stm;
            }
            return null;
        } catch (\Throwable $th) {
            Dev::writeLog("SQL: " . $this->sql . ", params: " . json_encode($this->params) . "Error: " . $th->getMessage(), "db", LOG_STATUS_ERROR);
            throw $th;
        }
    }
}
