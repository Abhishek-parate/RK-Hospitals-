<?php
require_once '../include/config.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: blogs.php");
    exit;
}
$id = (int)$_GET['id'];

$res  = $conn->query("SELECT * FROM blogs WHERE id = $id");
$blog = $res ? $res->fetch_assoc() : null;
if (!$blog) { header("Location: blogs.php"); exit; }

$categories = [];
$res = $conn->query("SELECT id, name FROM blog_categories ORDER BY name ASC");
if ($res) { while ($r = $res->fetch_assoc()) { $categories[] = $r; } }

$authors = [];
$res = $conn->query("SELECT id, name FROM blog_authors ORDER BY name ASC");
if ($res) { while ($r = $res->fetch_assoc()) { $authors[] = $r; } }

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $title        = trim($_POST['title'] ?? '');
    $slug         = trim($_POST['slug'] ?? '');
    $excerpt      = trim($_POST['excerpt'] ?? '');
    $content      = $_POST['content'] ?? '';
    $category_id  = !empty($_POST['category_id']) ? (int)$_POST['category_id'] : null;
    $author_id    = !empty($_POST['author_id'])   ? (int)$_POST['author_id']   : null;
    $tags         = trim($_POST['tags'] ?? '');
    $is_published = isset($_POST['is_published']) ? 1 : 0;
    $published_at = !empty($_POST['published_at']) ? $conn->real_escape_string($_POST['published_at']) : date('Y-m-d');

    if (empty($title))   $errors[] = 'Title is required.';
    if (empty($content) || $content === '<p><br></p>') $errors[] = 'Content is required.';

    $slug    = strtolower(preg_replace('/[^a-z0-9-]+/', '-', trim($slug, '-')));
    $slugEsc = $conn->real_escape_string($slug);

    $chk = $conn->query("SELECT id FROM blogs WHERE slug = '$slugEsc' AND id != $id");
    if ($chk && $chk->num_rows > 0) {
        $errors[] = 'Slug already exists. Please use a different one.';
    }

    $imagePath = $blog['image'];
    if (!empty($_FILES['image']['name'])) {
        $allowedTypes = ['image/jpeg','image/png','image/webp','image/gif'];
        $fileType     = mime_content_type($_FILES['image']['tmp_name']);
        if (!in_array($fileType, $allowedTypes)) {
            $errors[] = 'Invalid image type. Allowed: JPG, PNG, WEBP, GIF.';
        } elseif ($_FILES['image']['size'] > 2 * 1024 * 1024) {
            $errors[] = 'Image size must be under 2MB.';
        } else {
            $uploadDir = 'assets/img/blog/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
            $ext      = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $fileName = 'blog-' . time() . '-' . uniqid() . '.' . strtolower($ext);
            if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $fileName)) {
                if (!empty($blog['image']) && file_exists($blog['image'])) @unlink($blog['image']);
                $imagePath = $uploadDir . $fileName;
            } else {
                $errors[] = 'Failed to upload image. Check folder permissions.';
            }
        }
    }

    if (empty($errors)) {
        $titleEsc   = $conn->real_escape_string($title);
        $excerptEsc = $conn->real_escape_string($excerpt);
        $contentEsc = $conn->real_escape_string($content);
        $imageEsc   = $conn->real_escape_string($imagePath);
        $tagsEsc    = $conn->real_escape_string($tags);
        $pubAt      = "'$published_at'";
        $catVal     = $category_id  ? $category_id  : 'NULL';
        $authVal    = $author_id    ? $author_id    : 'NULL';

        $sql = "UPDATE blogs SET
                    title        = '$titleEsc',
                    slug         = '$slugEsc',
                    excerpt      = '$excerptEsc',
                    content      = '$contentEsc',
                    image        = '$imageEsc',
                    category_id  = $catVal,
                    author_id    = $authVal,
                    tags         = '$tagsEsc',
                    is_published = $is_published,
                    published_at = $pubAt,
                    updated_at   = NOW()
                WHERE id = $id";

        if ($conn->query($sql)) {
            header("Location: blogs.php?msg=updated");
            exit;
        } else {
            $errors[] = 'Database error: ' . $conn->error;
        }
    }

    $blog = array_merge($blog, compact('title','slug','excerpt','content','category_id','author_id','tags','is_published','published_at'));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Blog - Admin Panel</title>
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="assets/css/feathericon.min.css">
    <link rel="stylesheet" href="assets/css/custom.css">
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

    <style>
        .image-preview-box {
            width: 100%; height: 200px; border: 2px dashed #dee2e6;
            border-radius: 8px; display: flex; align-items: center;
            justify-content: center; overflow: hidden; cursor: pointer;
        }
        .image-preview-box img { max-width: 100%; max-height: 100%; object-fit: contain; }
        .placeholder-text { color: #adb5bd; text-align: center; }
        .form-section-title {
            font-size: 13px; font-weight: 600; text-transform: uppercase;
            letter-spacing: .5px; color: #666; margin-bottom: 12px;
            border-bottom: 1px solid #eee; padding-bottom: 6px;
        }
        #quillEditor {
            height: 350px;
            background: #fff;
            font-size: 14px;
            line-height: 1.7;
        }
        .ql-toolbar.ql-snow {
            border-radius: 6px 6px 0 0;
            border-color: #dee2e6 !important;
            background: #f8f9fa;
        }
        .ql-container.ql-snow {
            border-radius: 0 0 6px 6px;
            border-color: #dee2e6 !important;
        }
        .ql-editor.ql-blank::before {
            color: #adb5bd;
            font-style: normal;
        }
    </style>
</head>
<body>
<div class="main-wrapper">

    <div class="header">
        <div class="header-left">
            <a href="index.php" class="logo"><img src="assets/img/logo.png" alt="Logo"></a>
            <a href="index.php" class="logo logo-small"><img src="assets/img/logo-small.png" alt="Logo" width="30" height="30"></a>
        </div>
        <a href="javascript:void(0);" id="toggle_btn"><i class="fe fe-text-align-left"></i></a>
        <a class="mobile_btn" id="mobile_btn"><i class="fa fa-bars"></i></a>
        <ul class="nav user-menu">
            <li class="nav-item dropdown has-arrow">
                <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
                    <span class="user-img">
                        <img class="rounded-circle" src="assets/img/profiles/avatar-01.jpg" width="31" alt="Admin">
                    </span>
                </a>
                <div class="dropdown-menu">
                    <div class="user-header">
                        <div class="avatar avatar-sm">
                            <img src="assets/img/profiles/avatar-01.jpg" alt="User" class="avatar-img rounded-circle">
                        </div>
                        <div class="user-text">
                            <h6>Ryan Taylor</h6>
                            <p class="text-muted mb-0">Administrator</p>
                        </div>
                    </div>
                    <a class="dropdown-item" href="contact-us.html">Logout</a>
                </div>
            </li>
        </ul>
    </div>

    <div class="sidebar" id="sidebar">
        <div class="sidebar-inner slimscroll">
            <div id="sidebar-menu" class="sidebar-menu">
                <ul>
                    <li class="menu-title"><span>Main</span></li>
                    <li><a href="index.php"><i class="fe fe-home"></i> <span>Dashboard</span></a></li>
                    <li><a href="appointment-list.html"><i class="fe fe-layout"></i> <span>Appointments</span></a></li>
                    <li><a href="specialities.html"><i class="fe fe-users"></i> <span>Specialities</span></a></li>
                    <li><a href="doctor-list.html"><i class="fe fe-user-plus"></i> <span>Doctors</span></a></li>
                    <li><a href="patient-list.html"><i class="fe fe-user"></i> <span>Patients</span></a></li>
                    <li class="active"><a href="blogs.php"><i class="fe fe-star-o"></i> <span>Blogs</span></a></li>
                    <li><a href="transactions-list.html"><i class="fe fe-activity"></i> <span>Transactions</span></a></li>
                    <li><a href="settings.html"><i class="fe fe-vector"></i> <span>Settings</span></a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="page-wrapper">
        <div class="content container-fluid">

            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h3 class="page-title">Edit Blog</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="blogs.php">Blogs</a></li>
                            <li class="breadcrumb-item active">Edit Blog</li>
                        </ul>
                    </div>
                    <div class="col-sm-6 text-end">
                        <a href="../blog/<?= htmlspecialchars($blog['slug']) ?>" target="_blank" class="btn btn-outline-success btn-sm me-2">
                            <i class="fe fe-eye me-1"></i> View on Site
                        </a>
                        <a href="blogs.php" class="btn btn-outline-secondary btn-sm">
                            <i class="fe fe-arrow-left me-1"></i> Back to Blogs
                        </a>
                    </div>
                </div>
            </div>

            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <ul class="mb-0">
                        <?php foreach ($errors as $e): ?>
                            <li><?= htmlspecialchars($e) ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <form method="POST" enctype="multipart/form-data" id="blogForm">
                <div class="row">

                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-body">
                                <p class="form-section-title">Blog Content</p>

                                <div class="mb-3">
                                    <label class="form-label">Title <span class="text-danger">*</span></label>
                                    <input type="text" name="title" id="blogTitle" class="form-control"
                                           value="<?= htmlspecialchars($blog['title']) ?>" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Slug</label>
                                    <div class="input-group">
                                        <input type="text" name="slug" id="blogSlug" class="form-control"
                                               value="<?= htmlspecialchars($blog['slug']) ?>">
                                        <button type="button" class="btn btn-outline-secondary" id="generateSlug">
                                            <i class="fa fa-refresh"></i> Generate
                                        </button>
                                    </div>
                                    <small class="text-muted">Lowercase letters, numbers and hyphens only. &nbsp;
                                        <a href="../blog/<?= htmlspecialchars($blog['slug']) ?>" target="_blank" id="slugPreviewLink" style="color:#0d6efd;">
                                            <i class="fa fa-external-link" style="font-size:10px;"></i> Preview URL: /blog/<?= htmlspecialchars($blog['slug']) ?>
                                        </a>
                                    </small>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Excerpt</label>
                                    <textarea name="excerpt" class="form-control" rows="3"><?= htmlspecialchars($blog['excerpt']) ?></textarea>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Content <span class="text-danger">*</span></label>
                                    <div id="quillEditor"></div>
                                    <textarea name="content" id="blogContent" class="d-none"></textarea>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">

                        <div class="card">
                            <div class="card-body">
                                <p class="form-section-title">Publish Settings</p>
                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="isPublished"
                                               name="is_published" value="1"
                                               <?= $blog['is_published'] ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="isPublished">Published</label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Published Date</label>
                                    <input type="datetime-local" name="published_at" class="form-control"
                                           value="<?= !empty($blog['published_at']) ? date('Y-m-d\TH:i', strtotime($blog['published_at'])) : '' ?>">
                                </div>
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fe fe-save me-1"></i> Update Blog
                                    </button>
                                    <a href="blogs.php" class="btn btn-outline-secondary">Cancel</a>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <p class="form-section-title">Category & Author</p>
                                <div class="mb-3">
                                    <label class="form-label">Category</label>
                                    <select name="category_id" class="form-select">
                                        <option value="">-- Select Category --</option>
                                        <?php foreach ($categories as $cat): ?>
                                            <option value="<?= $cat['id'] ?>" <?= $blog['category_id'] == $cat['id'] ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($cat['name']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Author (Doctor)</label>
                                    <select name="author_id" class="form-select">
                                        <option value="">-- Select Author --</option>
                                        <?php foreach ($authors as $author): ?>
                                            <option value="<?= $author['id'] ?>" <?= $blog['author_id'] == $author['id'] ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($author['name']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <p class="form-section-title">Featured Image</p>
                                <div class="image-preview-box mb-2" onclick="document.getElementById('imageInput').click()">
                                    <?php if (!empty($blog['image'])): ?>
                                        <img id="imagePreview" src="<?= htmlspecialchars($blog['image']) ?>" alt="Current">
                                        <div class="placeholder-text" id="imagePlaceholder" style="display:none;">
                                    <?php else: ?>
                                        <img id="imagePreview" src="" alt="Preview" style="display:none;">
                                        <div class="placeholder-text" id="imagePlaceholder">
                                    <?php endif; ?>
                                            <i class="fe fe-upload" style="font-size:28px;"></i>
                                            <p class="mt-1 mb-0 small">Click to change image</p>
                                        </div>
                                </div>
                                <input type="file" name="image" id="imageInput" accept="image/*" class="d-none">
                                <?php if (!empty($blog['image'])): ?>
                                    <small class="text-muted"><i class="fe fe-image me-1"></i><?= basename($blog['image']) ?></small>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <p class="form-section-title">Tags</p>
                                <input type="text" name="tags" class="form-control"
                                       placeholder="e.g. Orthopedics, Surgery, Health"
                                       value="<?= htmlspecialchars($blog['tags'] ?? '') ?>">
                                <small class="text-muted">Comma-separated tags</small>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <p class="form-section-title">Stats</p>
                                <div class="d-flex justify-content-between text-center">
                                    <div>
                                        <h4 class="text-primary mb-0"><?= (int)$blog['views'] ?></h4>
                                        <small class="text-muted">Views</small>
                                    </div>
                                    <div>
                                        <h4 class="text-success mb-0"><?= (int)$blog['comments'] ?></h4>
                                        <small class="text-muted">Comments</small>
                                    </div>
                                    <div>
                                        <h4 class="text-info mb-0"><?= $blog['is_published'] ? 'Live' : 'Draft' ?></h4>
                                        <small class="text-muted">Status</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </form>

        </div>
    </div>
</div>

<script src="assets/js/jquery-3.7.1.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="assets/js/script.js"></script>
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>

<script>
    var quill = new Quill('#quillEditor', {
        theme: 'snow',
        placeholder: 'Write your blog content here...',
        modules: {
            toolbar: [
                [{ 'header': [1, 2, 3, 4, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'color': [] }, { 'background': [] }],
                [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                [{ 'align': [] }],
                ['link', 'image'],
                ['blockquote', 'code-block'],
                ['clean']
            ]
        }
    });

    // Load existing content into Quill
    quill.root.innerHTML = <?= json_encode($blog['content']) ?>;

    document.getElementById('blogForm').addEventListener('submit', function (e) {
        var content = quill.root.innerHTML;
        document.getElementById('blogContent').value = content;
        if (content === '<p><br></p>' || content.trim() === '') {
            e.preventDefault();
            alert('Content is required.');
            quill.focus();
        }
    });

    document.getElementById('generateSlug').addEventListener('click', function () {
        document.getElementById('blogSlug').value = document.getElementById('blogTitle').value
            .toLowerCase().trim()
            .replace(/[^a-z0-9\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-');
    });

    document.getElementById('blogSlug').addEventListener('input', function () {
        this.value = this.value.toLowerCase().replace(/[^a-z0-9-]/g, '-');
        var link = document.getElementById('slugPreviewLink');
        if (link) {
            link.href = '../blog/' + this.value;
            link.textContent = ' Preview URL: /blog/' + this.value;
        }
    });

    document.getElementById('imageInput').addEventListener('change', function () {
        if (this.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                document.getElementById('imagePreview').src = e.target.result;
                document.getElementById('imagePreview').style.display = 'block';
                document.getElementById('imagePlaceholder').style.display = 'none';
            };
            reader.readAsDataURL(this.files[0]);
        }
    });
</script>
</body>
</html>