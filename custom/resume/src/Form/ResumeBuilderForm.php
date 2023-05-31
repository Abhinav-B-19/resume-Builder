<?php

namespace Drupal\resume\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Component\Utility\EmailValidator;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\ReplaceCommand;
use Symfony\Component\HttpFoundation\RedirectResponse;


/**
 * Implements hook_form() to create a custom form.
 */
class ResumeBuilderForm extends FormBase
{

  public function getFormId()
  {
    return 'resume_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state)
  {
    $form['personal_details'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Personal Details'),
    ];

    $form['personal_details']['name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Name'),
      '#required' => TRUE,
    ];

    $form['personal_details']['profession'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Profession'),
      '#required' => FALSE,
    ];

    $form['personal_details']['website'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Website'),
      '#required' => FALSE,
    ];

    $form['personal_details']['email'] = [
      '#type' => 'email',
      '#title' => $this->t('Email'),
      '#required' => TRUE,
    ];

    $form['personal_details']['phone'] = [
      '#type' => 'tel',
      '#title' => $this->t('Phone Number'),
      '#required' => TRUE,
    ];

    $form['personal_details']['address'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Address'),
      '#required' => TRUE,
    ];

    $form['educational_details'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Educational Details'),
    ];

    // $form['educational_details']['educational_qualification'] = [
    //   '#type' => 'textfield',
    //   '#title' => $this->t('Educational Qualification'),
    //   '#required' => TRUE,
    // ];

    // $form['educational_details'] = [
    //   '#type' => 'fieldset',
    //   '#title' => $this->t('Educational Details'),
    // ];

    // $form['educational_details']['educational_qualification'] = [
    //   '#type' => 'textfield',
    //   '#title' => $this->t('Educational Qualification'),
    //   '#required' => TRUE,
    // ];

    //  ==================================== 10th ==========================================
    // $form['educational_details']['10th'] = [
    //   '#type' => 'textfield',
    //   '#title' => $this->t('10th'),
    //   '#required' => TRUE,
    // ];
    $form['educational_details']['10th'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('10th Grade'),
      '#collapsible' => TRUE,
      '#collapsed' => FALSE,
    ];

    $form['educational_details']['10th']['high_school_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('School Name'),
      '#required' => TRUE,
    ];

    $form['educational_details']['10th']['high_school_marks'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Mark Scored'),
      '#required' => TRUE,
    ];

    $form['educational_details']['10th']['high_school_pyear'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Passing Year'),
      '#required' => TRUE,
    ];

    //  ==================================== 10th ========================================== 
    // ===================================== 12th ==========================================
    $form['educational_details']['12th'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('12th Grade'),
      '#collapsible' => TRUE,
      '#collapsed' => FALSE,
    ];

    $form['educational_details']['12th']['higher_secondary_sname'] = [
      '#type' => 'textfield',
      '#title' => $this->t('School Name'),
      '#required' => TRUE,
    ];

    $form['educational_details']['12th']['higher_secondary_marks'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Mark Scored'),
      '#required' => TRUE,
    ];

    $form['educational_details']['12th']['higher_secondary_pyear'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Passing Year'),
      '#required' => TRUE,
    ];
    // ===================================== 12th ==========================================

    //  ================================== Graduation ======================================
    // $form['educational_details']['graduation'] = [
    //   '#type' => 'textfield',
    //   '#title' => $this->t('Graduation'),
    //   '#required' => TRUE,
    // ];
    $form['educational_details']['graduation'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Graduation'),
      '#collapsible' => TRUE,
      '#collapsed' => FALSE,
    ];

    $form['educational_details']['graduation']['graduation_college_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('College Name'),
      '#required' => TRUE,
    ];

    $form['educational_details']['graduation']['graduation_cgpa'] = [
      '#type' => 'textfield',
      '#title' => $this->t('CGPA'),
      '#required' => TRUE,
    ];

    $form['educational_details']['graduation']['graduation_passing_year'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Year of Passing'),
      '#required' => TRUE,
    ];

    //  ================================== Graduation ======================================
    // ===================post graduation ===============
    // $form['educational_details']['post_graduation'] = [
    //   '#type' => 'textfield',
    //   '#title' => $this->t('Post Graduation'),
    //   '#required' => TRUE,
    // ];

    $form['educational_details']['post_graduation'] = [
      '#type' => 'radios',
      '#title' => $this->t('Post Graduation'),
      '#options' => [
        'no' => $this->t('No'),
        'yes' => $this->t('Yes'),
      ],
      '#required' => TRUE,
      '#default_value' => 'no',
      '#ajax' => [
        'callback' => '::postGraduationAjaxCallback',
        'wrapper' => 'extra-form-wrapper',
      ],
    ];

    $form['educational_details']['post_graduation']['extra_form_wrapper'] = [
      '#type' => 'container',
      '#attributes' => ['id' => 'extra-form-wrapper'],
    ];

    $show_extra_form = $form_state->getValue('post_graduation') == 'yes';
    $form['educational_details']['post_graduation']['extra_form_wrapper']['post_graduation_cname'] = [
      '#type' => 'textfield',
      '#title' => $this->t('College Name'),
      '#states' => [
        'visible' => [
          ':input[name="post_graduation"]' => ['value' => 'yes'],
        ],
      ],
      '#required' => $show_extra_form,
    ];

    $form['educational_details']['post_graduation']['extra_form_wrapper']['post_graduation_marks'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Marks'),
      '#states' => [
        'visible' => [
          ':input[name="post_graduation"]' => ['value' => 'yes'],
        ],
      ],
      '#required' => $show_extra_form,
    ];

    $form['educational_details']['post_graduation']['extra_form_wrapper']['post_graduation_pyear'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Passed out year'),
      '#states' => [
        'visible' => [
          ':input[name="post_graduation"]' => ['value' => 'yes'],
        ],
      ],
      '#required' => $show_extra_form,
    ];
    // ===================post graduation ===============

    // =================== skills =========================
    $form['skills'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Skills'),
    ];
    // $form['skills_wrapper'] = [
    //   '#type' => 'fieldset',
    //   '#title' => $this->t('Skills'),
    //   '#prefix' => '<div id="skills-wrapper">',
    //   '#suffix' => '</div>',
    // ];

    // $skills = $form_state->get('num_skills');
    // if (empty($skills)) {
    //   $skills = 1;
    //   $form_state->set('num_skills', $skills);
    // }

    // for ($i = 0; $i < $skills; $i++) {
    //   $form['skills_wrapper']['skills'][$i] = [
    //     '#type' => 'container',
    //     '#attributes' => ['class' => ['skill-item']],
    //   ];

    //   $form['skills_wrapper']['skills'][$i]['skill'] = [
    //     '#type' => 'textfield',
    //     '#title' => $this->t('Skill'),
    //     '#required' => TRUE,
    //   ];

    //   $form['skills_wrapper']['skills'][$i]['level'] = [
    //     '#type' => 'select',
    //     '#title' => $this->t('Level'),
    //     '#required' => TRUE,
    //     '#options' => [
    //       'Beginner' => $this->t('Beginner'),
    //       'Intermediate' => $this->t('Intermediate'),
    //       'Advanced' => $this->t('Advanced'),
    //     ],
    //   ];
    // }

    // $form['skills_wrapper']['add_skill'] = [
    //   '#type' => 'button',
    //   '#value' => $this->t('Add Skill'),
    //   '#ajax' => [
    //     'callback' => '::addSkillAjaxCallback',
    //     'wrapper' => 'skills-wrapper',
    //   ],
    // ];

    // =================== skills ========================= 

    // =================== intern =========================
    $form['intern'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Intern / Employeement Details'),
    ];

    $form['intern']['cname'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Company Name'),
      '#required' => TRUE,
    ];

    $form['intern']['cyear'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Years'),
      '#required' => TRUE,
    ];
    $form['intern']['crole'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Role'),
      '#required' => TRUE,
    ];

    // =================== intern =========================
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];

    return $form;
  }

  public function addSkillAjaxCallback(array &$form, FormStateInterface $form_state)
  {
    $skills = $form_state->get('num_skills');
    $skills++;

    $form_state->set('num_skills', $skills);
    $form_state->setRebuild(TRUE);

    return $form['skills_wrapper'];
  }





  /**
   * Form submission handler for adding a skill form.
   */
  /**
   * Form validation handler for the email field.
   */
  public function validateForm(array &$form, FormStateInterface $form_state)
  {
    $email = $form_state->getValue('email');
    $email_validator = new EmailValidator();

    if (!$email_validator->isValid($email)) {
      $form_state->setErrorByName('email', $this->t('Please enter a valid email address.'));
    }

    $skills = $form_state->get('num_skills');

    for ($i = 0; $i < $skills; $i++) {
      if (empty(trim($form_state->getValue(['skills_wrapper', 'skills', $i, 'skill'])))) {
        $form_state->setErrorByName("skills][{$i}][skill", $this->t('Please enter a skill.'));
      }
    }
  }


  public function submitForm(array &$form, FormStateInterface $form_state)
  {
    $name = $form_state->getValue('name');
    $profession = $form_state->getValue('profession');
    $website = $form_state->getValue('website');
    $email = $form_state->getValue('email');
    $phoneNo = $form_state->getValue('phone');
    $address = $form_state->getValue('address');
    // $educational_qualification = $form_state->getValue('educational_qualification');


    // $tenth = $form_state->getValue('10th');
    $high_school_name = $form_state->getValue(['high_school_name']);
    $high_school_marks = $form_state->getValue(['high_school_marks']);
    $high_school_pyear = $form_state->getValue(['high_school_pyear']);

    // $twelth = $form_state->getValue('12th');
    $higher_secondary_sname = $form_state->getValue(['higher_secondary_sname']);
    $higher_secondary_marks = $form_state->getValue(['higher_secondary_marks']);
    $higher_secondary_pyear = $form_state->getValue(['higher_secondary_pyear']);

    // $graduation = $form_state->getValue('graduation');
    $graduation_college_name = $form_state->getValue(['graduation_college_name']);
    $graduation_cgpa = $form_state->getValue(['graduation_cgpa']);
    $graduation_passing_year = $form_state->getValue(['graduation_passing_year']);


    $post_graduation = $form_state->getValue('post_graduation');
    $post_graduation_cname = '';
    $post_graduation_marks = '';
    $post_graduation_pyear = '';

    if ($post_graduation == 'yes') {
      $post_graduation_cname = $form_state->getValue(['post_graduation_cname']);
      $post_graduation_marks = $form_state->getValue(['post_graduation_marks']);
      $post_graduation_pyear = $form_state->getValue(['post_graduation_pyear']);

    }

    $skills = $form_state->getValue(['skills']);

    $cname = $form_state->getValue(['cname']);
    $cyear = $form_state->getValue(['cyear']);
    $crole = $form_state->getValue(['crole']);

    $connection = mysqli_connect('localhost', 'root', '', 'resume_builder');

    if (!$connection) {
      die("Connection failed: " . mysqli_connect_error());
    }

    // $query = "INSERT INTO `res_data`(`name`, `email`, `phoneNo`, `address`, `educational_qualification`, `post_graduation`, `college_name`, `mark`, `passout`, `graduation`, `10th`) VALUES ('$name', '$email', '$phoneNo', '$address', '$educational_qualification', '$post_graduation', '$college_name', '$marks', '$passout', '$graduation', '$tenth')";
    $query = "INSERT INTO `resume_data`(`name`, `profession`, `website`, `email`, `phoneNo`, `address`, `high_school_name`, `high_school_marks`, `high_school_pyear`, `higher_secondary_sname`, `higher_secondary_marks`, `higher_secondary_pyear`, `graduation_college_name`, `graduation_cgpa`, `graduation_passing_year`, `post_graduation`, `post_graduation_cname`, `post_graduation_marks`, `post_graduation_pyear`, `skills`, `cname`, `cyear`, `crole`) 
    VALUES ('$name', '$profession', '$website', '$email', '$phoneNo', '$address', '$high_school_name', '$high_school_marks', '$high_school_pyear', '$higher_secondary_sname', '$higher_secondary_marks', '$higher_secondary_pyear', '$graduation_college_name', '$graduation_cgpa', '$graduation_passing_year', '$post_graduation', '$post_graduation_cname', '$post_graduation_marks', '$post_graduation_pyear', '$skills', '$cname', '$cyear', '$crole')";



    $result = mysqli_query($connection, $query);

    if ($result) {
      $this->messenger()->addStatus($this->t('Details added successfully.'));
      } else {
        $this->messenger()->addError($this->t('Failed to add details. Please try again.'));
      }

      $id = $id = mysqli_insert_id($connection);
      
      mysqli_close($connection);

      // $this->clearStoredValues($form_state);
      // $form_state->set('current_page', NULL);
      $form_state->setRebuild();


      $url = "/resume_builder/generate/" . $id;

      $response = new RedirectResponse($url);
      $response->send();
    }
  



  // private function storeFormData($name,$email,$phoneNo,$address,$educational_qualification,$post_graduation,$graduation,$tenth)
  // {
  //   $connection = mysqli_connect('localhost', 'root', '', 'resume_builder');

  //   if (!$connection) {
  //     die("Connection failed: " . mysqli_connect_error());
  //   }

  //   $query = "UPDATE `res_data` SET `resId`='' name`='$name',`email`='$email',`phoneNo`='$phoneNo',`address`='$address',`educational_qualification`='$educational_qualification',`post graduation`='$post_graduation',`graduation`='$graduation',`10th`='$tenth'";
  //   mysqli_query($connection, $query);
  // }

}