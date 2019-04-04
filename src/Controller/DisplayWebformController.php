<?php

namespace Drupal\webform_links\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\webform\Entity\Webform;
use Drupal\Core\Link;

/**
 * Class DisplayWebformController.
 */
class DisplayWebformController extends ControllerBase {

  /**
   * List.
   *
   * @return string
   *   Return Hello string.
   */
  public function list() {

    $query = $this->entityTypeManager()->getStorage('webform')->getQuery();
    $entity_ids = $query->condition('status', 'open')->execute();
    $webform_id = array();
    foreach($entity_ids as $webid){
      $webform_id[]=$webid;
    }

    $webforms = Webform::loadMultiple($webform_id);
    $webform_urls = [];
    foreach($webforms as $webform){
      $webform_urls[] = Link::fromTextAndUrl($webform->get('title'), $webform->toUrl());
    }

    $content = [
      '#theme' => 'item_list',
      '#list_type' => 'ul',
      '#items' => $webform_urls,
      '#attributes' => ['class' => 'mylist'],
      '#wrapper_attributes' => ['class' => 'container'],
    ];

    return $content;

  }

}
