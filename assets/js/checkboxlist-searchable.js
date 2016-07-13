/**
 * This script adds input box to do the text search for relation widgets
 * Usable to look through checkboxes when there are thousands of possible relations
 */

+function ($) {

  /**
   *
   * Adds search box and binds events to it
   *
   */
  var attachSearch = function () {
    var searchInput = '<div class="form-group" style="width:70%;padding-top:15px;"><input type="text" placeholder="Search" class="form-control search-checkboxes"></div>';
    var $checkbox = $(this).find('div.checkbox').first();
    $checkbox.before(searchInput);
    $checkbox.parent().find('input.search-checkboxes').on('keyup', searchCheckboxes);
  };


  /**
   *
   * Performs search through checkboxes, hides those not containing query
   *
   * @param e
   */
  var searchCheckboxes = function () {
    var query = this.value.toLocaleLowerCase();
    $(this).parents('div.field-checkboxlist').find('div.checkbox').each(function () {
      var labelText = $(this).find('label').text();
      if (labelText.toLocaleLowerCase().indexOf(query) != -1) {
        $(this).show();
      } else {
        $(this).hide();
      }
    });
  };


  /**
   * Searches for all checkboxlists and attach search box to each one
   */
  var initCheckboxlistSearch = function () {
    // we add only to scrollable lists (non scrollable are short)
    var $widgets = $('div.field-checkboxlist-scrollable');
    $widgets.each(attachSearch);
  };


  /**
   * document.ready callback
   */
  $(document).ready(function () {
    initCheckboxlistSearch();
  });

} (window.jQuery);
