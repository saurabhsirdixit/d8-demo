<?php 
/**
 * @File
 * Contains \Drupal\axl_d8_form\Form\AxlForm.
 */
 namespace Drupal\axl_d8_form\Form;

 use Drupal\Core\Form\FormBase;
 use Drupal\Core\Form\ConfigFormBase;
 use Drupal\Core\Form\FormStateInterface;

 class AxlForm extends ConfigFormBase {
  
  /**
   * Get FormId
   */
  public function getFormId() {
    return 'axl_form';
  }

  /** 
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'custom.settings',
    ];
  }

  /**
   * Create Custom Form 
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('custom.settings');

    $form['candidate_name'] = array(
      '#type' => 'textfield',
      '#title' => t('Pet Name:'),
      '#default_value' => $config->get('candidate_name'),
      '#required' => TRUE,
    );
    $form['candidate_mail'] = array(
      '#type' => 'email',
      '#title' => t('Secondary Email ID:'),
      '#default_value' => $config->get('candidate_mail'),
      '#required' => TRUE,
    );
    $form['candidate_number'] = array (
      '#type' => 'tel',
      '#title' => t('Mobile no'),
      '#default_value' => $config->get('candidate_number'),
    );
    $form['candidate_dob'] = array (
      '#type' => 'date',
      '#title' => t('DOB'),
      '#default_value' => $config->get('candidate_dob'),
      '#required' => TRUE,
    );
    $form['candidate_gender'] = array (
      '#type' => 'select',
      '#title' => ('Gender'),
      '#default_value' => $config->get('candidate_gender'),
      '#options' => array(
        'Female' => t('Female'),
        'male' => t('Male'),
      ),
    );
    $form['candidate_message'] = array (
      '#type' => 'textarea',
      '#title' => ('Any Message'),
      '#placeholder' => 'Enter your message',
      '#default_value' => $config->get('candidate_message'),
    );
    $form['candidate_confirmation'] = array (
      '#type' => 'radios',
      '#title' => ('Are you above 18 years old?'),
      '#default_value' => $config->get('candidate_confirmation'),
      '#options' => array(
        'Yes' =>t('Yes'),
        'No' =>t('No')
      ),
    );
    $form['candidate_copy'] = array(
      '#type' => 'checkbox',
      '#title' => t('Send me a copy of the application.'),
      '#default_value' => $config->get('candidate_copy'),
    );
    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Save'),
      '#button_type' => 'primary',
    );
    return $form;
  }

  /**
   * Validate form method
   */
  public function validateForm(array &$form, FormStateInterface $form_state){
    if (strlen($form_state->getValue('candidate_number')) < 10) {
      $form_state->setErrorByName('candidate_number', $this->t('Mobile number is too short.'));
    }
  }

  /**
   * Submit method
   */
  public function submitForm(array &$form, FormStateInterface $form_state){
    /**
     * Show form submitted values on page screen
     */
    drupal_set_message($this->t('@can_name ,Your application is being submitted!', array('@can_name' =>
     $form_state->getValue('candidate_name'))));
    foreach ($form_state->getValues() as $key => $value) {
      drupal_set_message($key . ': ' . $value);
    }

    // Retrieve the configuration
    $this->configFactory->getEditable('custom.settings')
    ->set('candidate_name', $form_state->getValue('candidate_name'))
    ->set('candidate_mail', $form_state->getValue('candidate_mail'))
    ->set('candidate_number', $form_state->getValue('candidate_number'))
    ->set('candidate_gender', $form_state->getValue('candidate_gender'))
    ->set('candidate_message', $form_state->getValue('candidate_message'))
    ->set('candidate_confirmation', $form_state->getValue('candidate_confirmation'))
    ->set('candidate_copy', $form_state->getValue('candidate_copy'))
    ->save();
  }


}
?>