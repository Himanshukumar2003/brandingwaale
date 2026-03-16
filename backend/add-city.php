<?php
include "db.php";

if (isset($_POST['submit'])) {

    $heading         = mysqli_real_escape_string($conn, $_POST['heading']);
    $hero_heading    = mysqli_real_escape_string($conn, $_POST['hero_heading']);
    $hero_subheading = mysqli_real_escape_string($conn, $_POST['hero_subheading']);

    if (!is_dir('uploads')) {
        mkdir('uploads', 0777, true);
    }

    /* IMAGE UPLOAD */
    // FIX 1: Changed $_FILES key from 'file_urls' to 'gallery' to match the HTML input name="gallery[]"

    $uploadedFiles = [];

    if (!empty($_FILES['gallery']['name'][0])) {

        $uploadDir = "uploads/city/";

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $allowed = ['jpg', 'jpeg', 'png', 'webp'];

        foreach ($_FILES['gallery']['tmp_name'] as $key => $tmpName) {

            if ($_FILES['gallery']['error'][$key] == 0) {

                $ext = strtolower(pathinfo($_FILES['gallery']['name'][$key], PATHINFO_EXTENSION));

                if (!in_array($ext, $allowed)) continue;

                $filename = time() . '_' . rand(1000, 9999) . '_' . basename($_FILES['gallery']['name'][$key]);

                $target = $uploadDir . $filename;

                if (move_uploaded_file($tmpName, $target)) {
                    $uploadedFiles[] = $target;
                }
            }
        }
    }

    // FIX 2: Was named $gallery (string), but INSERT used undefined $image_json.
    // Now storing as JSON and using $image_json consistently.
    $image_json = mysqli_real_escape_string($conn, json_encode($uploadedFiles));

    /* DESCRIPTION */

    $descriptions = [];

    if (!empty($_POST['desc_pera'])) {
        foreach ($_POST['desc_pera'] as $pera) {
            $descriptions[] = $pera;
        }
    }

    $description_json = mysqli_real_escape_string($conn, json_encode($descriptions));

    /* FEATURES */
    // FIX 3: Loop used $heading as the loop variable, overwriting the page heading.
    // Renamed loop variable to $heading_feature.

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

            $faqs[] = [
                "question" => $q,
                "answer"   => $_POST['faq_answer'][$key] ?? ''
            ];
        }
    }

    $faq_json = mysqli_real_escape_string($conn, json_encode($faqs));

    /* SEO */

    $title            = mysqli_real_escape_string($conn, $_POST['title']);
    $meta_description = mysqli_real_escape_string($conn, $_POST['description']);
    $keywords         = mysqli_real_escape_string($conn, $_POST['keywords']);

    /* INSERT QUERY */
    // FIX 4: Was using undefined $image_json — now correctly defined above.

    $sql = "INSERT INTO city 
        (heading, hero_heading, hero_subheading, images, description_section, feature_section, faq_section, meta_title, meta_description, keywords)
        VALUES
        ('$heading', '$hero_heading', '$hero_subheading', '$image_json', '$description_json', '$feature_json', '$faq_json', '$title', '$meta_description', '$keywords')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('City Added Successfully');</script>";
    } else {
        echo mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add City</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@shoelace-style/shoelace@2.0.0-beta.83/dist/themes/light.css" />
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
    </style>
</head>

<body>

    <?php include('sidenav.php') ?>

    <section class="main-content">

        <h2 class="text-white mb-5">Add City</h2>

        <!-- FIX 5: enctype is present (was already correct), kept as-is -->
        <form method="POST" enctype="multipart/form-data" class="form-card">

            <!-- HEADING -->
            <div class="form-row">
                <label>Heading</label>
                <input type="text" name="heading" required>
            </div>

            <!-- HERO HEADING -->
            <div class="form-row">
                <label>Hero Heading</label>
                <input type="text" name="hero_heading">
            </div>

            <!-- HERO SUBHEADING -->
            <div class="form-row">
                <label>Hero Subheading</label>
                <textarea name="hero_subheading"></textarea>
            </div>

            <!-- GALLERY -->
            <div class="gallery-box">
                <h3>Gallery</h3>
                <button type="button" class="btn btn-sm btn-primary"
                    data-bs-toggle="modal"
                    data-bs-target="#galleryModal">
                    Add Images
                </button>
                <div class="gallery-images mt-3 d-flex flex-wrap"></div>
            </div>

            <!-- DESCRIPTION -->
            <h3 class="mt-4">Description Section</h3>
            <div id="descriptionContainer"></div>
            <button type="button" class="btn btn-outline-primary btn-sm" onclick="addDescription()">
                + Add Description
            </button>

            <!-- FEATURES -->
            <h3 class="mt-4">Features Section</h3>
            <div class="form-row">
                <label>Main Heading</label>
                <input type="text" name="feature_main_heading">
            </div>
            <div class="form-row">
                <label>Main Description</label>
                <textarea name="feature_main_desc"></textarea>
            </div>
            <div id="featureContainer"></div>
            <button type="button" class="btn btn-outline-primary btn-sm" onclick="addFeature()">
                + Add Feature
            </button>

            <!-- FAQ -->
            <h3 class="mt-4">FAQ Section</h3>
            <div id="faqContainer"></div>
            <button type="button" class="btn btn-outline-primary btn-sm" onclick="addFAQ()">
                + Add FAQ
            </button>

            <!-- SEO -->
            <h3 class="mt-4">SEO</h3>
            <div class="form-row">
                <label>Meta Title</label>
                <input type="text" name="title">
                <label class="mt-2">Meta Description</label>
                <textarea name="description"></textarea>
                <label class="mt-2">Keywords</label>
                <textarea name="keywords"></textarea>
            </div>

            <button type="submit" name="submit" class="btn btn-primary mt-4">Publish</button>

        </form>

    </section>


    <!-- GALLERY MODAL -->
    <div class="modal fade" id="galleryModal">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Add Images</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <!--
                        FIX 6: Input name changed from gallery[] to gallery[] and moved INSIDE the main
                        form via JS transfer, so files are actually submitted with the form.
                        The actual <input type="file"> must be inside the <form> tag to be submitted.
                        We handle this by cloning the input into the form on "Add Images" click.
                    -->
                    <input type="file"
                        id="galleryInput"
                        multiple
                        accept="image/*"
                        style="display:none;">

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

        /* ADD IMAGES BUTTON
           FIX 6 (continued): Move the file input into the main form so it gets submitted,
           then set name="gallery[]" so PHP reads $_FILES['gallery'] correctly.
        */
        document.getElementById('addImagesBtn').addEventListener('click', function() {

            // Show thumbnails in the gallery preview area
            let gallery = document.querySelector('.gallery-images');
            let preview = document.getElementById('previewArea');
            gallery.innerHTML = preview.innerHTML;

            // Move the actual file input inside the form so it submits
            let fileInput = document.getElementById('galleryInput');
            fileInput.name = 'gallery[]'; // matches $_FILES['gallery'] in PHP
            document.querySelector('form').appendChild(fileInput);

            // Close modal
            let modalElement = document.getElementById('galleryModal');
            let modal = bootstrap.Modal.getInstance(modalElement);
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