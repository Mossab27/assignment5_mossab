<?php
class Database {
    private $host;
    private $username;
    private $password;
    private $database;
    private PDO $connection;
    private $mySqli;

    public function __construct($host, $username, $password, $database) {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;
        $this->connect();
    }

    private function connect() {
        try {
            $dsn = "mysql:host={$this->host};dbname={$this->database}";
            $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
            $this->connection = new PDO($dsn, $this->username, $this->password, $options);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function insert($tableName, $data) {
        $columns = implode(", ", array_keys($data));
        $values = ":" . implode(", :", array_keys($data));

        $sql = "INSERT INTO $tableName ($columns) VALUES ($values)";

        $statement = $this->connection->prepare($sql);

        foreach ($data as $key => $value) {
            $statement->bindValue(":$key", $value);
        }

        return $statement->execute();
    }

    public function select ($tableName, $condition = "") {
        $sql = "SELECT * FROM $tableName";
        if ($condition) {
            $sql .= " WHERE $condition";
        }

        $statement = $this->connection->query($sql);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update($tableName, $data, $condition) {
        $setClause = "";
        foreach ($data as $key => $value) {
            $setClause .= "$key = :$key, ";
        }
        $setClause = rtrim($setClause, ", ");

        $sql = "UPDATE $tableName SET $setClause WHERE $condition";

        $statement = $this->connection->prepare($sql);

        foreach ($data as $key => $value) {
            $statement->bindValue(":$key", $value);
        }

        return $statement->execute();
    }

    public function delete($tableName, $condition) {
        $sql = "DELETE FROM $tableName WHERE $condition";

        $statement = $this->connection->prepare($sql);

        return $statement->execute();
    }
    public function query_exexute($sql)
    {
        $result = $this->mySqli->query($sql);
        if (!$result) {
            throw new Exception($this->mySqli->error);
        }
        return $result;
    }

}
