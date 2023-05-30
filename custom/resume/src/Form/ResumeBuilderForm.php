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

    $form['personal_details']['webiste'] = [
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
      '#title' => $this->t('Phone'),
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

    $form['educational_details']['educational_qualification'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Educational Qualification'),
      '#required' => TRUE,
    ];

    $form['educational_details'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Educational Details'),
    ];

    $form['educational_details']['educational_qualification'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Educational Qualification'),
      '#required' => TRUE,
    ];

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

    $form['educational_details']['10th']['school_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('School Name'),
      '#required' => TRUE,
    ];

    $form['educational_details']['10th']['mark'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Mark'),
      '#required' => TRUE,
    ];

    $form['educational_details']['10th']['passing_year'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Passing Year'),
      '#required' => TRUE,
    ];

    //  ==================================== 10th ========================================== 

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
    $form['educational_details']['post_graduation']['extra_form_wrapper']['college_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('College Name'),
      '#states' => [
        'visible' => [
          ':input[name="post_graduation"]' => ['value' => 'yes'],
        ],
      ],
      '#required' => $show_extra_form,
    ];

    $form['educational_details']['post_graduation']['extra_form_wrapper']['marks'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Marks'),
      '#states' => [
        'visible' => [
          ':input[name="post_graduation"]' => ['value' => 'yes'],
        ],
      ],
      '#required' => $show_extra_form,
    ];

    $form['educational_details']['post_graduation']['extra_form_wrapper']['passout'] = [
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
    // $form['skills'] = [
    //   '#type' => 'fieldset',
    //   '#title' => $this->t('Skill Form'),
    //   '#prefix' => '<div id="skill-form-wrapper">',
    //   '#suffix' => '</div>',
    // ];
    
    // $num_skills = $form_state->get('num_skills') ?: 1;
    
    // for ($i = 0; $i < $num_skills; $i++) {
    //   $form['skills'][$i] = [
    //     '#type' => 'textfield',
    //     '#title' => $this->t('Skill'),
    //   ];
    // }
    
    // $form['skills']['add_skill'] = [
    //   '#type' => 'submit',
    //   '#value' => $this->t('Add Skill'),
    //   '#submit' => ['::addSkillCallback'],
    //   '#ajax' => [
    //     'callback' => '::addSkillAjaxCallback',
    //     'wrapper' => 'skill-form-wrapper',
    //     'effect' => 'fade',
    //   ],
    // ];

    // ===========>Retrieve the stored skills from the form state
    // $form['skills'] = [
    //   '#type' => 'fieldset',
    //   '#title' => $this->t('Skill Form'),
    //   '#prefix' => '<div id="skill-form-wrapper">',
    //   '#suffix' => '</div>',
    // ];
    
    // $num_skills = $form_state->get('num_skills') ?: 0; // Adjust the initial value
    
    // for ($i = 1; $i <= $num_skills; $i++) { // Start the loop from 1
    //   $form['skills'][$i] = [
    //     '#type' => 'textfield',
    //     '#title' => $this->t('Skill'),
    //     '#default_value' => $form_state->hasValue(['skills', $i]) ? $form_state->getValue(['skills', $i]) : '',
    //   ];
    // }
    
    // $form['skills']['add_skill'] = [
    //   '#type' => 'submit',
    //   '#value' => $this->t('Add Skill'),
    //   '#submit' => ['::addSkillCallback'],
    //   '#ajax' => [
    //     'callback' => '::addSkillAjaxCallback',
    //     'wrapper' => 'skill-form-wrapper',
    //     'effect' => 'fade',
    //   ],
    // ];

    $form['skillset'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Skills'),
    ];

    $form['skills'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Skill Form'),
      '#prefix' => '<div id="skill-form-wrapper">',
      '#suffix' => '</div>',
    ];
  
    $num_skills = $form_state->get('num_skills') ?: 0;
  
    for ($i = 0; $i < $num_skills; $i++) {
      $form['skills'][$i] = [
        '#type' => 'textfield',
        '#title' => $this->t('Skill'),
        '#default_value' => $form_state->hasValue(['skills', $i]) ? $form_state->getValue(['skills', $i]) : '',
      ];
    }
  
    $form['skills']['add_skill'] = [
      '#type' => 'submit',
      '#value' => $this->t('Add Skill'),
      '#submit' => ['::addSkillCallback'],
      '#ajax' => [
        'callback' => '::addSkillAjaxCallback',
        'wrapper' => 'skill-form-wrapper',
        'effect' => 'fade',
      ],
    ];
    
    
    // =================== skills =========================

    //  ================== Intern =========================
    $form['intern'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Internship / Employeement Details'),
    ];

    $form['intern']['company_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Company Name'),
      '#required' => TRUE,
    ];

    $form['intern']['years'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Years'),
    ];

    $form['intern']['role'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Role'),
      '#required' => TRUE,
    ];

    // =================== Intern =========================
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];
    
    return $form;
    }
    
    public function addSkillCallback(array &$form, FormStateInterface $form_state) {
      $num_skills = $form_state->get('num_skills') ?: 0; // Adjust the initial value
      $form_state->set('num_skills', $num_skills + 1);
      $form_state->setRebuild();
    }
    
    public function addSkillAjaxCallback(array &$form, FormStateInterface $form_state) {
      return $form['skills'];
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

  }


  public function submitForm(array &$form, FormStateInterface $form_state) {
    $name = $form_state->getValue('name');
    $profession = $form_state->getValue('nameprofession');
    $email = $form_state->getValue('email');
    $phoneNo = $form_state->getValue('phone');
    $address = $form_state->getValue('address');
    $educational_qualification = $form_state->getValue('educational_qualification');
    
    // Store all skills in an array
    $skills = [];
  $num_skills = $form_state->get('num_skills') ?: 0;

  for ($i = 0; $i < $num_skills; $i++) {
    $skill_value = $form_state->getValue(['skills', $i]);

    if (!empty($skill_value)) {
      $skills[] = $skill_value;
    }
  }

  $skills_json = json_encode($skills);
    $response = new AjaxResponse();
    $response->addCommand(new ReplaceCommand('.student-form-container', $this->t($skills_json)));

    
    $tenth = $form_state->getValue('10th');
    $tenth_school_name = $form_state->getValue(['school_name']);
    $tenth_marks = $form_state->getValue(['mark']);
    $tenth_passing_year = $form_state->getValue(['passing_year']);
    
    $graduation_college_name = $form_state->getValue(['graduation_college_name']);
    $graduation_cgpa = $form_state->getValue(['graduation_cgpa']);
    $graduation_passing_year = $form_state->getValue(['graduation_passing_year']);
    
    $post_graduation = $form_state->getValue('post_graduation');
    $college_name = '';
    $marks = '';
    $passout = '';
    
    if ($post_graduation === 'yes') {
      $college_name = $form_state->getValue(['college_name']);
      $marks = $form_state->getValue(['marks']);
      $passout = $form_state->getValue(['passout']);
    }

    $company_name =  $form_state->getValue(['company_name']);
    $years = $form_state->getValue(['years']);
    $role = $form_state->getValue(['role']);

    $skillset = $form_state->getValue(['skillset']);
    
    // Perform database insertion here
    // Replace this with your own database saving logic
    $connection = mysqli_connect('localhost', 'root', '', 'resume_builder');
    if (!$connection) {
      die("Connection failed: " . mysqli_connect_error());
    }
    
    // Prepare and execute the query
    $query = "INSERT INTO `res_data`(`name`, `profession`, `email`, `phoneNo`, `address`, `educational_qualification`, `post_graduation`, `college_name`, `mark`, `passout`, `graduation_college_name`, `graduation_cgpa`, `graduation_passing_year`, `10th`, `10th_school_name`, `10th_marks`, `10th_passing_year`, `skills`, `company_name`, `years`, `role`, `skillset`) 
          VALUES ('$name', '$profession', '$email', '$phoneNo', '$address', '$educational_qualification', '$post_graduation', '$college_name', '$marks', '$passout', '$graduation_college_name', '$graduation_cgpa', '$graduation_passing_year', '$tenth', '$tenth_school_name', '$tenth_marks', '$tenth_passing_year', '$skills_json', '$company_name', '$years', '$role', '$skillset')";

    $result = mysqli_query($connection, $query);

    if (mysqli_query($connection, $query)) {
      $this->messenger()->addStatus($this->t('Details added successfully.'));
    } else {
      $this->messenger()->addError($this->t('Failed to add details. Please try again.'));
    }

    $id = mysqli_insert_id($connection);
    
    mysqli_close($connection);

    // $this->clearStoredValues($form_state);
    // $form_state->set('current_page', NULL);
    $form_state->setRebuild();


    $url = "/generate/" . $id;

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