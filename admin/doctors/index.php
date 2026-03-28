<?php
require_once __DIR__ . '/../../include/config.php';
$pageTitle = 'Manage Doctors';
$activePage = 'doctors';
require_once '../include/head.php';
?>

<?php require_once '../include/header.php'; ?>
<?php require_once '../include/sidebar.php'; ?>

<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold">Doctors Directory</h3>
            <div class="d-flex gap-2">
                <input type="text" id="doctorSearch" class="form-control rounded-pill px-3" placeholder="Search doctors...">
                <a href="add.php" class="btn btn-primary rounded-pill"><i class="fa fa-plus"></i> Add</a>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr class="text-muted small text-uppercase">
                            <th class="ps-4">Doctor</th>
                            <th>Slug</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="doctorTableBody">
                        </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
function fetchDoctors(page = 1, search = '') {
    // We will create ajax_doctors.php next to handle this
    fetch(`ajax_doctors.php?page=${page}&search=${search}`)
    .then(res => res.json())
    .then(data => {
        document.getElementById('doctorTableBody').innerHTML = data.rows;
    });
}

document.getElementById('doctorSearch').addEventListener('input', (e) => {
    fetchDoctors(1, e.target.value);
});

// Initial Load
fetchDoctors();
</script>

<?php require_once '../include/footer.php'; ?>