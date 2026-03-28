<?php
require_once './../../include/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = clean($_POST['name']);
    $slug = strtolower(preg_replace('/[^a-z0-9]+/i', '-', $name));
    $designation = clean($_POST['designation']);
    $specialty = clean($_POST['specialty']);
    $bio = $_POST['bio'];
    $satisfaction_rate = (int)$_POST['satisfaction_rate'];
    $feedback_count = (int)$_POST['feedback_count'];
    $location = clean($_POST['location']);
    $consultation_fee = clean($_POST['consultation_fee']);
    $specializations = clean($_POST['specializations']);
    $map_iframe = $_POST['map_iframe'];
    
    // Process JSON fields
    $education = [];
    if(isset($_POST['edu_title'])) {
        for($i=0; $i<count($_POST['edu_title']); $i++) {
            if(!empty($_POST['edu_title'][$i])) {
                $education[] = ['title' => clean($_POST['edu_title'][$i]), 'degree' => clean($_POST['edu_degree'][$i]), 'year' => clean($_POST['edu_year'][$i])];
            }
        }
    }
    $experience = [];
    if(isset($_POST['exp_title'])) {
        for($i=0; $i<count($_POST['exp_title']); $i++) {
            if(!empty($_POST['exp_title'][$i])) {
                $experience[] = ['title' => clean($_POST['exp_title'][$i]), 'year' => clean($_POST['exp_year'][$i])];
            }
        }
    }
    $awards = [];
    if(isset($_POST['awd_title'])) {
        for($i=0; $i<count($_POST['awd_title']); $i++) {
            if(!empty($_POST['awd_title'][$i])) {
                $awards[] = ['title' => clean($_POST['awd_title'][$i]), 'desc' => clean($_POST['awd_desc'][$i]), 'year' => clean($_POST['awd_year'][$i])];
            }
        }
    }

    $edu_json = json_encode($education);
    $exp_json = json_encode($experience);
    $awd_json = json_encode($awards);

    $photo = 'default.jpg';
    if (!empty($_FILES['photo']['name'])) {
        $photo = time() . '_' . $_FILES['photo']['name'];
        move_uploaded_file($_FILES['photo']['tmp_name'], "../../assets/img/doctors/" . $photo);
    }

    $stmt = $conn->prepare("INSERT INTO doctors (name, slug, designation, specialty, satisfaction_rate, feedback_count, location, consultation_fee, bio, education_json, experience_json, awards_json, specializations, map_iframe, photo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssiisssssssss", $name, $slug, $designation, $specialty, $satisfaction_rate, $feedback_count, $location, $consultation_fee, $bio, $edu_json, $exp_json, $awd_json, $specializations, $map_iframe, $photo);
    
    if ($stmt->execute()) {
        header("Location: index.php?msg=added");
        exit;
    }
}

$pageTitle = 'Add Doctor';
require_once '../include/head.php';
?>

<?php require_once '../include/header.php'; ?>
<?php require_once '../include/sidebar.php'; ?>

<div class="page-wrapper">
    <div class="content container-fluid">
        <h3 class="fw-bold mb-4">Add Doctor Profile</h3>
        <form method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Doctor Full Name</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Main Specialty (e.g. Dentist)</label>
                                <input type="text" name="specialty" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Designation / Degrees</label>
                                <input type="text" name="designation" class="form-control" placeholder="MBBS, MD...">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Location</label>
                                <input type="text" name="location" class="form-control" placeholder="Nagpur, India">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Satisfaction Rate (%)</label>
                                <input type="number" name="satisfaction_rate" class="form-control" value="100">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Feedback Count</label>
                                <input type="number" name="feedback_count" class="form-control" value="0">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Consultation Fee</label>
                                <input type="text" name="consultation_fee" class="form-control" placeholder="$100 / hour">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Specializations (Comma separated)</label>
                            <input type="text" name="specializations" class="form-control" placeholder="Children Care, Periodontology...">
                        </div>
                        <div class="mb-0">
                            <label class="form-label">Biography</label>
                            <textarea name="bio" class="form-control" rows="4"></textarea>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                        <h6 class="fw-bold border-bottom pb-2 mb-3">Education History <button type="button" class="btn btn-sm btn-light float-end" onclick="addEdu()">+ Add</button></h6>
                        <div id="edu_wrapper"></div>
                        
                        <h6 class="fw-bold border-bottom pb-2 mb-3 mt-4">Work Experience <button type="button" class="btn btn-sm btn-light float-end" onclick="addExp()">+ Add</button></h6>
                        <div id="exp_wrapper"></div>

                        <h6 class="fw-bold border-bottom pb-2 mb-3 mt-4">Awards <button type="button" class="btn btn-sm btn-light float-end" onclick="addAwd()">+ Add</button></h6>
                        <div id="awd_wrapper"></div>
                    </div>

                    <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                        <h6 class="fw-bold border-bottom pb-2 mb-3">Hospital Location Map (Iframe)</h6>
                        <textarea name="map_iframe" class="form-control" rows="3" placeholder="Paste Google Maps iframe HTML here..."></textarea>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm rounded-4 p-4 text-center">
                        <label class="form-label text-start">Profile Photo</label>
                        <input type="file" name="photo" class="form-control mb-4">
                        <button type="submit" class="btn btn-primary w-100 rounded-pill py-2 fw-bold">Save Profile</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function addEdu() {
        const html = `<div class="row mb-2"><div class="col-4"><input type="text" name="edu_title[]" class="form-control" placeholder="University Name"></div><div class="col-4"><input type="text" name="edu_degree[]" class="form-control" placeholder="Degree (BDS)"></div><div class="col-3"><input type="text" name="edu_year[]" class="form-control" placeholder="Years (1998-2003)"></div><div class="col-1"><button type="button" class="btn btn-danger w-100" onclick="this.parentElement.parentElement.remove()">X</button></div></div>`;
        document.getElementById('edu_wrapper').insertAdjacentHTML('beforeend', html);
    }
    function addExp() {
        const html = `<div class="row mb-2"><div class="col-7"><input type="text" name="exp_title[]" class="form-control" placeholder="Clinic / Hospital Name"></div><div class="col-4"><input type="text" name="exp_year[]" class="form-control" placeholder="Years (2010 - Present)"></div><div class="col-1"><button type="button" class="btn btn-danger w-100" onclick="this.parentElement.parentElement.remove()">X</button></div></div>`;
        document.getElementById('exp_wrapper').insertAdjacentHTML('beforeend', html);
    }
    function addAwd() {
        const html = `<div class="row mb-2"><div class="col-3"><input type="text" name="awd_year[]" class="form-control" placeholder="Year (July 2023)"></div><div class="col-4"><input type="text" name="awd_title[]" class="form-control" placeholder="Award Title"></div><div class="col-4"><input type="text" name="awd_desc[]" class="form-control" placeholder="Short Description"></div><div class="col-1"><button type="button" class="btn btn-danger w-100" onclick="this.parentElement.parentElement.remove()">X</button></div></div>`;
        document.getElementById('awd_wrapper').insertAdjacentHTML('beforeend', html);
    }
</script>

<?php require_once '../include/footer.php'; ?>