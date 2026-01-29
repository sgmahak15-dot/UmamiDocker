<?php

namespace Drupal\recipe_access\Plugin\views\access;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Session\AccountInterface;
use Drupal\views\Plugin\views\access\AccessPluginBase;

/**
 * Access plugin for recipe search.
 *
 * @ViewsAccess(
 *   id = "recipe_search_access",
 *   title = @Translation("Recipe search permission"),
 *   help = @Translation("Access based on 'search recipes' permission.")
 * )
 */
class RecipeSearchAccess extends AccessPluginBase {

  public function access(AccountInterface $account) {
    return AccessResult::allowedIfHasPermission($account, 'search recipes');
  }

}
