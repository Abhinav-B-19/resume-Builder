<?php

namespace Drupal\generate\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Request;

class generateController extends ControllerBase {

  public function generate($parameter) {
    $id = $parameter; 

    $connection = mysqli_connect('localhost', 'root', '', 'resume_builder');

    if (!$connection) {
      die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT * FROM `resume_data` WHERE id = $id";
    $result = mysqli_query($connection, $sql);

    $data = mysqli_fetch_assoc($result);
    $title = "Resume of ".$data['name'];

    mysqli_close($connection);

    return [
      '#theme' => 'generate',
      '#title' => $title,
      '#details' => $data,
    ];
  }

}
