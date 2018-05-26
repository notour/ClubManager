<?php

declare(strict_types=1);

/**
 * Define a class in charge to render templates
 */
interface IRenderer {

    const Traits = "IRenderer";

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
    function render_template(string $template_path, array $data_context = null);

    //endregion
}