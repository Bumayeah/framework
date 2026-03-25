<?php
/**
 * PDO database wrapper.
 *
 * Provides a simple interface around PDO for executing prepared statements
 * and retrieving results. Connection settings are read from the global
 * DB_* constants defined in config.php.
 */
class Database {
    private string $host = DB_HOST;
    private string $user = DB_USER;
    private string $pass = DB_PASS;
    private string $dbName = DB_NAME;

    private PDO $dbHandler;
    private PDOStatement $statement;
    private ?string $error = null;

    /**
     * Opens a persistent PDO connection to the database.
     *
     * @throws \RuntimeException When the connection cannot be established
     */
    public function __construct() {
        $dataSourceName = 'mysql:host=' . $this->host . ';dbname=' . $this->dbName;
        $options = [
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE    => PDO::ERRMODE_EXCEPTION,
        ];

        try {
            $this->dbHandler = new PDO($dataSourceName, $this->user, $this->pass, $options);
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            error_log('Database connection failed: ' . $this->error);
            throw new \RuntimeException('Database connection failed.');
        }
    }

    /**
     * Prepares a SQL statement for execution.
     *
     * @param string $sql The SQL query, optionally with named or positional placeholders
     */
    public function query(string $sql): void {
        $this->statement = $this->dbHandler->prepare($sql);
    }

    /**
     * Binds a value to a placeholder in the prepared statement.
     * Automatically detects the PDO parameter type when none is given.
     *
     * @param string|int $param The placeholder name (:name) or position (1-based)
     * @param mixed      $value The value to bind
     * @param int|null   $type  PDO::PARAM_* constant, or null for auto-detection
     */
    public function bind(string|int $param, mixed $value, int $type = null): void {
        $type ??= match (true) {
            is_bool($value) => PDO::PARAM_BOOL,
            is_int($value)  => PDO::PARAM_INT,
            is_null($value) => PDO::PARAM_NULL,
            default         => PDO::PARAM_STR,
        };

        $this->statement->bindValue($param, $value, $type);
    }

    /**
     * Executes the prepared statement.
     *
     * @return bool True on success, false on failure
     */
    public function execute(): bool {
        return $this->statement->execute();
    }

    /**
     * Executes the statement and returns all rows as an array of objects.
     *
     * @return array<object>
     */
    public function resultSet(): array {
        $this->execute();
        return $this->statement->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * Executes the statement and returns a single row as an object.
     *
     * @return object|false The row, or false when no row is found
     */
    public function single(): mixed {
        $this->execute();
        return $this->statement->fetch(PDO::FETCH_OBJ);
    }

    /**
     * Returns the number of rows affected by the last executed statement.
     *
     * @return int
     */
    public function rowCount(): int {
        return $this->statement->rowCount();
    }
}
