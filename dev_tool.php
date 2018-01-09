<?php

if ( ! function_exists('write_log')) {
   function write_log ( $log )  {
      if ( is_array( $log ) || is_object( $log ) ) {
         error_log( print_r( $log, true ) );
      } else {
         error_log( $log );
      }
   }
}

/**
 * Function used to render a template php file to html output
 * 
 * @param string $template_file
 *      full path of the template file
 * 
 * @param array $variables
 *      all the variables used to render the template
 * 
 * @return string Html page
 */
function render_template($template_file, array $variables) {

    // Extract the variables to a local namespace
    extract($variables, EXTR_SKIP);

    // Start output buffering
    ob_start();

    // Include the template file
    include $template_file;

    // End buffering and return its contents
    return ob_get_clean();
}