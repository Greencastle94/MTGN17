<?php
include_once("functions_imageresize.php");
include_once("functions_common.php");

$link = connectToDB();

$upload_dir = "images/uploads/gallery/";
$thumb_dir = $upload_dir . "thumbs/";
$large_dir = $upload_dir . "large/";
$original_dir = $upload_dir . "original/";

if (isset($_FILES['file'], $_POST['photographer'])) {
$photographer = $_POST['photographer'];
// $imagedate = $_POST['imagedate'];

if ($_FILES['file']['error'] > 0) {
  echo "Det gick inte att ladda upp bilden.<br/>Error: " . $_FILES['file']['error'];
  exit();
}

$exif = exif_read_data($_FILES['file']['tmp_name']);

if (isset($_POST['date'], $_POST['time'])) {
  $imagecreateddate = date('Y-m-d H:i:s', strtotime($_POST['date'] . ' ' . $_POST['time']));
} else {
  if($exif['DateTimeOriginal'] == null) {
    echo "1";
    exit();
  } else {
    $imagecreateddate = $exif['DateTimeOriginal'];
  }
}

$ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
$id = uniqid();
$imagename = $id . "." . $ext;

$dir = $original_dir . $imagename;

//Skapa thumbnail
$image = new \Eventviva\ImageResize($_FILES['file']['tmp_name']);

$imageWidth = $image->getSourceWidth();
$imageHeight = $image->getSourceHeight();

//Om bredden är större än höjden, skala ner till 200 px på höjden
if ($imageWidth > $imageHeight) {
  $image->resizeToHeight(300);
} else {
  $image->resizeToWidth(300);
}
// Croppa så det blir en kvadrat
$image->crop(300, 300);
$image->save($thumb_dir . $imagename);

//Skapa stor bild
$image = new \Eventviva\ImageResize($_FILES['file']['tmp_name']);
//Om bredden är större än höjden, skala ner till 1024 px på höjden
if ($imageWidth > $imageHeight) {
  $image->resizeToHeight(1200);
} else {
  $image->resizeToWidth(1200);
}
$image->save($large_dir . $imagename);

$date = date("Y-m-d H:i:s");

// echo $imagecreateddate;
//$imagecreateddate = date("Y-m-d H:i:s");
// Skapa posten i databasen
if ($stmt = $link->prepare("INSERT INTO images (imagename, uploaddate, photographer, imagecreateddate) VALUES (?, ?, ?, ?)")) {
  $stmt->bind_param('ssss', $imagename, $date, $photographer, $imagecreateddate);
  $stmt->execute();
  if ($stmt->error) {
    echo "Error: $stmt->error";
  }
}

echo "ok";
} else {
echo "Invalid request.";
}


?>