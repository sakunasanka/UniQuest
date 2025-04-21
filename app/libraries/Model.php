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

    // protected function buildWhereClause($conditions, &$bindings, $logicalOperator = 'AND')
    // {
    //     // Initialize an index to create unique placeholders for binding values
    //     $index = 0;

    //     // Array to hold the condition strings for the WHERE clause
    //     $conditionStrings = [];

    //     // Loop through each condition in the conditions array
    //     foreach ($conditions as $condition) {
    //         // Extract column, operator, and value from the condition
    //         $column = $condition[0]; // The column name or expression
    //         $operator = $condition[1]; // The SQL operator (e.g., '=', 'IN', 'LIKE')
    //         $value = $condition[2]; // The value to compare against

    //         // Handle special case for SQL functions in column (like CONCAT_WS)
    //         if (strpos($column, '(') !== false) {
    //             // For SQL functions, use the expression directly without parameter binding
    //             $conditionStrings[] = "$column $operator " . $this->db->quote($value);
    //             continue;
    //         }

    //         if ($operator === 'IN' || $operator === 'NOT IN') {
    //             // Special handling for the 'IN' operator

    //             // Array to store placeholders for the 'IN' values
    //             $placeholders = [];

    //             // Loop through each value in the 'IN' clause
    //             foreach ((array)$value as $v) {
    //                 // Create a unique placeholder for each value
    //                 $placeholder = "{$column}_{$index}";
    //                 $placeholders[] = ":$placeholder";

    //                 // Add the value to the bindings array with the placeholder as the key
    //                 $bindings[$placeholder] = $v;

    //                 // Increment the index for the next placeholder
    //                 $index++;
    //             }

    //             // Add the condition string for the 'IN' operator to the array
    //             $conditionStrings[] = "$column $operator (" . implode(', ', $placeholders) . ")";
    //         } else {
    //             // For regular operators (e.g., '=', '<>', '<', '>', 'LIKE')

    //             // Create a unique placeholder for the value
    //             $placeholder = "{$column}_{$index}";

    //             // Add the value to the bindings array with the placeholder as the key
    //             $bindings[$placeholder] = $value;

    //             // Increment the index for the next placeholder
    //             $index++;

    //             // Add the condition string for the regular operator to the array
    //             $conditionStrings[] = "$column $operator :$placeholder";
    //         }
    //     }

    //     // Join all condition strings with logical operator to form the complete WHERE clause
    //     return implode(" $logicalOperator ", $conditionStrings);
    // }

    /**
     * Builds a WHERE clause from conditions array with parameter binding
     * 
     * @param array $conditions Array of conditions in format [column, operator, value]
     * @param array &$bindings Reference to store parameter bindings
     * @param string $logicalOperator Operator to join conditions (AND/OR)
     * @return string The generated WHERE clause
     * @throws InvalidArgumentException For invalid BETWEEN conditions
     */
    protected function buildWhereClause($conditions, &$bindings, $logicalOperator = 'AND')
    {
        // Counter for creating unique parameter placeholders
        $index = 0;

        // Array to store individual condition strings
        $conditionStrings = [];

        // Process each condition in the input array
        foreach ($conditions as $condition) {
            // Extract condition components
            $column = $condition[0];       // Column name or SQL expression
            $operator = strtoupper($condition[1]); // Normalize operator to uppercase
            $value = $condition[2] ?? null; // Optional value (not needed for NULL/EXISTS)

            // =======================================================================
            // Special Operator Handling
            // These operators need custom processing different from standard comparisons
            // =======================================================================

            // IS NULL / IS NOT NULL - Don't need value binding
            if ($operator === 'IS NULL' || $operator === 'IS NOT NULL') {
                $conditionStrings[] = "$column $operator";
                continue;
            }

            // BETWEEN - Requires array with exactly 2 values
            if ($operator === 'BETWEEN') {
                // Validate BETWEEN value format
                if (!is_array($value) || count($value) !== 2) {
                    throw new InvalidArgumentException(
                        'BETWEEN operator requires an array with exactly 2 values'
                    );
                }

                // Create unique placeholders for min/max values
                $minPlaceholder = "{$column}_{$index}_min";
                $maxPlaceholder = "{$column}_{$index}_max";

                // Add values to bindings
                $bindings[$minPlaceholder] = $value[0];
                $bindings[$maxPlaceholder] = $value[1];

                // Build condition string
                $conditionStrings[] = "$column BETWEEN :$minPlaceholder AND :$maxPlaceholder";
                $index += 2; // Increment counter by 2 for the two values
                continue;
            }

            // EXISTS/NOT EXISTS - Value should contain a subquery
            if ($operator === 'EXISTS' || $operator === 'NOT EXISTS') {
                $conditionStrings[] = "$operator ($value)";
                continue;
            }

            // RAW SQL - Directly insert the SQL fragment (use with caution!)
            if ($operator === 'RAW') {
                $conditionStrings[] = $value;
                continue;
            }

            // =======================================================================
            // SQL Function Handling (e.g., CONCAT_WS(), DATE(), etc.)
            // Identified by parentheses in column name
            // =======================================================================
            if (strpos($column, '(') !== false) {
                $placeholder = "func_{$index}";
                $bindings[$placeholder] = $value;
                $conditionStrings[] = "$column $operator :$placeholder";
                $index++;
                continue;
            }

            // =======================================================================
            // Standard Operators (IN, NOT IN, =, <>, >, <, etc.)
            // =======================================================================

            // IN/NOT IN - Handle array of values
            if ($operator === 'IN' || $operator === 'NOT IN') {
                $placeholders = [];

                // Create a placeholder for each value in the array
                foreach ((array)$value as $v) {
                    $placeholder = "{$column}_{$index}";
                    $placeholders[] = ":$placeholder";
                    $bindings[$placeholder] = $v;
                    $index++;
                }

                $conditionStrings[] = "$column $operator (" . implode(', ', $placeholders) . ")";
            }
            // Standard comparison operators (=, <>, >, <, LIKE, etc.)
            else {
                $placeholder = "{$column}_{$index}";
                $bindings[$placeholder] = $value;
                $conditionStrings[] = "$column $operator :$placeholder";
                $index++;
            }
        }

        // Combine all conditions with the specified logical operator
        return implode(" $logicalOperator ", $conditionStrings);
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

    public function select(
        string $table,           // The table name to query
        array $where = [],       // Array of conditions for the WHERE clause
        string $columns = '*',   // The columns to select (default is all columns)
        string $logicalOperator = 'AND', // Logical operator to combine conditions ('AND' or 'OR')
        string $groupBy = '',    // Optional GROUP BY clause
        string $orderBy = '',    // Optional ORDER BY clause
        int $limit = 0,          // Optional LIMIT for the number of rows to fetch
        int $pageNumber = 1,    // Optional page number for pagination
        bool $fetchAll = false   // Whether to fetch all rows or just a single row
    ) {
        // Start building the query
        $query = "SELECT $columns FROM $table";

        // Array to store bindings for the query
        $bindings = [];

        // Add WHERE clause if conditions are provided
        if ($where) {
            // Generate the WHERE clause using buildWhereClause method
            $query .= ' WHERE ' . $this->buildWhereClause($where, $bindings, $logicalOperator);
        }

        // Add GROUP BY clause if specified
        if (!empty($groupBy)) {
            $query .= " GROUP BY $groupBy";
        }

        // Add ORDER BY clause if specified
        if (!empty($orderBy)) {
            $query .= " ORDER BY $orderBy";
        }

        // Separate COUNT Query
        $countQuery = "SELECT COUNT(*) as totalRows FROM $table";
        if (!empty($where)) {
            $countQuery .= ' WHERE ' . $this->buildWhereClause($where, $bindings, $logicalOperator);
        }

        // Execute COUNT Query
        $this->db->query($countQuery);
        $this->bindParams($bindings);
        $totalRows = $this->db->single()->totalRows;

        // Pagination
        if ($fetchAll && $limit > 0) {
            $offset = ($pageNumber - 1) * $limit;
            $query .= " LIMIT $limit OFFSET $offset";
        }

        // Prepare the query
        $this->db->query($query);
        // Bind parameters to the query
        $this->bindParams($bindings);
        $data = $this->db->resultSet();

        // Execute the query and return the result
        if ($fetchAll) {
            $data = [
                'data' => $data,
                'currentPage' => $pageNumber,
                'limit' => $limit,
                'totalRows' => $totalRows,
                'totalPages' => ($limit > 0) ? ceil($totalRows / $limit) : 1,
                'isLastPage' => ($limit > 0) ? ($pageNumber >= ceil($totalRows / $limit)) : true
            ];
            return $data;
        } else {
            return $this->db->single();
        }
    }

    // public function getCount(
    //     string $table,
    //     array $where = [],
    //     string $logicalOperator = 'AND',
    //     string $groupBy = '',
    //     string $orderBy = ''
    // ) {
    //     try {
    //         // Start building the query
    //         $query = "SELECT COUNT(*) AS rowCount FROM $table";
    //         $bindings = [];

    //         // Add WHERE clause if conditions are provided
    //         if ($where) {
    //             $query .= ' WHERE ' . $this->buildWhereClause($where, $bindings, $logicalOperator);
    //         }

    //         // Add GROUP BY clause if provided
    //         if (!empty($groupBy)) {
    //             $query .= " GROUP BY $groupBy";
    //         }

    //         // Add ORDER BY clause if provided
    //         if (!empty($orderBy)) {
    //             $query .= " ORDER BY $orderBy";
    //         }

    //         // Prepare the query
    //         $this->db->query($query);

    //         // Bind the parameters
    //         $this->bindParams($bindings);

    //         // Execute and fetch the result
    //         $result = $this->db->resultSet();

    //         // If GROUP BY is used, count the rows in the grouped result set
    //         if (!empty($groupBy)) {
    //             return count($result);
    //         }

    //         // Otherwise, return the single row count
    //         return $result[0]['rowCount'] ?? 0;
    //     } catch (PDOException $e) {
    //         error_log("Database Error: " . $e->getMessage());
    //         return false;
    //     } catch (Exception $e) {
    //         error_log("General Error: " . $e->getMessage());
    //         return false;
    //     }
    // }
}
