<?php
/**
 * Post model.
 *
 * Handles all database interactions for the posts table.
 */
class Post {
    private Database $db;

    public function __construct() {
        $this->db = new Database();
    }

    /**
     * Retrieves all posts from the database.
     *
     * @return array<object> Array of post objects
     */
    public function getPosts(): array {
        $this->db->query('SELECT * FROM posts');
        return $this->db->resultSet();
    }
}
