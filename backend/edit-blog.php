<?php
session_start();
include 'db.php';

$edit_blog_id = $_GET['id'];
$blog = mysqli_query($conn, "SELECT * FROM blogs WHERE id='$edit_blog_id'");
$blog_detail = mysqli_fetch_assoc($blog);

if (isset($_POST['submit'])) {
    extract($_POST);
    $date = date('Y-m-d');

    // Slug
    if (empty($slug)) {
        $slug = strtolower($heading);
        $slug = preg_replace('/[^a-z0-9\s-]/', '', $slug);
        $slug = preg_replace('/\s+/', '-', $slug);
        $slug = trim($slug, '-');
    }

    $slug = mysqli_real_escape_string($conn, $_POST['slug']);

    // Sanitize
    $title = mysqli_real_escape_string($conn, $title);
    $content = mysqli_real_escape_string($conn, $content);
    $description = mysqli_real_escape_string($conn, $description);
    $short_description = mysqli_real_escape_string($conn, $short_description);
    $keywords = mysqli_real_escape_string($conn, $keywords);
    $publish_status = isset($publish_status) ? mysqli_real_escape_string($conn, $publish_status) : '0';

    // FAQs
    $faqs = [];
    if (!empty($_POST['faq_question'])) {
        foreach ($_POST['faq_question'] as $key => $q) {
            $question = mysqli_real_escape_string($conn, $q);
            $answer = mysqli_real_escape_string($conn, $_POST['faq_answer'][$key]);
            if (!empty($question) && !empty($answer)) {
                $faqs[] = ['question' => $question, 'answer' => $answer];
            }
        }
    }
    $faq_json = mysqli_real_escape_string($conn, json_encode($faqs));

    // Handle image upload
    $uploadedFiles = [];
    if (!empty($_FILES['file_urls']['name'][0])) {
        $uploadDir = "uploads/blogs/";
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

        foreach ($_FILES['file_urls']['tmp_name'] as $key => $tmpName) {
            if ($_FILES['file_urls']['error'][$key] == 0) {
                $filename = time() . "_" . basename($_FILES['file_urls']['name'][$key]);
                $target = $uploadDir . $filename;
                if (move_uploaded_file($tmpName, $target)) {
                    $uploadedFiles[] = $target;
                }
            }
        }
    }

    // Merge new uploads with old ones
    if (!empty($uploadedFiles)) {
        $gallery = mysqli_real_escape_string($conn, implode(",", $uploadedFiles));
    } else {
        $gallery = $blog_detail['image'];
    }


    $getslug = mysqli_query($conn, "SELECT `slug` FROM `blogs` WHERE `slug` = '$slug'");
    if (mysqli_num_rows($getslug) > 0) {
        $alertmsg = '<sl-alert variant="danger" open duration="3000" closable>
                        <span class="mdi mdi-alpha-x-circle-outline"></span>
                        Duplicate Slug found
                     </sl-alert>';
        echo "<div class='sl-toast-stack'>$alertmsg</div>";
    }

    // Update Query
    $query = mysqli_query($conn, "UPDATE `blogs` SET
            `heading`           = '$heading',
            `short_description` = '$short_description',
            `content`           = '$content',
            `image`             = '$gallery',
            `slug`              = '$slug',
            `title`             = '$title',
            `description`       = '$description',
            `keyword`           = '$keywords',
            `faqs`              = '$faq_json',
            `status`            = '$publish_status',
            `date`              = '$date'
        WHERE id='$edit_blog_id'");

    if ($query) {
        $_SESSION['msg'] = '<sl-alert variant="success" open duration="1500" closable>
                        <span class="mdi mdi-check-circle-outline"></span>                  
                        Blog Updated Successfully
                      </sl-alert>';
        header('location:all-blogs.php');
        exit;
    } else {
        $_SESSION['msg'] = "<sl-alert variant='danger' open duration='3000' closable>
                         <span class='mdi mdi-alpha-x-circle-outline'></span>
                         Failed to Update Blog
                       </sl-alert>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Blog</title>
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@shoelace-style/shoelace@2.0.0-beta.83/dist/themes/light.css" />

    <script src="https://cdn.jsdelivr.net/npm/@tinymce/tinymce-webcomponent@2/dist/tinymce-webcomponent.min.js">
    </script>

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

        .btn-primary {
            background: #c4a574;
            border: none;
        }

        .gallery-box {
            border: 1px solid #ddd;
            border-radius: 6px;
            padding: 15px;
            margin-top: 20px;
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
        <h2>Edit Blog</h2>

        <form method="POST" enctype="multipart/form-data" class="form-card">

            <div class="form-row">
                <label>Blog Title</label>
                <input type="text" name="heading" value="<?= htmlspecialchars($blog_detail['heading']) ?>" required />
            </div>

            <!-- SLUG FIELD -->
            <div class="form-row">
                <label for="slug">Permalink (Slug)</label>
                <input type="text" name="slug" id="slug" placeholder="auto-generated-url"
                    value="<?= htmlspecialchars($blog_detail['slug']) ?>" />
                <small style="color:#777">
                    URL Preview:
                    <span id="slugPreview" style="color:#c4a574; font-weight:600;">
                        /blogs
                    </span>
                </small>
            </div>


            <div class="form-row">
                <label>Short Description</label>
                <textarea name="short_description" rows="3"
                    required><?= htmlspecialchars($blog_detail['short_description']) ?></textarea>
            </div>

            <div class="form-row">
                <label>Blog Content</label>
                <tinymce-editor api-key="26eohrlp913qxavz9xyrl5wszw74jii703o230piigrz0ync" height="500"
                    menubar="file edit view insert format tools table help"
                    plugins="print preview paste importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media codesample table charmap hr pagebreak nonbreaking anchor insertdatetime advlist lists wordcount textpattern noneditable help charmap quickbars emoticons"
                    toolbar="undo redo | blocks fontfamily fontsize | bold italic underline strikethrough forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media table codesample | removeformat | fullscreen preview code help"
                    name="content"><?= htmlspecialchars($blog_detail['content']) ?></tinymce-editor>
            </div>

            <!-- Gallery -->
            <div class="gallery-box">
                <h3>Gallery</h3>
                <div class="card-body">
                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                        data-bs-target="#galleryModal">
                        <i class="mdi mdi-plus me-1"></i> Add Images
                    </button>
                    <div class="gallery-images mt-3 d-flex flex-wrap">
                        <?php
                        if (!empty($blog_detail['image'])) {
                            $images = explode(",", $blog_detail['image']);
                            foreach ($images as $img) {
                                echo "<img src='$img' class='preview-img'>";
                            }
                        }
                        ?>
                    </div>
                </div>


            </div>

            <!-- FAQs -->
            <div class="mt-4">
                <h3>FAQs</h3>
                <div id="faqContainer">
                    <?php
                    $faqData = json_decode($blog_detail['faqs'], true);
                    if (!empty($faqData)) {
                        foreach ($faqData as $faq) {
                            echo '
                            <div class="faq-group">
                                <label>FAQ Question</label>
                                <input type="text" name="faq_question[]" value="' . htmlspecialchars($faq['question']) . '" required>
                                <label class="mt-2">FAQ Answer</label>
                                <textarea name="faq_answer[]" required>' . htmlspecialchars($faq['answer']) . '</textarea>
                                <button type="button" class="btn btn-sm btn-danger mt-2" onclick="this.parentElement.remove()">Remove</button>
                            </div>';
                        }
                    }
                    ?>
                </div>
                <button type="button" class="btn btn-outline-primary btn-sm" onclick="addFAQ()">+ Add FAQ</button>
            </div>

            <h3 class="mt-3 mb-2">Seo</h3>
            <div class="form-row   p-3 rounded">
                <label>Meta Title</label>
                <input type="text" name="title" value="<?= htmlspecialchars($blog_detail['title']) ?>" />

                <label>Meta Description</label>
                <textarea name="description" rows="3"><?= htmlspecialchars($blog_detail['description']) ?></textarea>

                <label>Keywords</label>
                <textarea name="keywords" rows="2"><?= htmlspecialchars($blog_detail['keyword']) ?></textarea>
            </div>



            <!-- Publish/Unpublish -->
            <div class="form-row mt-4">
                <label><strong>Publish Status</strong></label>
                <div>
                    <label><input type="radio" name="publish_status" value="1"
                            <?= $blog_detail['status'] == 'published' ? 'checked' : '' ?>> Publish</label>
                    &nbsp;&nbsp;
                    <label><input type="radio" name="publish_status" value="0"
                            <?= $blog_detail['status'] != 'published' ? 'checked' : '' ?>> Unpublish</label>
                </div>
            </div>

            <!-- Hidden File Input -->
            <input type="file" id="galleryInput" name="file_urls[]" accept="image/*" multiple style="display:none;">

            <div class="form-actions mt-4">
                <button type="submit" name="submit" class="btn btn-primary">Update</button>
                <a href="all-blogs.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </section>

    <!-- Gallery Modal -->
    <div class="modal fade" id="galleryModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Add Images</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="upload-box text-center border rounded p-4"
                        style="border:2px dashed #ccc; min-height:150px; display:flex; justify-content:center; align-items:center; cursor:pointer;"
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
        // Gallery Preview
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
                }
                reader.readAsDataURL(file);
            });
        });

        document.getElementById('addImagesBtn').addEventListener('click', function() {
            let gallery = document.querySelector('.gallery-images');
            gallery.innerHTML = document.getElementById('previewArea').innerHTML;
            let modal = bootstrap.Modal.getInstance(document.getElementById('galleryModal'));
            modal.hide();
        });

        // Add FAQ
        function addFAQ() {
            const container = document.getElementById('faqContainer');
            const faqHTML = `
                <div class="faq-group">
                    <label>FAQ Question</label>
                    <input type="text" name="faq_question[]" placeholder="Enter FAQ question" required>
                    <label class="mt-2">FAQ Answer</label>
                    <textarea name="faq_answer[]" placeholder="Enter FAQ answer" required></textarea>
                    <button type="button" class="btn btn-sm btn-danger mt-2" onclick="this.parentElement.remove()">Remove</button>
                </div>`;
            container.insertAdjacentHTML('beforeend', faqHTML);
        }
    </script>


    <script>
        // convert title → slug
        function generateSlug(text) {
            return text
                .toLowerCase()
                .trim()
                .replace(/[^a-z0-9\s-]/g, '') // remove special chars
                .replace(/\s+/g, '-') // space to dash
                .replace(/-+/g, '-'); // remove double dash
        }

        const headingInput = document.getElementById('heading');
        const slugInput = document.getElementById('slug');
        const slugPreview = document.getElementById('slugPreview');

        let userEditedSlug = false;

        // when user types in slug manually
        slugInput.addEventListener('input', function() {
            userEditedSlug = true;
            slugPreview.innerText = "/blogs/" + slugInput.value;
        });

        // auto create slug from title
        headingInput.addEventListener('keyup', function() {

            // only auto update if user hasn't manually edited
            if (!userEditedSlug) {
                let slug = generateSlug(this.value);
                slugInput.value = slug;
                slugPreview.innerText = "/blogs/" + slug;
            }
        });
    </script>
</body>

</html>