<?php
session_start();
$leave_credits = 7;
date_default_timezone_set('Asia/Manila'); 

class DatabaseHandler {

    private $pdo;

    public function __construct() {
        // Set your database connection parameters here
        $dbHost = 'localhost';
        $dbPort = '3306';
        $dbName = 'cifra';
        $dbUser = 'root';
        $dbPassword = '';


        try {
            $dsn = "mysql:host=$dbHost;port=$dbPort;dbname=$dbName";
            $this->pdo = new PDO($dsn, $dbUser, $dbPassword);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            // Handle connection errors
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function getAllRowsFromTable($tableName) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM $tableName WHERE status = 0");
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            // Handle query errors
            echo "Query failed: " . $e->getMessage();
        }
    }
  

    public function getAllEmployee($status) {
        try {
            $stmt = $this->pdo->prepare("
                SELECT a.id, a.email,a.role, b.*
                FROM `users` AS a 
                JOIN `user_details` AS b 
                ON a.id = b.user_id 
                WHERE a.status = :status 
                AND (a.role = 'employee' OR a.role = 'head');
                
            ");
            $stmt->bindParam(':status', $status, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            // Handle query errors
            echo "Query failed: " . $e->getMessage();
        }
    }

    

    public function getAllApplicants($status) {
        try {
            $stmt = $this->pdo->prepare("
                SELECT a.id,a.email,b.*,c.job_id,c.application_status,c.id as job_applications_id FROM `users` as a 
                JOIN user_details as b 
                ON a.id = b.user_id
                JOIN job_applications as c 
                ON a.id = c.user_id
                WHERE a.status = :status AND a.role = 'applicant' AND c.status = 0 
                AND c.application_status != 'declined'
            ");
            $stmt->bindParam(':status', $status, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            // Handle query errors
            echo "Query failed: " . $e->getMessage();
        }
    }

    public function getAllApplicantsDeclined($status) {
        try {
            $stmt = $this->pdo->prepare("
                SELECT a.id,a.email,b.*,c.job_id,c.application_status,c.id as job_applications_id FROM `users` as a 
                JOIN user_details as b 
                ON a.id = b.user_id
                JOIN job_applications as c 
                ON a.id = c.user_id
                WHERE a.status = :status AND a.role = 'applicant' AND c.status = 0 
                AND c.application_status = 'declined'
            ");
            $stmt->bindParam(':status', $status, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            // Handle query errors
            echo "Query failed: " . $e->getMessage();
        }
    }
    public function getAllRoom() {
        try {
            $stmt = $this->pdo->prepare("
                SELECT * FROM room
                WHERE status = 0 
            ");
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            // Handle query errors
            echo "Query failed: " . $e->getMessage();
        }
    }
    public function getAllCourse() {
        try {
            $stmt = $this->pdo->prepare("
                SELECT * FROM course
                WHERE status = 0 
            ");
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            // Handle query errors
            echo "Query failed: " . $e->getMessage();
        }
    }

    public function getAllJobPosting($ascending) {
        // Validate the $ascending parameter
        $ascending = strtoupper($ascending);
        if ($ascending !== 'ASC' && $ascending !== 'DESC') {
            throw new InvalidArgumentException("Invalid sort order provided. Use 'ASC' or 'DESC'.");
        }
    
        try {
            $stmt = $this->pdo->prepare("
                SELECT * FROM job_posting 
                WHERE status = 0 
                ORDER BY datetime_created $ascending
            ");
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            error_log("Query failed: " . $e->getMessage());
        }
    }
    
      // Fetch paginated job postings
      public function getPaginatedJobPosting($ascending, $offset, $recordsPerPage) {
        // Validate the $ascending parameter
        $ascending = strtoupper($ascending);
        if ($ascending !== 'ASC' && $ascending !== 'DESC') {
            throw new InvalidArgumentException("Invalid sort order provided. Use 'ASC' or 'DESC'.");
        }

        try {
            $stmt = $this->pdo->prepare("SELECT * FROM job_posting
            WHERE status = 0 
             ORDER BY datetime_created $ascending LIMIT :offset, :recordsPerPage");
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            $stmt->bindParam(':recordsPerPage', $recordsPerPage, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            error_log("Query failed: " . $e->getMessage());
            return [];
        }
    }

    // Fetch total job count
    public function getTotalJobCount() {
        try {
            $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM job_posting WHERE status = 0 ");
            $stmt->execute();
            $result = $stmt->fetchColumn();
            return $result;
        } catch (PDOException $e) {
            error_log("Query failed: " . $e->getMessage());
            return 0;
        }
    }
    
    public function getTotalLeaveCurrentYear($id) {
        try {
            $stmt = $this->pdo->prepare("SELECT SUM(`leave_day_count`) as count FROM `leave_request`
                WHERE YEAR(`datetime_created`) = YEAR(NOW())
                AND status = 0 
                AND `leave_request_status` = 'accepted'
                AND user_id = :id;
            ");
            $stmt->execute([':id' => $id]);
            $result = $stmt->fetchColumn();
            return $result !== false ? $result : 0;
        } catch (PDOException $e) {
            error_log("Query failed: " . $e->getMessage());
            return 0;
        }
    }
    
  

    public function getAllRowsFromTableWhere($tableName, array $additionalConditions = []) {
        try {
            // Construct the WHERE clause with status = 0 and additional conditions
            $whereClause = "status = 0";
    
            if (!empty($additionalConditions)) {
                $whereClause .= " AND " . implode(' AND ', $additionalConditions);
            }
    
            // Prepare the SQL statement with the dynamic WHERE clause
            $sql = "SELECT * FROM $tableName WHERE $whereClause";
            $stmt = $this->pdo->prepare($sql);
    
            // Execute the query
            $stmt->execute();
    
            // Fetch the results as an associative array
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            return $result;
        } catch (PDOException $e) {
            // Handle query errors
            echo "Query failed: " . $e->getMessage();
        }
    }
    public function getAllRowsFromTableWhereGroup($tableName, array $additionalConditions = [], $groupBy = null) {
        try {
            // Construct the WHERE clause with status = 0 and additional conditions
            $whereClause = "status = 0";
    
            if (!empty($additionalConditions)) {
                $whereClause .= " AND " . implode(' AND ', $additionalConditions);
            }
    
            // Construct the GROUP BY clause if $groupBy is provided
            $groupByClause = "";
            if (!empty($groupBy)) {
                $groupByClause = " GROUP BY " . $groupBy;
            }
    
            // Prepare the SQL statement with the dynamic WHERE and GROUP BY clauses
            $sql = "SELECT * FROM $tableName WHERE $whereClause $groupByClause";
            $stmt = $this->pdo->prepare($sql);
    
            // Execute the query
            $stmt->execute();
    
            // Fetch the results as an associative array
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            return $result;
        } catch (PDOException $e) {
            // Handle query errors
            echo "Query failed: " . $e->getMessage();
        }
    }
    
    
    public function loginUser($email, $password) {
        try {
            // Sanitize and validate input
            $email = trim($email); // Trim whitespace
            // htmlentities is not needed here because parameter binding takes care of SQL injection risks
    
            // Prepare the SQL statement
            $stmt = $this->pdo->prepare("SELECT * FROM users
             WHERE email = :email AND status = 0 AND role != 'applicant'");
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
    
            // Fetch the user
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if ($user) {
                // Use password_verify to check the hashed password
                if (password_verify($password, $user['password'])) {
                    // Set session variables securely
                    $_SESSION['role'] = $user['role'];
                    $_SESSION['id'] = $user['id'];
                    // Regenerate session ID to prevent session fixation
                    session_regenerate_id(true);
    
                    return true; // Login successful
                }
            }
    
            return false; // Login failed
    
        } catch (PDOException $e) {
            // Log the error message internally
            error_log("Login query failed: " . $e->getMessage());
    
            // Return a generic error message
            return false;
        }
    }
    
    

    
    public function insertData($tableName, $data) {
        try {
            foreach ($data as $key => $value) {
                $data[$key] = trim(htmlentities($value));
            }

            $columns = implode(', ', array_keys($data));
            $placeholders = ':' . implode(', :', array_keys($data));
            
            $sql = "INSERT INTO $tableName ($columns) VALUES ($placeholders)";
            $stmt = $this->pdo->prepare($sql);
            
            foreach ($data as $key => $value) {
                $stmt->bindValue(':' . $key, $value);
            }
            
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo $e;
        }
    }

    public function getLastInsertId() {
        return $this->pdo->lastInsertId();
    }

    public function updateData($tableName, $data, $whereConditions) {
        try {
            $setClause = '';
            foreach ($data as $key => $value) {
                $setClause .= "$key = :$key, ";
            }
            // Remove the trailing comma and space from the setClause
            $setClause = rtrim($setClause, ', ');
    
            $whereClause = '';
            foreach ($whereConditions as $whereKey => $whereValue) {
                $whereClause .= "$whereKey = :where_$whereKey AND ";
            }
            // Remove the trailing "AND" from the whereClause
            $whereClause = rtrim($whereClause, ' AND ');
    
            $sql = "UPDATE $tableName SET $setClause WHERE $whereClause";
            $stmt = $this->pdo->prepare($sql);
    
            foreach ($data as $key => $value) {
                $stmt->bindValue(':' . $key, $value);
            }
    
            foreach ($whereConditions as $whereKey => $whereValue) {
                $stmt->bindValue(':where_' . $whereKey, $whereValue);
            }
    
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return false;
            // You can log or handle the error here.
        }
    }
    
    
    
    public function getIdByColumnValue($tableName, $columnName, $columnValue, $idColumnName) {
    // Example usage 
    // $image =($db->getIdByColumnValue('tableName', 'id',$_GET['post'],'image')
        try {
            $stmt = $this->pdo->prepare("SELECT $idColumnName FROM $tableName WHERE $columnName = :column_value");
            $stmt->bindParam(':column_value', $columnValue);
            $stmt->execute();
            
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($result) {
                return $result[$idColumnName];
            } else {
                return null; // Entry not found
            }
        } catch (PDOException $e) {
            // echo "Error retrieving ID: " . $e->getMessage();
            return null;
        }
    }
    public function getCountByConditions($tableName, $conditions) {
        try {
            $sql = "SELECT COUNT(*) as count FROM $tableName";
    
            if (!empty($conditions)) {
                $sql .= " WHERE ";
                $whereConditions = [];
    
                foreach ($conditions as $column => $value) {
                    $whereConditions[] = "$column = :$column";
                }
    
                $sql .= implode(" AND ", $whereConditions);
            }
    
            $stmt = $this->pdo->prepare($sql);
    
            foreach ($conditions as $column => $value) {
                $stmt->bindParam(":$column", $value);
            }
    
            $stmt->execute();
            $count = $stmt->fetchColumn();
    
            return $count;
        } catch (PDOException $e) {
            // Handle the exception as needed
            return null;
        }
    }
    
    public function getAllColumnsByColumnValue($tableName, $columnName, $columnValue) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM $tableName WHERE $columnName = :column_value");
            $stmt->bindParam(':column_value', $columnValue);
            $stmt->execute();
            
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($result) {
                return $result;
            } else {
                return null; // Entry not found
            }
        } catch (PDOException $e) {
            // Handle the exception here
            return null;
        }
    }
    public function getAllColumns($tableName) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM $tableName WHERE status = 0");
            $stmt->execute();
            
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($result) {
                return $result;
            } else {
                return null; // Entry not found
            }
        } catch (PDOException $e) {
            // Handle the exception here
            return null;
        }
    }

    
}


?>
