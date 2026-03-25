<?php
/**
 * Pages controller.
 *
 * Handles general page routes such as the homepage and the about page.
 */
class Pages extends Controller {
    private Post $postModel;

    public function __construct() {
        $this->postModel = $this->model('Post');
    }

    /**
     * Renders the homepage with a list of all posts.
     */
    public function index(): void {
        $posts = $this->postModel->getPosts();

        $data = [
            'title' => 'Welcome',
            'posts' => $posts,
        ];

        $this->view('pages/index', $data);
    }

    /**
     * Renders the about page.
     */
    public function about(): void {
        $data = [
            'title' => 'About',
        ];

        $this->view('pages/about', $data);
    }

    /**
     * Renders the edit page for a specific post.
     *
     * @param string $id The ID of the post to edit
     */
    public function edit(string $id): void {
    }
}
