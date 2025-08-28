<?php
require_once "../../../vendor/autoload.php"; // Include Composer autoloader

use Blacksoulgem95\CbiLib\CBILib;

// Initialize variables to store results or errors
$result = "";
$error = "";

// Handle file upload and processing
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES["cbiFile"])) {
    $file = $_FILES["cbiFile"];

    // Check if file was uploaded without errors
    if ($file["error"] === UPLOAD_ERR_OK) {
        $tmpName = $file["tmp_name"];
        $fileName = basename($file["name"]);

        // Process the file using CBILib
        try {
            $cib = new CBILib();
            $resultData = $cib->processCBIFile($tmpName); // Using the correct method
            // Convert result to string for display if it's an array
            $result = is_array($resultData)
                ? print_r($resultData, true)
                : $resultData;
            $result = htmlspecialchars($result); // Escape for HTML display
        } catch (Exception $e) {
            $error =
                "Error processing file: " . htmlspecialchars($e->getMessage());
        }
    } else {
        $error = "File upload error: " . $file["error"];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CBI Document Processor</title>
    <link rel="stylesheet" href="https://unpkg.com/xp.css" />
    <style>
        .container {
            padding: 2em;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="window">
            <div class="title-bar">
                <div class="title-bar-text">CBI Document Processor</div>
            </div>
            <div class="window-body">
                <form method="POST" enctype="multipart/form-data">
                    <fieldset>
                        <legend>Upload CBI Document</legend>
                        <p>Select a CBI file to process:</p>
                        <input type="file" name="cbiFile" accept=".cbi,.txt" required>
                        <br><br>
                        <button type="submit">Process File</button>
                    </fieldset>
                </form>
            </div>
        </div>

        <?php if ($_SERVER["REQUEST_METHOD"] === "POST"): ?>
            <div class="window" style="margin-top: 2em;">
                <div class="title-bar">
                    <div class="title-bar-text">Processing Result</div>
                </div>
                <div class="window-body">
                    <?php if (!empty($error)): ?>
                        <p class="error"><?php echo $error; ?></p>
                    <?php elseif (!empty($result)): ?>
                        <pre><code><?php echo $result; ?></code></pre>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
