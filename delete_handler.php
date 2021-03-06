<?php
include_once("functions_common.php");
$link = connectToDB();

if(session_id() == ''){ session_start(); }

if ($_SESSION["admin"])
{
    switch($_POST["action"]){
      case 'image':
        if (isset($_POST['id'])) {
          $id = $_POST['id'];

          /*if (!unlink('images/uploads/gallery/original/' . $id)) {
            echo "Det gick inte att radera originalversionen av bilden.";
          }*/

          if (!unlink('images/uploads/gallery/large/' . $id)) {
            echo "Det gick inte att radera den stora versionen av bilden.";
          }

          if (!unlink('images/uploads/gallery/thumbs/' . $id)) {
            echo "Det gick inte att radera den lilla versionen av bilden.";
          }

          if ($stmt = $link->prepare("DELETE FROM images WHERE imagename = ? LIMIT 1")) {
            $stmt->bind_param('s', $id);
            $stmt->execute();
          } else {
            echo "Det gick inte att radera bilden. ";
            if ($stmt->error){
              echo $stmt->error;
            }
          }

        } else {
          echo "Invalid request";
      }
      break;

      case 'blandaren':
        if (isset($_POST['id'])) {
          $id = $_POST['id'];

          // Hämta uppgifter
          $stmt = $link->prepare("SELECT blandarpdf, frontpage FROM blandare WHERE blandarid = ? LIMIT 1");
          $stmt->bind_param('s', $id);
          $stmt->execute();
          $stmt->store_result();
          $stmt->bind_result($blandarpdf, $frontpage);
          $stmt->fetch();

          if (!unlink('images/uploads/blandaren/pdfs/' . $blandarpdf)) {
            echo "Det gick inte att radera pdfen.";
            exit();
          }

          if (!unlink('images/uploads/blandaren/frontpages/' . $frontpage)) {
            echo "Det gick inte att radera framsidan.";
            exit();
          }

          if ($stmt = $link->prepare("DELETE FROM blandare WHERE blandarid = ? LIMIT 1")) {
            $stmt->bind_param('s', $id);
            $stmt->execute();
          } else {
            echo "Det gick inte att radera från databasen. ";
            if ($stmt->error){
              echo $stmt->error;
            }
          }

        } else {
          echo "Invalid request";
        }
        break;

      case 'video':
        if (isset($_POST['id'])) {
          $id = $_POST['id'];

          if ($stmt = $link->prepare("DELETE FROM videos WHERE videoid = ? LIMIT 1")) {
            $stmt->bind_param('s', $id);
            $stmt->execute();
          } else {
            echo "Det gick inte att radera videon. ";
            if ($stmt->error){
              echo $stmt->error;
            }
          }

        } else {
          echo "Invalid request";
        }
        break;

      default:
        echo 'Invalid Request!';
        break;
    }
}
