<?php

// Model class to handle database interactions
class Model 
{
    // Database instance
    protected $db;

    // Constructor to initialize the database connection
    public function __construct()
    {
        // Attempt to get the database instance
        $this->db = Database::getInstance();
        
        // If the database connection isn't established, throw an exception
        if (!$this->db) {
            throw new Exception("Database connection is not established.");
        }
    }

    // Helper method to bind parameters to the query
    protected function bindParams($params)
    {
        // Loop through each parameter and bind it to the database query
        foreach ($params as $key => $value) {
            // Bind parameters in the format ':key' for placeholders
            $this->db->bind(':' . $key, $value);
        }
    }

    // Insert data into a table
    public function insert($table, $data)
    {
        // Prepare column names from the keys of the data array
        $columns = implode(', ', array_keys($data));
        
        // Prepare placeholders for the values to be inserted
        $placeholders = ':' . implode(', :', array_keys($data));
        
        // Create the SQL query
        $query = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        
        // Prepare the query
        $this->db->query($query);
        
        // Bind parameters to the query
        $this->bindParams($data);
        
        // Execute the query and return the result (e.g., success or failure)
        return $this->db->execute();
    }

    // Update data in a table
    public function update($table, $data, $where)
    {
        // Generate the SET clause from the data array (e.g., column1 = :column1, ...)
        $setClause = implode(', ', array_map(fn($k) => "$k = :$k", array_keys($data)));
        
        // Generate the WHERE clause from the where array (e.g., column1 = :column1 AND column2 = :column2)
        $whereClause = implode(' AND ', array_map(fn($k) => "$k = :$k", array_keys($where)));

        // Create the SQL query
        $query = "UPDATE $table SET $setClause WHERE $whereClause";

        // Prepare the query
        $this->db->query($query);

        // Bind parameters for both the data to update and the where condition
        $this->bindParams(array_merge($data, $where));

        // Execute the query and return the result
        return $this->db->execute();
    }

    // Delete data from a table
    public function delete($table, $where)
    {
        // Generate the WHERE clause from the where array (e.g., column1 = :column1 AND column2 = :column2)
        $whereClause = implode(' AND ', array_map(fn($k) => "$k = :$k", array_keys($where)));
        
        // Create the SQL query
        $query = "DELETE FROM $table WHERE $whereClause";

        // Prepare the query
        $this->db->query($query);

        // Bind the where parameters to the query
        $this->bindParams($where);

        // Execute the query and return the result
        return $this->db->execute();
    }

    // Select data from a table with optional conditions and logical operator (AND/OR)
    public function select($table, $where = [], $columns = '*', $logicalOperator = 'AND', $fetchAll = false)
    {
        // Start the query (selecting the specified columns from the table)
        $query = "SELECT $columns FROM $table";
        
        // Initialize the bindings array to store the placeholder values
        $bindings = [];
        
        // Initialize an index to ensure unique placeholders for each condition
        $index = 0;

        // If there are conditions, build the WHERE clause
        if ($where) {
            // Generate condition strings by processing each condition in the where array
            $conditionStrings = array_map(function($condition) use (&$bindings, &$index) {
                if (is_array($condition[0])) {
                    // If the condition is an array (nested conditions), handle them separately
                    $nestedConditions = array_map(function($nestedCondition) use (&$bindings, &$index) {
                        // Destructure the nested condition into column, operator, and value
                        [$column, $operator, $value] = $nestedCondition;
                        // Create a unique placeholder using the column and index
                        $placeholder = "{$column}_{$index}";
                        // Bind the value to the placeholder
                        $bindings[$placeholder] = $value;
                        // Increment the index for the next placeholder
                        $index++; 
                        return "$column $operator :$placeholder";
                    }, $condition);
                    // Return the nested conditions enclosed in parentheses, joined by OR
                    return '(' . implode(" OR ", $nestedConditions) . ')';
                } else {
                    // For regular conditions (non-nested), handle them here
                    [$column, $operator, $value] = $condition;
                    // Create a unique placeholder using the column and index
                    $placeholder = "{$column}_{$index}";
                    // Bind the value to the placeholder
                    $bindings[$placeholder] = $value;
                    // Increment the index for the next placeholder
                    $index++; 
                    return "$column $operator :$placeholder";
                }
            }, $where);

            // Append the WHERE clause to the query, joining conditions with the logical operator (AND/OR)
            $query .= ' WHERE ' . implode(" $logicalOperator ", $conditionStrings);
        }

        // Prepare the query
        $this->db->query($query);

        // Bind the parameters (values) to the placeholders in the query
        $this->bindParams($bindings);

        // Execute the query and return the result (either single or multiple rows based on $fetchAll)
        return $fetchAll ? $this->db->resultSet() : $this->db->single();
    }
}

?>