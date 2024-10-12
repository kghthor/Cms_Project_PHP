<?php
namespace Project\Cms;

use Config\Database;
use mysqli;
// Enable error reporting

class AdminController {
    private $db;

    public function __construct() {
        $this->db = new \Config\Database();
    }

    public function login() {
        session_start();
    
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Get username and password from POST request
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
    
            // Prepare the SQL statement to get the user record
            $stmt = $this->db->getConnection()->prepare("SELECT * FROM cms_user WHERE username = ? AND deleted = 0");
            if ($stmt === false) {
                die('Prepare failed: ' . htmlspecialchars($this->db->getConnection()->error));
            }
    
            // Bind parameters and execute
            $stmt->bind_param('s', $username);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($user = $result->fetch_assoc()) {
                // Verify the password
                if (password_verify($password, $user['password'])) {
                    // Password is correct, start session and store user info
                    $_SESSION['username'] = $username;
                    $_SESSION['type'] = $user['type']; // Store user type
                    $_SESSION['user_id'] = $user['id']; // Store user ID
                    
                    header("Location: ?url=welcome");
                    exit;
                } else {
                    // Password is incorrect
                    $error = "Invalid username or password.";
                }
            } else {
                // User not found
                $error = "Invalid username or password.";
            }
    
            // Include the login view with the error message
            include 'views/login.php';
            exit;
        } else {
            // Display login form
            include 'views/login.php';
        }
    }
    
    

    public function welcome() {
        // Start session
        session_start();
    
        // Check if the user is logged in
        if (!isset($_SESSION['username']) || !isset($_SESSION['type'])) {
            die('Permission not allowed.');
        }
    
        $conn = $this->db->getConnection();
    
        // Fetch total users
        $stmt = $conn->prepare("SELECT COUNT(*) AS total_users FROM cms_user");
        $stmt->execute();
        $total_users = $stmt->get_result()->fetch_assoc()['total_users'];
    
        // Fetch total posts
        $stmt = $conn->prepare("SELECT COUNT(*) AS total_posts FROM cms_posts WHERE is_delete = 0");
        $stmt->execute();
        $total_posts = $stmt->get_result()->fetch_assoc()['total_posts'];
    
        // Fetch total categories
        $stmt = $conn->prepare("SELECT COUNT(*) AS total_categories FROM cms_category");
        $stmt->execute();
        $total_categories = $stmt->get_result()->fetch_assoc()['total_categories'];
    
        // Include the view with the fetched data
        include 'views/welcome.php';  
    }
    

    public function logout() {
        session_start();
        session_unset();
        session_destroy();
        header("Location: ?url=login");
        exit;
    }

    public function create_admin() {
        $db = new Database();
        $conn = $db->getConnection();

        // Check if an admin user already exists
        $stmt = $conn->prepare("SELECT COUNT(*) AS count FROM cms_user WHERE type = 1");
        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($conn->error));
        }
        $stmt->execute();
        $result = $stmt->get_result();  // Use get_result to fetch data
        $row = $result->fetch_assoc();

        if ($row['count'] > 0) {
            // Admin already exists, so exit
            echo "Admin user has already been created. This is a one-time process.";
            $stmt->close();  // Close the statement
            return;
        }

        // Proceed with creating the admin user
        $username = 'superuser';
        $password = password_hash('Admin@123', PASSWORD_BCRYPT); // Securely hash the password

        $stmt = $conn->prepare("INSERT INTO cms_user (first_name, last_name, username, password, type, deleted) VALUES (?, ?, ?, ?, 1, 0)");
        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($conn->error));
        }

        // Bind parameters
        $firstName = 'cms';
        $lastName = 'admin';
        $stmt->bind_param('ssss', $firstName, $lastName, $username, $password);
        $stmt->execute();

        echo "Admin user created successfully.";
        $stmt->close();  // Close the statement
    }

    public function create_user() {
        session_start();  // Start a new session or resume the existing one
    
        // Check if user is logged in and is an admin
        if (!isset($_SESSION['username']) || $_SESSION['type'] != 1) {
            // If not logged in or not an admin, show an alert and redirect to the welcome page
            echo "<script>alert('No permission to access this page.'); window.location.href='?url=welcome';</script>";
            exit();  // Stop executing the rest of the code
        }
    
        // Check if the request method is POST (i.e., form submission)
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Retrieve form data, or set them to empty if not provided
            $firstName = $_POST['first_name'] ?? '';
            $lastName = $_POST['last_name'] ?? '';
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            $email = $_POST['email'] ?? '';
    
            $errors = [];  // Initialize an array to store validation errors
    
            // Validation checks for required fields and email format
            if (empty($firstName)) $errors[] = 'First name is required.';
            if (empty($lastName)) $errors[] = 'Last name is required.';
            if (empty($username)) $errors[] = 'Username is required.';
            if (empty($password)) $errors[] = 'Password is required.';
            if (empty($email)) $errors[] = 'Email is required.';
            else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Invalid email format.';
    
            // If no validation errors
            if (empty($errors)) {
                $conn = $this->db->getConnection();  // Get a database connection
    
                // Check if the username already exists in the database
                $stmt = $conn->prepare("SELECT COUNT(*) AS count FROM cms_user WHERE username = ?");
                $stmt->bind_param('s', $username);  // Bind the username parameter
                $stmt->execute();  // Execute the query
                $result = $stmt->get_result();  // Get the result set
                $row = $result->fetch_assoc();  // Fetch the result as an associative array
    
                if ($row['count'] > 0) {
                    // If username exists, add error message
                    $errors[] = 'Username already exists.';
                } else {
                    // Check if the email already exists in the database
                    $stmt = $conn->prepare("SELECT COUNT(*) AS count FROM cms_user WHERE email = ?");
                    $stmt->bind_param('s', $email);  // Bind the email parameter
                    $stmt->execute();  // Execute the query
                    $result = $stmt->get_result();  // Get the result set
                    $row = $result->fetch_assoc();  // Fetch the result as an associative array
    
                    if ($row['count'] > 0) {
                        // If email exists, add error message
                        $errors[] = 'Email already exists.';
                    } else {
                        // Hash the password for security
                        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    
                        // Insert the new user into the database
                        $stmt = $conn->prepare(
                            "INSERT INTO cms_user (first_name, last_name, username, password, email, type, deleted) 
                             VALUES (?, ?, ?, ?, ?, 0, 0)"
                        );
                        $stmt->bind_param('sssss', $firstName, $lastName, $username, $hashedPassword, $email);  // Bind parameters
                        $stmt->execute();  // Execute the insert query
    
                        // Return success message in JSON format
                        echo json_encode(['success' => 'User created successfully.']);
                        exit;  // Stop executing the rest of the code
                    }
                }
            }
    
            // Return validation errors in JSON format
            echo json_encode(['errors' => $errors]);
            exit;  // Stop executing the rest of the code
        }
    
        include 'views/create_user.php';  // Load the create user view
    }
    
    

    public function manage_users() {
        session_start();
    
        // Check if user is logged in and is an admin
        if (!isset($_SESSION['username']) || $_SESSION['type'] != 1) {
            echo "<script>alert('No permission to access this page.'); window.location.href='?url=welcome';</script>";
            exit();
        }
        
        $conn = $this->db->getConnection();
    
        // Handle search input
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        $limit = 5; // Number of users per page
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $start = ($page - 1) * $limit;
    
        // Adjust the SQL query based on search input
        if ($search) {
            $stmt = $conn->prepare("SELECT SQL_CALC_FOUND_ROWS * FROM cms_user WHERE username LIKE ? OR email LIKE ? LIMIT ?, ?");
            $searchTerm = "%$search%";
            $stmt->bind_param('ssii', $searchTerm, $searchTerm, $start, $limit);
        } else {
            $stmt = $conn->prepare("SELECT SQL_CALC_FOUND_ROWS * FROM cms_user LIMIT ?, ?");
            $stmt->bind_param('ii', $start, $limit);
        }
    
        $stmt->execute();
        $result = $stmt->get_result();
        $users = $result->fetch_all(MYSQLI_ASSOC);
    
        // Get the total number of users
        $result = $conn->query("SELECT FOUND_ROWS() as total");
        $totalUsers = $result->fetch_assoc()['total'];
        $totalPages = ceil($totalUsers / $limit);
    
        include 'views/manage_users.php'; // Load the manage users view
    }
    
    
    
    
    
    
    public function fetch_user() {
        $id = $_GET['id'];
        $conn = $this->db->getConnection();
    
        $stmt = $conn->prepare("SELECT * FROM cms_user WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
    
        echo json_encode($user);
    }
    
    public function update_user() {
        $conn = $this->db->getConnection();
    
        $id = $_POST['id'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $type = $_POST['type'];
    
        $stmt = $conn->prepare("UPDATE cms_user SET first_name = ?, last_name = ?, username = ?, email = ?, type = ? WHERE id = ?");
        $stmt->bind_param('ssssii', $first_name, $last_name, $username, $email, $type, $id);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
    }
    
    public function delete_user() {
        $conn = $this->db->getConnection();
    
        $id = $_POST['id'];
        
        $stmt = $conn->prepare("DELETE FROM cms_user WHERE id = ?");
        $stmt->bind_param('i', $id);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
    }
    
    public function manage_cat() {
        session_start();
        
        // Check if user is logged in and is an admin
        if (!isset($_SESSION['username']) || $_SESSION['type'] != 1) {
            echo "<script>alert('No permission to access this page.'); window.location.href='?url=welcome';</script>";
            exit();
        }
        
        $conn = $this->db->getConnection();
    
        // Handle POST request for adding/editing categories
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $catName = $_POST['name'] ?? '';
            $catId = $_POST['id'] ?? null;
    
            if (!empty($catName)) {
                if ($catId) {
                    // Update category
                    $stmt = $conn->prepare("UPDATE cms_category SET name = ? WHERE id = ?");
                    $stmt->bind_param('si', $catName, $catId);
                } else {
                    // Add new category
                    $stmt = $conn->prepare("INSERT INTO cms_category (name) VALUES (?)");
                    $stmt->bind_param('s', $catName);
                }
                $stmt->execute();
                header('Location: ?url=mcat');
                exit();
            }
        }
    
        // Handle DELETE request
        if (isset($_GET['delete'])) {
            $catId = $_GET['delete'];
            $stmt = $conn->prepare("DELETE FROM cms_category WHERE id = ?");
            $stmt->bind_param('i', $catId);
            $stmt->execute();
            header('Location: ?url=mcat');
            exit();
        }
    
        // Fetch all categories
        $result = $conn->query("SELECT * FROM cms_category");
        $categories = $result->fetch_all(MYSQLI_ASSOC);
        include 'views/manage_cat.php'; // Load the manage categories view
    }
    
    
    public function user_profile() {
        session_start();
        //Factory method to check the user_Profile.
        // Check if the user is logged in
        if (!isset($_SESSION['user_id'])) {
            die('Permission not allowed.');
        }
    
        $conn = $this->db->getConnection();
        $userid = $_SESSION['user_id'];
    
        // Factory Method: Create a function to fetch user details
        $getUserById = function($conn, $userid) {
            $stmt = $conn->prepare("SELECT username, first_name, last_name, email FROM cms_user WHERE id = ?");
            $stmt->bind_param("i", $userid);
            $stmt->execute();
            return $stmt->get_result()->fetch_assoc();
        };
    
        // Factory Method: Create a function to verify password
        $verifyPassword = function($conn, $userid, $password) {
            $stmt = $conn->prepare("SELECT password FROM cms_user WHERE id = ?");
            $stmt->bind_param("i", $userid);
            $stmt->execute();
            $stored_password = $stmt->get_result()->fetch_assoc()['password'];
            return password_verify($password, $stored_password);
        };
    
        // Factory Method: Create a function to update user profile
        $updateUserProfile = function($conn, $userid, $firstName, $lastName, $newPassword = null) {
            // Update first name and last name
            $stmt = $conn->prepare("UPDATE cms_user SET first_name = ?, last_name = ? WHERE id = ?");
            $stmt->bind_param("ssi", $firstName, $lastName, $userid);
            $stmt->execute();
    
            // Update password if provided
            if (!empty($newPassword)) {
                $hashed_password = password_hash($newPassword, PASSWORD_DEFAULT);
                $stmt = $conn->prepare("UPDATE cms_user SET password = ? WHERE id = ?");
                $stmt->bind_param("si", $hashed_password, $userid);
                $stmt->execute();
            }
        };
    
        // Fetch the current user's details using the Factory Method
        $user = $getUserById($conn, $userid);
    
        // Check if the form has been submitted
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $current_password = $_POST['current_password'];
            $new_password = $_POST['new_password'];
            $first_name = $_POST['first_name'];
            $last_name = $_POST['last_name'];
    
            // Verify the current password using the Factory Method
            if ($verifyPassword($conn, $userid, $current_password)) {
                // Update user profile using the Factory Method
                $updateUserProfile($conn, $userid, $first_name, $last_name, $new_password);
    
                $success_message = "Profile updated successfully!";
            } else {
                $error_message = "Current password is incorrect.";
            }
        }
    
        include 'views/user_profile.php';
    }
    

    public function manage_article() {
        session_start();
        
        $conn = $this->db->getConnection();
        $user_id = $_SESSION['user_id'];
        $user_type = $_SESSION['type'];
        
        // Pagination setup
        $itemsPerPage = 5; // Number of items per page
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $currentPage = max($currentPage, 1); // Ensure page number is at least 1
        
        // Handle POST request for update and delete actions
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $article_id = $_POST['article_id'] ?? null;
        
            if (isset($_POST['update'])) {
                $title = $_POST['title'] ?? '';
                $message = $_POST['message'] ?? '';
                $status = $_POST['status'] ?? 'published';
                $category_id = $_POST['category_id'] ?? null;
                $updated = date('Y-m-d');
        
                $image = $_FILES['image']['name'] ?? '';
                $folder = __DIR__ . '/../postpics/';
                $image_path = '';
        
                // Get existing image
                $stmt = $conn->prepare("SELECT image FROM cms_posts WHERE id = ?");
                $stmt->bind_param('i', $article_id);
                $stmt->execute();
                $result = $stmt->get_result();
                $existing_image = $result->fetch_assoc()['image'];
        
                if ($image) {
                    $imgext = strtolower(pathinfo($image, PATHINFO_EXTENSION));
                    $picture = rand(1000, 1000000) . '.' . $imgext;
                    $uploadFile = $folder . $picture;
                    if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                        $image_path = $picture;
                    } else {
                        die('Error uploading image.');
                    }
                } else {
                    // Use existing image if no new image is uploaded
                    $image_path = $existing_image;
                }
        
                $stmt = $conn->prepare("UPDATE cms_posts SET title = ?, message = ?, status = ?, category_id = ?, updated = ?, image = ? WHERE id = ?");
                $stmt->bind_param('ssssssi', $title, $message, $status, $category_id, $updated, $image_path, $article_id);
        
                if ($stmt->execute()) {
                    echo "<script>alert('Article updated successfully!'); window.location.href='?url=mart';</script>";
                } else {
                    die('Error: ' . htmlspecialchars($stmt->error));
                }
            }
        
            if (isset($_POST['delete'])) {
                $del_date = date('Y-m-d');
        
                // Mark the article as deleted
                $stmt = $conn->prepare("UPDATE cms_posts SET is_delete = 1, del_date = ? WHERE id = ?");
                $stmt->bind_param('si', $del_date, $article_id);
        
                if ($stmt->execute()) {
                    echo "<script>alert('Article deleted successfully!'); window.location.href='?url=mart';</script>";
                } else {
                    die('Error: ' . htmlspecialchars($stmt->error));
                }
            }
        }
        
        // Fetch all categories for the dropdown
        $category_stmt = $conn->prepare("SELECT id, name FROM cms_category");
        $category_stmt->execute();
        $categories_result = $category_stmt->get_result();
        $categories = $categories_result->fetch_all(MYSQLI_ASSOC);
        
        // Calculate the total number of articles
        if ($user_type == 1) {
            // Admin can see all posts
            $count_stmt = $conn->prepare("SELECT COUNT(*) as total FROM cms_posts WHERE is_delete = 0");
        } else {
            // Regular users can only see their own posts
            $count_stmt = $conn->prepare("SELECT COUNT(*) as total FROM cms_posts WHERE userid = ? AND is_delete = 0");
            $count_stmt->bind_param('i', $user_id);
        }
        
        $count_stmt->execute();
        $count_result = $count_stmt->get_result();
        $total_articles = $count_result->fetch_assoc()['total'];
        $totalPages = ceil($total_articles / $itemsPerPage);
        
        // Fetch articles with pagination
        $offset = ($currentPage - 1) * $itemsPerPage;
        
        if ($user_type == 1) {
            // Admin can see all posts
            $stmt = $conn->prepare("SELECT cms_posts.*, cms_user.username, cms_category.name as category_name FROM cms_posts JOIN cms_user ON cms_posts.userid = cms_user.id JOIN cms_category ON cms_posts.category_id = cms_category.id WHERE is_delete = 0 LIMIT ? OFFSET ?");
            $stmt->bind_param('ii', $itemsPerPage, $offset);
        } else {
            // Regular users can only see their own posts
            $stmt = $conn->prepare("SELECT cms_posts.*, cms_user.username, cms_category.name as category_name FROM cms_posts JOIN cms_user ON cms_posts.userid = cms_user.id JOIN cms_category ON cms_posts.category_id = cms_category.id WHERE cms_posts.userid = ? AND is_delete = 0 LIMIT ? OFFSET ?");
            $stmt->bind_param('iii', $user_id, $itemsPerPage, $offset);
        }
        
        $stmt->execute();
        $result = $stmt->get_result();
        $articles = $result->fetch_all(MYSQLI_ASSOC);
        if (isset($_POST['remove_image'])) {
            // Get the article ID
            $article_id = $_POST['article_id'] ?? null;
            
            // Get the current image from the database
            $stmt = $conn->prepare("SELECT image FROM cms_posts WHERE id = ?");
            $stmt->bind_param('i', $article_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $current_image = $result->fetch_assoc()['image'];
        
            if ($current_image) {
                // Delete the image file from the directory
                $image_path = __DIR__ . '/../postpics/' . $current_image;
                if (file_exists($image_path)) {
                    unlink($image_path);
                }
        
                // Update the database to remove the image
                $stmt = $conn->prepare("UPDATE cms_posts SET image = '' WHERE id = ?");
                $stmt->bind_param('i', $article_id);
                $stmt->execute();
            }
        
            echo "<script>alert('Image removed successfully!'); window.location.href='?url=mart';</script>";
        }
        
        // Include the view to render the articles
        include 'views/manage_article.php';
    }
    
    
    
    
    public function blog_view() {
        session_start();
    
        // Check if the user is logged in
        if (!isset($_SESSION['username']) || !isset($_SESSION['type'])) {
            die('Permission not allowed.');
        }
    
        $conn = $this->db->getConnection();
        $user_id = $_SESSION['user_id'];
        $user_type = $_SESSION['type'];
        $posts_per_page = 5;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $posts_per_page;
    
        // Filtering parameters
        $category_filter = isset($_GET['category']) ? (int)$_GET['category'] : null;
        $status_filter = isset($_GET['status']) ? $_GET['status'] : null;
        $start_date_filter = isset($_GET['start_date']) ? $_GET['start_date'] : null;
        $end_date_filter = isset($_GET['end_date']) ? $_GET['end_date'] : null;
    
        // Base query
        $query = "SELECT cms_posts.*, cms_user.username, cms_user.email, cms_category.name AS category_name FROM cms_posts 
                  JOIN cms_user ON cms_posts.userid = cms_user.id 
                  JOIN cms_category ON cms_posts.category_id = cms_category.id 
                  WHERE is_delete = 0";
    
        if ($user_type == 1) {
            // Admin: fetch all archived, published, and rejected posts
            $query .= " AND status IN ('published', 'archived', 'rejected')";
        } else {
            // Regular user: fetch only their archived, published, and rejected posts
            $query .= " AND cms_posts.userid = $user_id AND status IN ('published', 'archived', 'rejected')";
        }
    
        // Apply filters
        if ($category_filter) {
            $query .= " AND cms_posts.category_id = $category_filter";
        }
        if ($status_filter) {
            $query .= " AND cms_posts.status = '$status_filter'";
        }
        if ($start_date_filter && $end_date_filter) {
            $query .= " AND cms_posts.created BETWEEN '$start_date_filter' AND '$end_date_filter'";
        }
    
        $query .= " ORDER BY created DESC LIMIT $posts_per_page OFFSET $offset";
    
        $result = $conn->query($query);
        $posts = $result->fetch_all(MYSQLI_ASSOC);
    
        // Get the total number of posts for pagination
        $count_query = "SELECT COUNT(*) as total FROM cms_posts WHERE is_delete = 0";
        if ($user_type == 1) {
            $count_query .= " AND status IN ('published', 'archived', 'rejected')";
        } else {
            $count_query .= " AND userid = $user_id AND status IN ('published', 'archived', 'rejected')";
        }
        if ($category_filter) {
            $count_query .= " AND category_id = $category_filter";
        }
        if ($status_filter) {
            $count_query .= " AND status = '$status_filter'";
        }
        if ($start_date_filter && $end_date_filter) {
            $count_query .= " AND created BETWEEN '$start_date_filter' AND '$end_date_filter'";
        }
    
        $count_result = $conn->query($count_query);
        $total_posts = $count_result->fetch_assoc()['total'];
        $total_pages = ceil($total_posts / $posts_per_page);
    
        // Fetch categories for filtering
        $categories_result = $conn->query("SELECT id, name FROM cms_category");
        $categories = $categories_result->fetch_all(MYSQLI_ASSOC);
    
        // Include the view to render the posts
        include 'views/blog_view.php';
    }
    


public function read_post() {
    session_start();

    // Check if the user is logged in
    if (!isset($_SESSION['username']) || !isset($_SESSION['type'])) {
        die('Permission not allowed.');
    }

    $conn = $this->db->getConnection();
    $post_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

    if ($post_id <= 0) {
        die('Invalid post ID.');
    }

    $stmt = $conn->prepare("SELECT cms_posts.*, cms_user.username, cms_user.email, cms_category.name AS category_name FROM cms_posts JOIN cms_user ON cms_posts.userid = cms_user.id JOIN cms_category ON cms_posts.category_id = cms_category.id WHERE cms_posts.id = ? AND is_delete = 0");
    $stmt->bind_param('i', $post_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $post = $result->fetch_assoc();

    if (!$post) {
        die('Post not found.');
    }

    include 'views/read_post.php';
}


public function create_article() {
    session_start();

    // Check if the user is logged in
    if (!isset($_SESSION['username']) || !isset($_SESSION['user_id'])) {
        die('Permission not allowed.');
    }

    $conn = $this->db->getConnection();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $title = $_POST['title'] ?? '';
        $message = $_POST['message'] ?? '';
        $category_id = $_POST['category_id'] ?? null;
        $status = $_POST['status'] ?? 'published'; // Get status from form
        $user_id = $_SESSION['user_id']; // Get user ID from session

        // Validate input
        if (empty($title) || empty($message) || !$category_id || !$user_id) {
            echo "<script>alert('Please fill all required fields.');</script>";
            return;
        }

        $created = date('Y-m-d'); // Current date for created field
        $updated = date('Y-m-d'); // Current date for updated field

        // Handle file upload
        $imageFileName = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
            $image = $_FILES['image']['name'];
            $ext = $_FILES['image']['type'];
            $validExt = array("image/gif", "image/jpeg", "image/pjpeg", "image/png");

            if ($_FILES['image']['size'] <= 0 || $_FILES['image']['size'] > 5 * 1024 * 1024) {
                echo "<script>alert('Image size is not proper. Maximum size is 5MB.');</script>";
                return;
            } elseif (!in_array($ext, $validExt)) {
                echo "<script>alert('Not a valid image. Accepted types: gif, jpeg, png.');</script>";
                return;
            } else {
                // Define the absolute path
                define('SITE_ROOT', realpath(dirname(__FILE__)));
                $folder = SITE_ROOT . '/../postpics/';
                $imgext = strtolower(pathinfo($image, PATHINFO_EXTENSION));
                $picture = rand(1000, 1000000) . '.' . $imgext;
                $uploadFile = $folder . $picture;

                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                    $imageFileName = $picture;
                } else {
                    echo "<script>alert('Error: Failed to upload image. Please check the directory permissions. Path used: " . htmlspecialchars($uploadFile) . "');</script>";
                    return;
                }
            }
        }

        // Prepare the SQL statement to insert the article
        $stmt = $conn->prepare("INSERT INTO cms_posts (title, message, category_id, userid, status, created, updated, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

        // Bind parameters
        $stmt->bind_param('ssisssss', $title, $message, $category_id, $user_id, $status, $created, $updated, $imageFileName);

        if ($stmt->execute()) {
            echo "<script>alert('Article created successfully! Send For Approval'); window.location.href='?url=mart';</script>";
        } else {
            echo "<script>alert('Error: " . htmlspecialchars($stmt->error) . "');</script>";
        }
    }

    // Fetch categories for the dropdown
    $result = $conn->query("SELECT * FROM cms_category");
    $categories = $result->fetch_all(MYSQLI_ASSOC);

    // Include the view to render the form
    include 'views/create_article.php';
}







}
?>
