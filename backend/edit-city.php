<?php
session_start();
include 'db.php';

$edit_city_id = intval($_GET['id']);
$city = mysqli_query($conn, "SELECT * FROM city WHERE id='$edit_city_id'");
$city_detail = mysqli_fetch_assoc($city);

if (isset($_POST['submit'])) {

    $heading         = mysqli_real_escape_string($conn, $_POST['heading'] ?? '');
    $hero_heading    = mysqli_real_escape_string($conn, $_POST['hero_heading'] ?? '');
    $hero_subheading = mysqli_real_escape_string($conn, $_POST['hero_subheading'] ?? '');

    /* IMAGE UPLOAD */
    $uploadedFiles = [];

    if (!empty($_FILES['gallery']['name'][0])) {

        $uploadDir = "uploads/city/";
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

        $allowed = ['jpg', 'jpeg', 'png', 'webp'];

        foreach ($_FILES['gallery']['tmp_name'] as $key => $tmpName) {
            if ($_FILES['gallery']['error'][$key] == 0) {

                $ext = strtolower(pathinfo($_FILES['gallery']['name'][$key], PATHINFO_EXTENSION));
                if (!in_array($ext, $allowed)) continue;

                $filename = time() . '_' . rand(1000, 9999) . '_' . basename($_FILES['gallery']['name'][$key]);
                $target   = $uploadDir . $filename;

                if (move_uploaded_file($tmpName, $target)) {
                    $uploadedFiles[] = $target;
                }
            }
        }
    }

    // Use existing_images[] from POST (deleted ones won't be in this array)
    $existingImages = isset($_POST['existing_images']) ? (array)$_POST['existing_images'] : [];
    $allImages  = array_merge($existingImages, $uploadedFiles);
    $image_json = mysqli_real_escape_string($conn, json_encode(array_values($allImages)));

    /* DESCRIPTION */
    $descriptions = [];
    if (!empty($_POST['desc_pera'])) {
        foreach ($_POST['desc_pera'] as $pera) {
            $descriptions[] = $pera;
        }
    }
    $description_json = mysqli_real_escape_string($conn, json_encode($descriptions));

    /* FEATURES */
    $features = [];
    if (!empty($_POST['feature_heading'])) {
        foreach ($_POST['feature_heading'] as $key => $heading_feature) {
            $features[] = [
                "heading"     => $heading_feature,
                "description" => $_POST['feature_desc'][$key] ?? ''
            ];
        }
    }
    $feature_section = [
        "mainHeading" => $_POST['feature_main_heading'] ?? '',
        "description" => $_POST['feature_main_desc'] ?? '',
        "features"    => $features
    ];
    $feature_json = mysqli_real_escape_string($conn, json_encode($feature_section));

    /* FAQ */
    $faqs = [];
    if (!empty($_POST['faq_question'])) {
        foreach ($_POST['faq_question'] as $key => $q) {
            $question = trim($q);
            $answer   = trim($_POST['faq_answer'][$key] ?? '');
            if (!empty($question) && !empty($answer)) {
                $faqs[] = ['question' => $question, 'answer' => $answer];
            }
        }
    }
    $faq_json = mysqli_real_escape_string($conn, json_encode($faqs));

    /* SEO */
    $title            = mysqli_real_escape_string($conn, $_POST['title'] ?? '');
    $meta_description = mysqli_real_escape_string($conn, $_POST['description'] ?? '');
    $keywords         = mysqli_real_escape_string($conn, $_POST['keywords'] ?? '');

    /* UPDATE QUERY */
    $query = mysqli_query($conn, "UPDATE `city` SET
            `heading`             = '$heading',
            `hero_heading`        = '$hero_heading',
            `hero_subheading`     = '$hero_subheading',
            `images`              = '$image_json',
            `description_section` = '$description_json',
            `feature_section`     = '$feature_json',
            `faq_section`         = '$faq_json',
            `meta_title`          = '$title',
            `meta_description`    = '$meta_description',
            `keywords`            = '$keywords'
        WHERE id = '$edit_city_id'");

    if ($query) {
        $_SESSION['msg'] = '<sl-alert variant="success" open duration="1500" closable>
                        <span class="mdi mdi-check-circle-outline"></span>
                        City Updated Successfully
                      </sl-alert>';
        header('location: all-city.php');
        exit;
    } else {
        $_SESSION['msg'] = "<sl-alert variant='danger' open duration='3000' closable>
                         <span class='mdi mdi-alpha-x-circle-outline'></span>
                         Failed to Update City: " . mysqli_error($conn) . "
                       </sl-alert>";
    }
}

// Decode existing sections for pre-filling form
$existing_descriptions = json_decode($city_detail['description_section'] ?? '[]', true) ?: [];
$existing_feature      = json_decode($city_detail['feature_section'] ?? '{}', true) ?: [];
$existing_faqs         = json_decode($city_detail['faq_section'] ?? '[]', true) ?: [];
$existing_images       = json_decode($city_detail['images'] ?? '[]', true) ?: [];
if (empty($existing_images) && !empty($city_detail['images'])) {
    $existing_images = array_filter(explode(",", $city_detail['images']));
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit City</title>
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@shoelace-style/shoelace@2.0.0-beta.83/dist/themes/light.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .form-card {
            background: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        label {
            font-weight: 600;
            display: block;
            margin-bottom: 5px;
        }

        .form-row {
            margin-bottom: 15px;
        }

        input,
        textarea,
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
        }

        .faq-group {
            margin-bottom: 15px;
            border: 1px solid #eee;
            border-radius: 6px;
            padding: 10px;
            background: #fafafa;
        }

        .preview-img {
            max-height: 100px;
            margin: 5px;
            border-radius: 6px;
        }

        .img-wrapper {
            position: relative;
            display: inline-block;
            margin: 5px;
        }

        .img-wrapper img {
            max-height: 100px;
            border-radius: 6px;
            display: block;
        }

        .img-delete-btn {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #dc3545;
            color: #fff;
            border: none;
            border-radius: 50%;
            width: 22px;
            height: 22px;
            font-size: 13px;
            line-height: 1;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
        }

        .img-delete-btn:hover {
            background: #a71d2a;
        }
    </style>
</head>

<body>
    <?php include('sidenav.php') ?>

    <section class="main-content">

        <h2 class="text-white mb-5">Edit City</h2>

        <?php if (!empty($_SESSION['msg'])): ?>
            <div class="sl-toast-stack"><?= $_SESSION['msg'];
                                        unset($_SESSION['msg']); ?></div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data" class="form-card">

            <!-- city TITLE -->
            <div class="form-row">
                <label>city Title</label>
                <input type="text" name="heading"
                    value="<?= htmlspecialchars($city_detail['heading'] ?? '') ?>" required>
            </div>

            <!-- HERO HEADING -->
            <div class="form-row">
                <label>Hero Heading</label>
                <input type="text" name="hero_heading"
                    value="<?= htmlspecialchars($city_detail['hero_heading'] ?? '') ?>">
            </div>

            <!-- HERO SUBHEADING -->
            <div class="form-row">
                <label>Hero Subheading</label>
                <textarea name="hero_subheading"><?= htmlspecialchars($city_detail['hero_subheading'] ?? '') ?></textarea>
            </div>

            <!-- GALLERY -->
            <div class="gallery-box" style="border:1px solid #ddd;border-radius:6px;padding:15px;margin-top:20px;">
                <h3>Gallery</h3>
                <button type="button" class="btn btn-sm btn-primary"
                    data-bs-toggle="modal" data-bs-target="#galleryModal">
                    Add Images
                </button>
                <div class="gallery-images mt-3 d-flex flex-wrap">
                    <?php foreach ($existing_images as $img): ?>
                        <div class="img-wrapper">
                            <img src="<?= htmlspecialchars($img) ?>">
                            <button type="button" class="img-delete-btn"
                                onclick="deleteImage(this, '<?= htmlspecialchars($img) ?>')"
                                title="Delete">&#x2715;</button>
                            <input type="hidden" name="existing_images[]" value="<?= htmlspecialchars($img) ?>">
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- DESCRIPTION -->
            <h3 class="mt-4">Description Section</h3>
            <div id="descriptionContainer">
                <?php foreach ($existing_descriptions as $pera): ?>
                    <div class="faq-group">
                        <label>Description</label>
                        <textarea name="desc_pera[]"><?= htmlspecialchars($pera) ?></textarea>
                        <button type="button" class="btn btn-danger btn-sm mt-2"
                            onclick="this.parentElement.remove()">Remove</button>
                    </div>
                <?php endforeach; ?>
            </div>
            <button type="button" class="btn btn-outline-primary btn-sm mt-2" onclick="addDescription()">
                + Add Description
            </button>

            <!-- FEATURES -->
            <h3 class="mt-4">Features Section</h3>
            <div class="form-row">
                <label>Main Heading</label>
                <input type="text" name="feature_main_heading"
                    value="<?= htmlspecialchars($existing_feature['mainHeading'] ?? '') ?>">
            </div>
            <div class="form-row">
                <label>Main Description</label>
                <textarea name="feature_main_desc"><?= htmlspecialchars($existing_feature['description'] ?? '') ?></textarea>
            </div>
            <div id="featureContainer">
                <?php foreach ($existing_feature['features'] ?? [] as $feat): ?>
                    <div class="faq-group">
                        <label>Feature Heading</label>
                        <input type="text" name="feature_heading[]"
                            value="<?= htmlspecialchars($feat['heading'] ?? '') ?>">
                        <label>Feature Description</label>
                        <textarea name="feature_desc[]"><?= htmlspecialchars($feat['description'] ?? '') ?></textarea>
                        <button type="button" class="btn btn-danger btn-sm mt-2"
                            onclick="this.parentElement.remove()">Remove</button>
                    </div>
                <?php endforeach; ?>
            </div>
            <button type="button" class="btn btn-outline-primary btn-sm mt-2" onclick="addFeature()">
                + Add Feature
            </button>

            <!-- FAQ -->
            <h3 class="mt-4">FAQ Section</h3>
            <div id="faqContainer">
                <?php foreach ($existing_faqs as $faq): ?>
                    <div class="faq-group">
                        <label>Question</label>
                        <input type="text" name="faq_question[]"
                            value="<?= htmlspecialchars($faq['question'] ?? '') ?>">
                        <label>Answer</label>
                        <textarea name="faq_answer[]"><?= htmlspecialchars($faq['answer'] ?? '') ?></textarea>
                        <button type="button" class="btn btn-danger btn-sm mt-2"
                            onclick="this.parentElement.remove()">Remove</button>
                    </div>
                <?php endforeach; ?>
            </div>
            <button type="button" class="btn btn-outline-primary btn-sm mt-2" onclick="addFAQ()">
                + Add FAQ
            </button>

            <!-- SEO -->
            <h3 class="mt-4">SEO</h3>
            <div class="form-row">
                <label>Meta Title</label>
                <input type="text" name="title"
                    value="<?= htmlspecialchars($city_detail['meta_title'] ?? '') ?>">

                <label class="mt-2">Meta Description</label>
                <textarea name="description" rows="3"><?= htmlspecialchars($city_detail['meta_description'] ?? '') ?></textarea>

                <label class="mt-2">Keywords</label>
                <textarea name="keywords" rows="2"><?= htmlspecialchars($city_detail['keywords'] ?? '') ?></textarea>
            </div>

            <!-- FILE INPUT inside form so it submits -->
            <input type="file" id="galleryInput" name="gallery[]" accept="image/*" multiple style="display:none;">

            <button type="submit" name="submit" class="btn btn-primary mt-4">Update</button>
            <a href="all-city.php" class="btn btn-secondary mt-4">Cancel</a>

        </form>
    </section>


    <!-- GALLERY MODAL -->
    <div class="modal fade" id="galleryModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Images</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="upload-box text-center border rounded p-4"
                        style="border:2px dashed #ccc;min-height:150px;display:flex;justify-content:center;align-items:center;cursor:pointer;"
                        onclick="document.getElementById('galleryInput').click();">
                        <span class="text-muted">Drop images here or click to upload</span>
                    </div>
                    <div id="previewArea" class="d-flex flex-wrap mt-3"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="addImagesBtn">Add Images</button>
                </div>
            </div>
        </div>
    </div>


    <script>
        /* DESCRIPTION */
        function addDescription() {
            let html = `
<div class="faq-group">
    <label>Description</label>
    <textarea name="desc_pera[]"></textarea>
    <button type="button" class="btn btn-danger btn-sm mt-2" onclick="this.parentElement.remove()">Remove</button>
</div>`;
            document.getElementById("descriptionContainer").insertAdjacentHTML("beforeend", html);
        }

        /* FEATURES */
        function addFeature() {
            let html = `
<div class="faq-group">
    <label>Feature Heading</label>
    <input type="text" name="feature_heading[]">
    <label>Feature Description</label>
    <textarea name="feature_desc[]"></textarea>
    <button type="button" class="btn btn-danger btn-sm mt-2" onclick="this.parentElement.remove()">Remove</button>
</div>`;
            document.getElementById("featureContainer").insertAdjacentHTML("beforeend", html);
        }

        /* FAQ */
        function addFAQ() {
            let html = `
<div class="faq-group">
    <label>Question</label>
    <input type="text" name="faq_question[]">
    <label>Answer</label>
    <textarea name="faq_answer[]"></textarea>
    <button type="button" class="btn btn-danger btn-sm mt-2" onclick="this.parentElement.remove()">Remove</button>
</div>`;
            document.getElementById("faqContainer").insertAdjacentHTML("beforeend", html);
        }

        /* DELETE EXISTING IMAGE */
        function deleteImage(btn, path) {
            btn.closest('.img-wrapper').remove();
        }

        /* IMAGE PREVIEW */
        document.getElementById('galleryInput').addEventListener('change', function(e) {
            let previewArea = document.getElementById('previewArea');
            previewArea.innerHTML = "";
            Array.from(e.target.files).forEach(file => {
                let reader = new FileReader();
                reader.onload = function(event) {
                    let img = document.createElement("img");
                    img.src = event.target.result;
                    img.classList.add("preview-img");
                    previewArea.appendChild(img);
                };
                reader.readAsDataURL(file);
            });
        });

        /* ADD IMAGES BUTTON */
        document.getElementById('addImagesBtn').addEventListener('click', function() {
            let gallery = document.querySelector('.gallery-images');
            document.getElementById('previewArea').querySelectorAll('img').forEach(img => {
                let wrapper = document.createElement('div');
                wrapper.className = 'img-wrapper';
                let cloned = img.cloneNode(true);
                let btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'img-delete-btn';
                btn.innerHTML = '&#x2715;';
                btn.title = 'Delete';
                btn.onclick = function() {
                    wrapper.remove();
                };
                wrapper.appendChild(cloned);
                wrapper.appendChild(btn);
                gallery.appendChild(wrapper);
            });
            let modal = bootstrap.Modal.getInstance(document.getElementById('galleryModal'));
            if (modal) modal.hide();
            setTimeout(function() {
                document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
                document.body.classList.remove('modal-open');
                document.body.style = "";
            }, 300);
        });
    </script>
</body>

</html>