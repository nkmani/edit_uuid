<?php

namespace Drupal\edit_uuid\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
/**
 * Configure edit_uuid settings for this site.
 */
class EditUuidSettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'edit_uuid_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'edit_uuid.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('edit_uuid.settings');
   $node_types = node_type_get_types();
    if (empty($node_types)) {
      return NULL;
    }
   $options = [];
   foreach ($node_types as $node_type => $type) {
    $options[$node_type] = $type->get('name');
    }
    $form['bundle'] = array(
      '#title' => t('Bundle'),
      '#type' => 'checkboxes',
      '#description' => t('Check the content types that you wish to add restriction on deletion'),
      '#options' => $options,
      '#default_value' => $config->get('bundle'),
    );

  
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('edit_uuid.settings')
      ->set('bundle', $form_state->getValue('bundle'))
      ->save();

    parent::submitForm($form, $form_state);
  }

}
