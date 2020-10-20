<?php
/**
 * @file
 * Contains \Drupal\godblessuser\Form\GodBlessedUser.
 */
namespace Drupal\godblessuser\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\node\Entity\Node;
use Drupal\node\Entity\NodeType;
use Drupal\user\Entity\User;

class GodBlessedUser extends FormBase
{
  /**
   * {@inheritdoc}
   */

  public function getFormId() {
    return 'godblessuser_form';
  }
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['firstname'] = [
      '#type' => 'textfield',
      '#title' => $this->t('First name:'),
      '#required' => TRUE,
    ];
    $form['lastname'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Last name:'),
      '#required' => TRUE,
    ];
    $form['pass'] = [
      '#type' => 'password',
      '#title' => $this->t('Password:'),
      '#required' => TRUE,
    ];
    $form['confirm_pass'] = [
      '#type' => 'password',
      '#title' => $this->t('Confirm password:'),
      '#required' => TRUE,
    ];
    $form['email'] = [
      '#type' => 'textfield',
      '#title' => $this->t("E-mail;"),
      '#required' => TRUE,
    ];

    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Save'),
      '#button_type' => 'primary',
    ];
    return $form;
  }

  public function validateForm(array &$form, FormStateInterface $form_state)  {

  }
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $user = \Drupal\user\Entity\User::create();
    $user->set();
  }
}

