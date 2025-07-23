/* global jQuery */
/* global document */
/* global setTimeout */

jQuery(function() {
  'use strict';
  jQuery(document).ready(function() {
    jQuery('#wsftoggleopen').on('click', function() {
      jQuery("body").addClass('wsfvisible');
      setTimeout(function() {
        wsfun1();
      }, 300);
      return false;
    });


    function wsfun1() {
      jQuery("body").addClass('wsfanimated');
      setTimeout(function() {}, 300);
      return false;
    }

    jQuery('#wsftoggleclose').on('click', function() {
      jQuery("body").removeClass('wsfanimated');
      setTimeout(function() {
        wsfun3();
      }, 400);
      return false;
    });

    function wsfun3() {
      jQuery("body").removeClass('wsfvisible');
      setTimeout(function() {}, 400);
      return false;
    }
  });
}());