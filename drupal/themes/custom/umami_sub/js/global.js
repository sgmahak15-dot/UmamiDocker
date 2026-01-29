(function ($, Drupal) {
  Drupal.behaviors.globalAutocompleteFix = {
    attach: function (context, settings) {

      // Select all autocomplete inputs once per context
      $('input.form-autocomplete', context).once('globalAutocompleteFix').each(function () {
        var $input = $(this);

        // Only proceed if autocomplete is initialized
        if ($input.data('ui-autocomplete')) {
          // Append dropdown to body to fix top-of-page issue
          $input.autocomplete('option', 'appendTo', 'body');
        }
      });
    }
  };
})(jQuery, Drupal);
