<?php
function create() {
    $searchFor = 'mail';
    $url = 'https://loremflickr.com/320/240/' . $searchFor;

    $folderPath = 'images/';
    $filename = $folderPath . 'image_' . time() . '.jpg';
    $imageContent = file_get_contents($url);

    if ($imageContent !== false) {
        file_put_contents($filename, $imageContent);

        $currentUrl = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
        $imageUrl = $currentUrl . '/' . $filename;
        return $imageUrl;
    } else {
        echo "Failed to retrieve the image.";
    }
}