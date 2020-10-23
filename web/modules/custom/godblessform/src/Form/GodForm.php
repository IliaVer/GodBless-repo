<?php
/**
 * @file
 * Contains \Drupal\godblessform\Form\GodForm.
 */
namespace Drupal\godblessform\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\node\Entity\Node;
use Drupal\node\Entity\NodeType;

class GodForm extends FormBase
{
  /**
   * {@inheritdoc}
   */

  public function getFormId() {
    return 'godform_form';
  }
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['title'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Title:'),
    ];
    $form['body'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Body:'),
    ];

    $types = [];
    foreach (NodeType::loadMultiple() as $type) {
      $types[$type->get('type')] = $type->get('name');
    }
    $form['types'] = [
      '#type' => 'select',
      '#title' => $this->t('Type of Node:'),
      '#options' => $types,
    ];

    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Save'),
      '#button_type' => 'primary',
    ];
    return $form;
  }

  public function validateForm(array &$form, FormStateInterface $form_state)
  {

    if (empty(strlen($form_state->getValue('title')))) {
      $form_state->setErrorByName('title', $this->t('Title is empty'));
    }
    if (empty(strlen($form_state->getValue('body')))) {
      $form_state->setErrorByName('body', $this->t('Body is empty'));
    }
  }
  public function submitForm(array &$form, FormStateInterface $form_state) {
      $node = Node::create(['type' => $form_state->getValue('types')]);
      $node->set('title', $form_state->getValue('title'));
      $node->set('body', $form_state->getValue('body'));
      $node->enforceIsNew();
      $node->save();
  }
}
