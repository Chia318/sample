<?php
require_once 'includes/modelInventory.inc.php'; // This file should fetch roles from the database
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
            <li><a href="inventory.php" class="nav-link">Inventory</a></li>
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
    <div class="left"><h4>Inventory</h4></div>
    <div class="right"><div class="user">SUPERADMIN9999 <i class="bx bx-chevron-down"></i></div></div>
  </div>

  <div class="content" id="dashboardContent">
    <div class="breadcrumb">Dashboard / Inventory Management Inventory</div>

    <div class="container mt-4">
      <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <div class="input-group" style="max-width: 300px;">
          <span class="input-group-text"><i class="bx bx-search"></i></span>
          <input type="text" id="itemSearch" class="form-control" placeholder="Search Inventory...">
        </div>
        
        <div class="d-flex gap-6"></div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#itemLogModal" >
          <i class="bx bx-plus"></i> Inventory Update
        </button>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addInventoryModal">
          <i class="bx bx-plus"></i> Add Inventory
        </button>
      </div>

      <div class="table-responsive">
        <table class="table table-striped table-hover">
          <thead class="table-primary">
            <tr>
              <th>Inventory ID</th>
              <th>Inventory Name</th>
              <th>Category</th>
              <th>Quantity</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <!--这边需要更改，用来DISPLAY RESULT-->
            <?php display_item(); ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <footer class="footer mt-auto py-3 bg-light">
    <div class="container text-center"><span class="text-muted">© 2025 All rights reserved.</span></div>
  </footer>
</div>
<!-- Item Log Modal -->
<div class="modal fade" id="itemLogModal" tabindex="-1" aria-labelledby="itemLogModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <form class="modal-content" action="includes/itemLog.inc.php" method="POST">
      <div class="modal-header">
        <h5 class="modal-title">Inventory Update</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <!--ITEM ID-->
        <!--<div class="mb-3">
          <label for="LogID" class="form-label">Log ID</label>
          <input type="text" class="form-control" id="LogID" name="LogID" required>
        </div>-->
        <div class="mb-3">
          <label for="ItemID" class="form-label">Item Name</label>
          <select class="form-select" id="ItemID" name="ItemID" required>
          <option value="">Select Item</option>
          <?php foreach ($ItemID as $ItemID): ?>
            <option value="<?= htmlspecialchars($ItemID['ItemID']) ?>">
              <?= htmlspecialchars($ItemID['ItemName']) ?>
            </option>
          <?php endforeach; ?>
        </select>
        </div>

        <div class="mb-3">
            <label for="ItemQty" class="form-label">Quantity</label>
            <input id="ItemQty" name="ItemQty" type="number" min="0" step="1" class="form-control" required>
        </div>
        
        <div class="mb-3">
            <label for="ItemStatus" class="form-label">Status:</label>
            <select class="form-select" id="ItemStatus" name="ItemStatus" required>
              <option value="Pending Donation">Pending Donation</option>
              <option value="Donation">Donation</option>
              <option value="Disposal">Disposal</option>
              <option value="Sold">Sold</option>
            </select>
          </div>
      </div>
        
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Save</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
      </div>
    </form>
  </div>
</div>

<!-- Add Inventory Modal -->
<div class="modal fade" id="addInventoryModal" tabindex="-1" aria-labelledby="addInventoryModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <form class="modal-content" action="includes/addInventory.inc.php" method="POST">
      <div class="modal-header">
        <h5 class="modal-title">Add New Inventory</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <!--ITEM ID-->
        <!--<div class="mb-3">
          <label for="ItemID" class="form-label">Inventory ID</label>
          <input type="text" class="form-control" id="ItemID" name="ItemID" required>
        </div>-->
        <div class="mb-3">
          <label for="ItemName" class="form-label">Inventory Name</label>
          <input type="text" class="form-control" id="ItemName" name="ItemName" required>
        </div>

        <div class="mb-3">
          <label for="CategoryID" class="form-label">Category</label>
          <select class="form-select" id="CategoryID" name="CategoryID" required>
          <option value="">Select Category</option>
          <?php foreach ($CategoryID as $CategoryID): ?>
            <option value="<?= htmlspecialchars($CategoryID['CategoryID']) ?>">
              <?= htmlspecialchars($CategoryID['CategoryName']) ?>
            </option>
          <?php endforeach; ?>
        </select>
        </div>

        <div class="mb-3">
            <label for="ItemQty" class="form-label">Quantity</label>
            <input id="ItemQty" name="ItemQty" type="number" min="0" step="1" class="form-control" required>
        </div>
        
      </div>
        
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Add</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
      </div>
    </form>
  </div>
</div>

<!-- Edit Inventory Modal -->
<div class="modal fade" id="editInventoryModal" tabindex="-1" aria-labelledby="editInventoryModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <form class="modal-content" action="includes/editInventory.inc.php" method="POST">
      <div class="modal-header">
        <h5 class="modal-title">Edit Inventory</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="editItemID" name="InventoryID">
        <div class="mb-3">
          <label for="editItemName" class="form-label">Inventory Name</label>
          <input type="text" class="form-control" id="editItemName" name="InventoryName" required>
        </div>
        
        <div class="mb-3">
          <label for="editCategoryID" class="form-label">Category</label>
            <select class="form-select" id="editCategoryID" name="editCategoryID">
              <option value="">Select Category</option>
              <?php foreach ($CategoryID as $Category): ?>
                <option value="<?= htmlspecialchars($CategoryID['CategoryID']) ?>">
                  <?= htmlspecialchars($CategoryID['CategoryName']) ?>
                </option>
              <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
          <label for="editItemQty" class="form-label">Quantity</label>
          <input type="number" class="form-control" id="editItemQty" name="InventoryQuantity" required min="0">
        </div>

      <div class="modal-footer">
        <button type="submit" class="btn btn-warning">Update Inventory</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
      </div>
    </form>
  </div>
</div>

<!-- JavaScript -->
<script>
  // Use event delegation to handle clicks for dynamically generated buttons
  document.addEventListener('click', (event) => {
    if (event.target.classList.contains('editItemBtn')) {
        const button = event.target;
        console.log("Item Name:", document.getElementById("editItemName").value);
        console.log("Item Qty:", document.getElementById("editItemQty").value);        

        document.getElementById('editItemID').value = button.getAttribute('data-Item-id');
        document.getElementById('editItemName').value = button.getAttribute('data-Item-name');
        document.getElementById('editItemQty').value = button.getAttribute('data-Item-qty');
        document.getElementById('editCategoryID').value = button.getAttribute('data-Item-category');

        // Open the modal
        const modal = new bootstrap.Modal(document.getElementById('editInventoryModal'));
        modal.show();
    }
  });

  // Delete role
  function deleteItem(ItemID) {
    if (confirm("Please confirm the deletion Inventory?")) {
      fetch('includes/deleteInventory.inc.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams({ 'ItemID': ItemID })
      })
      .then(response => response.text())
      .then(result => {
        console.log("Server response:", result);
        if (result === "success") {
          alert("Inventory has been deleted.");
          location.reload();
        } else {
          alert("Inventory has not delete: " + result);
        }
      })
      .catch(error => {
        console.error("Error:", error);
        alert("An error occurred while deleting the Inventory.");
      });
    }
  }

  
  
  // Filter roles
  document.getElementById('itemSearch').addEventListener('input', function () {
    const searchValue = this.value.toLowerCase();
    const rows = document.querySelectorAll('tbody tr');

    rows.forEach(row => {
      const rowText = row.textContent.toLowerCase();
      row.style.display = rowText.includes(searchValue) ? '' : 'none';
    });
  });

  // getCategories function
  document.addEventListener("DOMContentLoaded", function () {
  fetch("includes/getCategories.inc.php")
    .then(response => response.text())
    .then(data => {
      document.getElementById("CategoryID").innerHTML += data;
    })
    .catch(error => console.error("Error loading categories:", error));
});

  // getCategories function for edit modal
  document.addEventListener("DOMContentLoaded", function () {
    fetch("includes/getCategories.inc.php")
      .then(response => response.text())
      .then(data => {
        document.getElementById("editCategoryID").innerHTML += data;
      })
      .catch(error => console.error("Error loading categories:", error));
  });

  // getItemName function for ItemLog modal
  document.addEventListener("DOMContentLoaded", function () {
    fetch("includes/getItemName.inc.php")
      .then(response => response.text())
      .then(data => {
        document.getElementById("ItemID").innerHTML += data;
      })
      .catch(error => console.error("Error loading categories:", error));
  });
</script>

</body>
</html>
