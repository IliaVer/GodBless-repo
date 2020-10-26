<?php
/**
 * @file
 * Contains \Drupal\godblessuser\Form\GodBlessedUser.
 */
namespace Drupal\godblessuser\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\user\Entity\User;

class GodUser extends FormBase
{
  /**
   * {@inheritdoc}
   */

  public function getFormId() {
    return 'godblessuser_form';
  }
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['name'] = [
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
      '#title' => $this->t("E-mail:"),
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
    if ($form_state->getValue('confirm_pass') != $form_state->getValue('pass')) {
      $form_state->setErrorByName('pass', t('Password is not correct'));
    }
  }
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $user = User::create();
    $user->set('name', $form_state->getValue('name'));
    $user->set('field_lastname', $form_state->getValue('lastname'));
    $user->setPassword($form_state->getValue('pass'));
    $user->setEmail($form_state->getValue('email'));
    $user->enforceIsNew();
    $user->activate();
    $user->save();
    user_login_finalize($user);
    $form_state->setRedirect('user.page');
    //$uid = \Drupal::currentUser()->id();
    //$user = User::load($uid);

  }
}
