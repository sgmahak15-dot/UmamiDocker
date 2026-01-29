<?php

namespace Drupal\recipe_access\Plugin\search_api\processor;

use Drupal\search_api\Item\ItemInterface;
use Drupal\search_api\Processor\ProcessorPluginBase;
use Drupal\search_api\Processor\ProcessorProperty;
use Drupal\search_api\Datasource\DatasourceInterface;

/**
 * Adds an Ingredient Count property to the Search API index.
 *
 * @SearchApiProcessor(
 *   id = "ingredient_count",
 *   label = @Translation("Ingredient Count"),
 *   description = @Translation("Indexes the number of ingredients per recipe."),
 *   stages = {
 *     "add_properties" = 0,
 *     "add_field_values" = 0
 *   }
 * )
 */
class IngredientCount extends ProcessorPluginBase {

  /**
   * {@inheritdoc}
   */
  public function getPropertyDefinitions(DatasourceInterface $datasource = NULL) {
    $properties = [];

    if ($datasource && $datasource->getPluginId() === 'entity:node') {
      $properties['ingredient_count'] = new ProcessorProperty([
        'label' => $this->t('Ingredient Count'),
        'description' => $this->t('Number of ingredients in the recipe'),
        'type' => 'integer',
        'processor_id' => $this->getPluginId(),
        // bind to datasource
        'datasource_id' => $datasource->getPluginId(),
      ]);
    }

    return $properties;
  }

  /**
   * {@inheritdoc}
   */
  public function addFieldValues(ItemInterface $item) {
    // Only node datasource.
    if ($item->getDatasourceId() !== 'entity:node') {
      return;
    }

    $original = $item->getOriginalObject();
    if (!$original) {
      return;
    }

    /** @var \Drupal\node\NodeInterface $node */
    $node = $original->getValue();

    // Only recipes.
    if ($node->bundle() !== 'recipe') {
      return;
    }

    // Get ingredient count.
    $count = 0;
    if ($node->hasField('field_ingredients')) {
      $count = count(array_filter($node->get('field_ingredients')->getValue()));
    }

    
    $fields = $this->getFieldsHelper()
      ->filterForPropertyPath(
        $item->getFields(),
        $item->getDatasourceId(),
        'ingredient_count'
      );

    foreach ($fields as $field) {
      $field->addValue($count);
    }
  }

}
