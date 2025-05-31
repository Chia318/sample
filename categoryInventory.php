<?php
require_once 'includes/modelCategoryInventory.inc.php'; // This file should fetch roles from the database
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link rel="icon" href="./image/logo.png">
  <title>Inventory</title>
  <link rel="stylesheet" href="styles/dashboard.css">

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Boxicons -->
  <link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
</head>
<body>

<aside class="side-navbar">
  <div class="text-center fw-bold mb-4">
    <img src="image/logo.png" alt="Company Logo" class="img-fluid" style="max-width: 150px; height: auto;">
  </div>
  <ul class="nav flex-column">
    <li class="nav-item"><a href="main.html" class="nav-link"><i class="bx bx-bar-chart-square"></i>Dashboard</a></li>
    <!--INVENTORY-->
    <li class="nav-item">
      <a href="#" class="nav-link" data-bs-toggle="collapse" data-bs-target="#inventoryMenu" aria-expanded="true"><i class="bx bx-package"></i>Inventory Management</a></li>
        <div class="collapse" id="inventoryMenu">
          <ul class="list-unstyled ps-3">
            <li><a href="inventory.php" class="nav-link">Item</a></li>
            <li><a href="categoryInventory.php" class="nav-link">Category</a></li>
          </ul>
        </div>
      </li>
    <!--INVENTORY COMPLETED-->
    <li class="nav-item"><a href="#" class="nav-link"><i class="bx bx-bell"></i>Alert</a></li>
    <li class="nav-item"><a href="reportGeneration.html" class="nav-link"><i class="bx bx-file"></i>Report</a></li>
    <!--follow-->
    <li class="nav-item">
      <a href="#" class="nav-link" data-bs-toggle="collapse" data-bs-target="#donationMenu"><i class="bx bx-donate-heart"></i>Donation</a>
      <div class="collapse" id="donationMenu">
        <ul class="list-unstyled ps-3">
          <li><a href="#" class="nav-link">Order</a></li>
        </ul>
      </div>
    </li>
    <!---->
    <li class="nav-item">
      <a href="#" class="nav-link" data-bs-toggle="collapse" data-bs-target="#administrationMenu" aria-expanded="true">
        <i class="bx bx-cog"></i> Administration
      </a>
      <div class="collapse show" id="administrationMenu">
        <ul class="list-unstyled ps-3">
          <li><a href="./userManagement.php" class="nav-link active">User</a></li>
          <li><a href="./roleManagement.php" class="nav-link">Role</a></li>
          <li><a href="#" class="nav-link">Permission</a></li>
          <li><a href="#" class="nav-link">Setting</a></li>
        </ul>
      </div>
    </li>
  </ul>
</aside>

<div class="main-content">
  <div class="header">
    <div class="left"><h4>Category</h4></div>
    <div class="right"><div class="user">SUPERADMIN9999 <i class="bx bx-chevron-down"></i></div></div>
  </div>

  <div class="content" id="dashboardContent">
    <div class="breadcrumb">Dashboard / Inventory / Category</div>

    <div class="container mt-4">
      <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <div class="input-group" style="max-width: 300px;">
          <span class="input-group-text"><i class="bx bx-search"></i></span>
          <input type="text" id="categorySearch" class="form-control" placeholder="Search Category...">
        </div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
          <i class="bx bx-plus"></i> Add Category
        </button>
      </div>

      <div class="table-responsive">
        <table class="table table-striped table-hover">
          <thead class="table-primary">
            <tr>
              <th>Category ID</th>
              <th>Category Name</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <!--这边需要更改，用来DISPLAY RESULT, php file as modelCategory-->
            <?php display_Category(); ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <footer class="footer mt-auto py-3 bg-light">
    <div class="container text-center"><span class="text-muted">© 2025 All rights reserved.</span></div>
  </footer>
</div>

<!-- Add Category Modal -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <form class="modal-content" action="includes/addCategory.inc.php" method="POST">
      <div class="modal-header">
        <h5 class="modal-title">Add New Category</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label for="CategoryName" class="form-label">Category Name</label>
          <input type="text" class="form-control" id="CategoryName" name="CategoryName" required>
        </div>        
      </div>        
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Add</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
      </div>
    </form>
  </div>
</div>

<!-- Edit Category Modal -->
<div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <form class="modal-content" action="includes/editCategory.inc.php" method="POST">
      <div class="modal-header">
        <h5 class="modal-title">Edit Category</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="editCategoryID" name="CategoryID">
        <div class="mb-3">
          <label for="editCategoryName" class="form-label">Category Name</label>
          <input type="text" class="form-control" id="editCategoryName" name="CategoryName" required>
        </div>

      <div class="modal-footer">
        <button type="submit" class="btn btn-warning">Update Category</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
      </div>
    </form>
  </div>
</div>

<!-- JavaScript -->
<script>
  // Use event delegation to handle clicks for dynamically generated buttons
  document.addEventListener('click', (event) => {
    if (event.target.classList.contains('editCategoryBtn')) {
        const button = event.target;
        console.log("Category Name:", document.getElementById("editCategoryName").value);      

        document.getElementById('editCategoryID').value = button.getAttribute('data-category-id');
        document.getElementById('editCategoryName').value = button.getAttribute('data-Category-name');
        
        // Open the modal
        const modal = new bootstrap.Modal(document.getElementById('editCategoryModal'));
        modal.show();
    }
  });

  // Delete role
  function deleteCategory(CategoryID) {
    if (confirm("Please confirm the deletion Category?")) {
      fetch('includes/deleteCategory.inc.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams({ 'CategoryID': CategoryID })
      })
      .then(response => response.text())
      .then(result => {
        console.log("Server response:", result);
        if (result === "success") {
          alert("Category has been deleted.");
          location.reload();
        } else {
          alert("Category has not delete: " + result);
        }
      })
      .catch(error => {
        console.error("Error:", error);
        alert("An error occurred while deleting the Category.");
      });
    }
  }

  // Filter roles
  document.getElementById('categorySearch').addEventListener('input', function () {
    const searchValue = this.value.toLowerCase();
    const rows = document.querySelectorAll('tbody tr');

    rows.forEach(row => {
      const Category = row.textContent.toLowerCase();
      row.style.display = Category.includes(searchValue) ? '' : 'none';
    });
  });
</script>

</body>
</html>
