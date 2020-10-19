<?php
namespace Drupal\godblessed\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\node\Entity\Node;
use Drupal\Core\Datetime\DrupalDateTime;
/**
* Provides a block with a simple text.
*
* @block(
*   id = "godblessed_first_block_block",
*   admin_label = @block("My first block"),
* )
*/
class FirstBlock extends BlockBase
{
  /**
   * {@block}
   */
  public function build()
  {
    $query = \Drupal::entityQuery('node');
    $query->condition('type', 'page');
    $query->condition('status', 1);
    $query->sort('created', 'DESC');
    $query->range(0, 3);
    /*$date = $query['node']->getCreatedtime();
    $query['date'] = \Drupal::service('date.formatter')->format($date, '$format');*/
    $nids = $query->execute();
    foreach ($nids as $nid) {
      $nodes[] = \Drupal::entityTypeManager()->getStorage('node')->load($nid);
    }

    /*foreach ($nodes as $node) {
      $titles[] = $node->get('title')->value;
      $bodies[] = $node->get('body')->value;
    }*/
      $build = [
        '#theme' => 'godblessing_main_block',
        /*'#titles' => $titles,
        '#bodies' => $bodies,*/
        '#nodes' => $nodes,
    ];
    return $build;

  }
}
