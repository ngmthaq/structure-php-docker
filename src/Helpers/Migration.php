<?php

namespace Src\Helpers;

class Migration
{
    /**
     * Migration version
     */
    protected int $version;

    /**
     * Database instance
     */
    protected Database $db;

    /**
     * Query array
     */
    protected array $queries;

    public function __construct()
    {
        $this->db = new Database();
        $this->queries = [];
        $this->version = 1;
    }

    /**
     * Set version
     */
    public function setVersion(int $version)
    {
        $this->version = $version;
    }

    /**
     * Run the migrations
     * 
     * @return void
     */
    public function run(bool $is_run_all_queries = false)
    {
        try {
            $this->db->begin();
            foreach ($this->queries as $query) {
                if ($is_run_all_queries) {
                    $this->db->setSql($query["sql"]);
                    $this->db->execute();
                } else {
                    if ($query["version"] === $this->version) {
                        $this->db->setSql($query["sql"]);
                        $this->db->execute();
                    }
                }
            }
            $this->db->commit();
            exit();
        } catch (\Throwable $th) {
            Dev::writeLog($th->getMessage(), "error", LOG_STATUS_ERROR);
            $this->db->rollBack();
            exit();
        }
    }

    /**
     * Migration query configs
     * 
     * @param string $sql
     * @param int $version
     * @return void
     */
    public function query(string $sql, int $version)
    {
        $this->queries[] = compact("sql", "version");
    }
}
