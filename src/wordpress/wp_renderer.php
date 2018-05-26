<?php

declare(strict_types=1);

require_once dirname( __FILE__ ) . '/../clubmanager_const.php';

require_once CD_PLUGIN_INTERFACES_PATH . 'view/irenderer.php';

/**
 * Render the content page using the wordpress template system
 */
final class WPRenderer implements IRenderer {

    //region Methods

    /**
     * Render the specific template using the data context pass in argument
     * 
     * @param string $template_path
     *      absolute path to the php template file
     * 
     * @param array $data_context
     *      data context that contains all the data needed to render a specific page
     */
    function render_template(string $template_path, array $data_context = null) {
        echo render_template($template_path, $data_context);
    }

    //endregion
}