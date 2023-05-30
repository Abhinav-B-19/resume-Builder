<?php

namespace Drupal\resume\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\resume\Form\ResumeBuilderForm;

class ResumeBuilderController extends ControllerBase {

  public function resumeBuilder() {
    $connection = mysqli_connect('localhost', 'root', '', 'resume_builder');

    if (!$connection) {
      die("Connection failed: " . mysqli_connect_error());
    }

    $resumeData = mysqli_query($connection, "SELECT * FROM `res_data` WHERE 1");

    $form = [];

    $form = \Drupal::formBuilder()->getForm(ResumeBuilderForm::class);

    mysqli_close($connection);

    return [
      '#theme' => 'resume',
      '#title' => 'Resume Details',
      '#details' => $resumeData,

      // '#absentstudent' => $absentees,
      // '#attdictionary' => $dictionary,
      // '#ids' => $ids,
      // '#atts' => $att,
      '#form' => $form,
    ];
  }

}
