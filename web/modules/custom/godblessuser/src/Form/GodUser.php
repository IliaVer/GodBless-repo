<?php
/**
 * @file
 * Contains \Drupal\godblessuser\Form\GodBlessedUser.
 */
namespace Drupal\godblessuser\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\user\Entity\User;

class GodUser extends FormBase {

  /**
   * {@inheritdoc}
   */

  public function getFormId() {
    return 'godblessuser_form';
  }
  public function buildForm(array $form, FormStateInterface $form_state) {
    if (empty($form_state->get('step')) || $form_state->get('step') == 1) {
      $form_state->set('step', 1);
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

    }

    if ($form_state->get('step') == 2) {
      $form['policy'] = [
        '#type' => 'checkbox',
        '#title' => $this->t('Private Policy:'),
      ];
    }

    if ($form_state->get('step') < 2) {
      $button_label = $this->t('Next');
    }
    else {
      $button_label = $this->t('Submit');
    }

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $button_label,
    ];

    return $form;

  }

  public function validateForm(array &$form, FormStateInterface $form_state)  {
    if ($form_state->getValue('confirm_pass') != $form_state->getValue('pass')) {
      $form_state->setErrorByName('pass', t('Password is not correct'));
    }
    if ($form_state->get('step') == 2 & (empty($form_state->getValue('policy')))) {
      $form_state->setErrorByName('policy', t('You should accept our privacy policy'));
    }
    parent::validateForm($form, $form_state);
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    if ($form_state->get('step') < 2) {
      $form_state->set('step', 2);
      $form_state->setRebuild();
      $form_state->set('name', $form_state->getValue('name'));
      $form_state->set('lastname', $form_state->getValue('lastname'));
      $form_state->set('pass', $form_state->getValue('pass'));
      $form_state->set('email', $form_state->getValue('email'));
    }
    else {
      $form_state->set('step', 1);
      $user = User::create();
      $user->set('name', $form_state->get('name'));
      $user->set('field_lastname', $form_state->get('lastname'));
      $user->setPassword($form_state->get('pass'));
      $user->setEmail($form_state->get('email'));
      $user->enforceIsNew();
      $user->activate();
      $user->save();
      user_login_finalize($user);
      $form_state->setRedirect('user.page');
    }
  }
}
