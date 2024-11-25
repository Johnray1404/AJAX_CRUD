<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .form-container {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        .loading-spinner {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1000;
        }
        .table-container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        .btn-action {
            margin: 2px;
        }
        #alertContainer {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
        }
    </style>
</head>

<?php
require 'conn.php';

$search = $_GET['search'] ?? '';
$page = $_GET['page'] ?? 1;
$limit = 10;
$offset = ($page - 1) * $limit;

$total_stmt = $pdo->prepare("SELECT COUNT(*) FROM jmc_users WHERE jmc_last_name LIKE ? OR jmc_first_name LIKE ?");
$total_stmt->execute(["%$search%", "%$search%"]);
$total_rows = $total_stmt->fetchColumn();

$stmt = $pdo->prepare("SELECT * FROM jmc_users WHERE jmc_last_name LIKE ? OR jmc_first_name LIKE ? LIMIT ? OFFSET ?");
$stmt->execute(["%$search%", "%$search%", $limit, $offset]);
$user = $stmt->fetchAll();

$total_pages = ceil($total_rows / $limit);
?>

<body>
    <div class="container mt-4">
        <h1 class="text-center mb-4">User Management System</h1>
        
        <!-- Alert Container -->
        <div id="alertContainer"></div>

        <!-- Loading Spinner -->
        <div id="loadingSpinner" class="loading-spinner">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>

        <!-- Create Form -->
        <div class="form-container" id="createForm">
            <h3>Add New User</h3>
            <form id="createUserForm">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="lname" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="lname" name="lname" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="fname" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="fname" name="fname" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="gender" class="form-label">Gender</label>
                    <select class="form-select" id="gender" name="gender" required>
                        <option value="">Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <textarea class="form-control" id="address" name="address" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary" id="createSubmitBtn">
                    <i class="fas fa-plus"></i> Add User
                </button>
            </form>
        </div>

        <!-- Update Form -->
        <div class="form-container" id="updateForm">
            <h3>Update User</h3>
            <form id="updateUserForm">
                <input type="hidden" id="updateUserId" name="id">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="updateLname" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="updateLname" name="lname" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="updateFname" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="updateFname" name="fname" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="updateEmail" class="form-label">Email</label>
                    <input type="email" class="form-control" id="updateEmail" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="updateGender" class="form-label">Gender</label>
                    <select class="form-select" id="updateGender" name="gender" required>
                        <option value="">Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="updateAddress" class="form-label">Address</label>
                    <textarea class="form-control" id="updateAddress" name="address" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary" id="updateSubmitBtn">
                    <i class="fas fa-save"></i> Update User
                </button>
                <button type="button" class="btn btn-secondary" id="showAddForm">
                    <i class="fas fa-plus"></i> Add New Instead
                </button>
            </form>
        </div>

        <!-- Users Table -->
        <div class="table-container">
            <table class="table table-striped table-hover" id="usersTable">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Last Name</th>
                        <th>First Name</th>
                        <th>Email</th>
                        <th>Gender</th>
                        <th>Address</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Table content will be loaded dynamically -->
                    <?php foreach ($user as $row): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['jmc_last_name'] ?></td>
                        <td><?= $row['jmc_first_name'] ?></td>
                        <td><?= $row['jmc_email'] ?></td>
                        <td><?= $row['jmc_gender'] ?></td>
                        <td><?= $row['jmc_address'] ?></td>
                        <td>
                            <button class="btn btn-primary btn-sm edit-user" data-id="<?= $row['id'] ?>">Edit</button>
                            <button class="btn btn-danger btn-sm delete-user" data-id="<?= $row['id'] ?>">Delete</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination (if needed) -->
        <div class="d-flex justify-content-between">
            <button class="btn btn-secondary" <?= ($page == 1) ? 'disabled' : '' ?> onclick="location.href='?page=<?= $page - 1 ?>&search=<?= $search ?>'">Previous</button>
            <button class="btn btn-secondary" <?= ($page == $total_pages) ? 'disabled' : '' ?> onclick="location.href='?page=<?= $page + 1 ?>&search=<?= $search ?>'">Next</button>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= site_url('assets/js/crud.js') ?>"></script>
</body>
</html>
