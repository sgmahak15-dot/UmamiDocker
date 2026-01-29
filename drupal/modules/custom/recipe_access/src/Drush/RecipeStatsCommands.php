<?php

namespace Drupal\recipe_access\Drush;

use Drush\Commands\DrushCommands;
use Drupal\search_api\Entity\Index;
use Drupal\taxonomy\Entity\Term;

/**
 * Drush commands for recipe stats.
 */
class RecipeStatsCommands extends DrushCommands {

  /**
   * Outputs recipe statistics.
   *
   * @command recipe:stats
   * @aliases rs
   * @description Outputs total recipes indexed, most common ingredient, and top 5 tags.
   */
  public function stats() {
    $index = Index::load('recipe_server');
    if (!$index) {
      $this->logger()->error('Search API index not found.');
      return;
    }

    // Get all indexed items.
    $query = $index->query();
    $query->keys('*'); // match all
    $results = $query->execute();

    $items = $results->getResultItems();
    $total_recipes = count($items); // get  the count of recipe 

    $ingredients = [];
    $tags = [];

    foreach ($items as $item) {
      $fields = $item->getFields();

      // Get all the Ingredients 
      if (isset($fields['field_ingredients'])) {
        $ingredients = array_merge($ingredients, $fields['field_ingredients']->getValues());
      }

      // Get all the Tags 
      if (isset($fields['field_tags'])) {
        foreach ($fields['field_tags']->getValues() as $tid) {
          $term = Term::load($tid);
          if ($term) {
            $tags[] = $term->getName();// display tag name
          }
        }
      }
    }

    // get most common ingredient
    $most_common_ingredient = $ingredients ? array_search(max(array_count_values($ingredients)), array_count_values($ingredients)) : 'N/A';

    // get top 5 tags
    $tag_counts = array_count_values($tags);
    arsort($tag_counts);
    $top_tags = array_slice($tag_counts, 0, 5, true);

    // cmd output
    $this->output()->writeln("Total recipes indexed: $total_recipes");
    $this->output()->writeln("Most common ingredient: $most_common_ingredient");
    $this->output()->writeln("Top 5 tags:");
    foreach ($top_tags as $tag => $count) {
      $this->output()->writeln(" - $tag ($count)");
    }
  }

}
