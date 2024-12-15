<?php
class Model 
{
    protected $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
        if (!$this->db) {
            throw new Exception("Database connection is not established.");
        }
    }

    protected function bindParams($params)
    {
        foreach ($params as $key => $value) {
            $this->db->bind(':' . $key, $value);
        }
    }

    public function insert($table, $data)
    {
        $columns = implode(', ', array_keys($data));
        $values = ':' . implode(', :', array_keys($data));
        $query = "INSERT INTO $table ($columns) VALUES ($values)";
        
        $this->db->query($query);
        $this->bindParams($data);

        return $this->db->execute();
    }

    public function select($table, $where = [], $columns = '*')
    {
        $whereClause = '';
        if (!empty($where)) {
            $whereClause = ' WHERE ';
            foreach ($where as $key => $value) {
                $whereClause .= "$key = :$key AND ";
            }
            $whereClause = rtrim($whereClause, ' AND ');
        }

        $query = "SELECT $columns FROM $table $whereClause";
        $this->db->query($query);
        $this->bindParams($where);

        return $this->db->single();
    }

    public function selectAll($table, $where = [], $columns = '*')
    {
        $whereClause = '';
        if (!empty($where)) {
            $whereClause = ' WHERE ';
            foreach ($where as $key => $value) {
                $whereClause .= "$key = :$key AND ";
            }
            $whereClause = rtrim($whereClause, ' AND ');
        }

        $query = "SELECT $columns FROM $table $whereClause";
        $this->db->query($query);
        $this->bindParams($where);

        return $this->db->resultSet();
    }

    public function update($table, $data, $where)
    {
        $setClause = '';
        foreach ($data as $key => $value) {
            $setClause .= "$key = :$key, ";
        }
        $setClause = rtrim($setClause, ', ');

        $whereClause = '';
        foreach ($where as $key => $value) {
            $whereClause .= "$key = :$key AND ";
        }
        $whereClause = rtrim($whereClause, ' AND ');

        $query = "UPDATE $table SET $setClause WHERE $whereClause";
        $this->db->query($query);
        $this->bindParams($data);
        $this->bindParams($where);

        return $this->db->execute();
    }

    public function delete($table, $where)
    {
        $whereClause = '';
        foreach ($where as $key => $value) {
            $whereClause .= "$key = :$key AND ";
        }
        $whereClause = rtrim($whereClause, ' AND ');

        $query = "DELETE FROM $table WHERE $whereClause";
        $this->db->query($query);
        $this->bindParams($where);

        return $this->db->execute();
    }
}
?>