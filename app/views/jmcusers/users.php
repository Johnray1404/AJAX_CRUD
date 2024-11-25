<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .loading-spinner {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 9999;
        }
        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 9998;
        }
    </style>
</head>
<body>

<div class="container mt-4">
    <div id="alertContainer"></div>
    <div class="row">
        <div class="col-md-12">
            <h2 class="mb-4">User Management System</h2>
            <button class="btn btn-primary mb-3" id="showAddForm">Add New User</button>
        </div>
    </div>

    <!-- Create Form -->
    <div class="row mb-4" id="createForm" style="display: none;">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Add New User</h5>
                </div>
                <div class="card-body">
                    <form id="addUserForm">
                        <div class="mb-3">
                            <label for="lname" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="lname" name="lname" required>
                        </div>
                        <div class="mb-3">
                            <label for="fname" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="fname" name="fname" required>
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
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-secondary" id="cancelAdd">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Update Form -->
    <div class="row mb-4" id="updateForm" style="display: none;">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Update User</h5>
                </div>
                <div class="card-body">
                    <form id="updateUserForm">
                        <input type="hidden" id="updateUserId" name="updateUserId">
                        <div class="mb-3">
                            <label for="update_lname" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="update_lname" name="lname" required>
                        </div>
                        <div class="mb-3">
                            <label for="update_fname" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="update_fname" name="fname" required>
                        </div>
                        <div class="mb-3">
                            <label for="update_email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="update_email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="update_gender" class="form-label">Gender</label>
                            <select class="form-select" id="update_gender" name="gender" required>
                                <option value="">Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="update_address" class="form-label">Address</label>
                            <textarea class="form-control" id="update_address" name="address" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                        <button type="button" class="btn btn-secondary" id="cancelUpdate">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Users Table -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Users List</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
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
                            <tbody id="usersTableBody">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Loading Spinner and Overlay -->
<div class="loading-spinner">
    <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
</div>
<div class="overlay"></div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
$(document).ready(function() {
    // Load users on page load
    loadUsers();

    // Show/Hide Forms
    $('#showAddForm').click(function() {
        $('#createForm').slideDown();
        $('#updateForm').slideUp();
    });

    $('#cancelAdd').click(function() {
        $('#createForm').slideUp();
        $('#addUserForm')[0].reset();
    });

    $('#cancelUpdate').click(function() {
        $('#updateForm').slideUp();
        $('#updateUserForm')[0].reset();
    });

    // Add User
    $('#addUserForm').submit(function(e) {
        e.preventDefault();
        showLoading();
        
        $.ajax({
            url: '<?= site_url('user/add') ?>', // Backend URL
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                hideLoading();
                if(response.success) {
                    alert(response.message);
                    $('#createForm').slideUp();
                    $('#addUserForm')[0].reset();
                    loadUsers();
                } else {
                    alert(response.message);
                }
            },
            error: function() {
                hideLoading();
                alert('An error occurred');
            }
        });
    });

    // Update User
    $('#updateUserForm').submit(function(e) {
        e.preventDefault();
        showLoading();
        
        const id = $('#updateUserId').val();
        $.ajax({
            url: '<?= site_url('user/update') ?>', // Backend URL
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                hideLoading();
                if(response.success) {
                    alert(response.message);
                    $('#updateForm').slideUp();
                    $('#updateUserForm')[0].reset();
                    loadUsers();
                } else {
                    alert(response.message);
                }
            },
            error: function() {
                hideLoading();
                alert('An error occurred');
            }
        });
    });

    // Delete User
    $(document).on('click', '.delete-user', function() {
        if(confirm('Are you sure you want to delete this user?')) {
            const id = $(this).data('id');
            showLoading();
            
            $.ajax({
                url: '<?= site_url('user/delete/') ?>' + id, // Backend URL
                type: 'GET',
                success: function() {
                    hideLoading();
                    loadUsers();
                },
                error: function() {
                    hideLoading();
                    alert('An error occurred');
                }
            });
        }
    });

    // Edit User
    $(document).on('click', '.edit-user', function() {
        const id = $(this).data('id');
        showLoading();
        
        $.ajax({
            url: '<?= site_url('user/getOne/') ?>' + id, // Backend URL
            type: 'GET',
            success: function(response) {
                hideLoading();
                $('#updateUserId').val(response.id);
                $('#update_lname').val(response.jmc_last_name); // Corrected field name
                $('#update_fname').val(response.jmc_first_name); // Corrected field name
                $('#update_email').val(response.jmc_email); // Corrected field name
                $('#update_gender').val(response.jmc_gender); // Corrected field name
                $('#update_address').val(response.jmc_address); // Corrected field name
                
                $('#updateForm').slideDown();
                $('#createForm').slideUp();
            },
            error: function() {
                hideLoading();
                alert('An error occurred');
            }
        });
    });
});

// Load Users Function
function loadUsers() {
    showLoading();
    $.ajax({
        url: '<?= site_url('user/getUsers') ?>', // Backend URL
        type: 'GET',
        success: function(response) {
            hideLoading();
            $('#usersTableBody').html(response);
        },
        error: function() {
            hideLoading();
            alert('Error loading users');
        }
    });
}

// Loading Functions
function showLoading() {
    $('.loading-spinner, .overlay').show();
}

function hideLoading() {
    $('.loading-spinner, .overlay').hide();
}
</script>

</body>
</html>