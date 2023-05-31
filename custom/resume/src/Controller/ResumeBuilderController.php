<?php

namespace Drupal\resume\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\resume\Form\ResumeBuilderForm;

class ResumeBuilderController extends ControllerBase {

  public function resumeBuilder() {

    $form = \Drupal::formBuilder()->getForm(ResumeBuilderForm::class);

    return [
      '#theme' => 'resumebuilder',
      '#title' => 'Resume Builder',
      '#form' => $form,
    ];
  }



}
