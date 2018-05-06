<?php

/**
 * Define all the error messages of the system
 */
abstract class ErrorMessages {

    //region Fields

    const NULL_ARGUMENT = "The parameter name %s could not be null or empty";

    //endregion Fields

    //region Format

    /**
     * Format the exception string associate to a null argument
     */
    public static function null_argument(string $argumentName) {
        return sprintf(ErrorMessages::NULL_ARGUMENT, $argumentName);
    }

    //endregion
}