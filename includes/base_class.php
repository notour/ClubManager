<?php

/**
 * base class
 */
abstract class BaseClass {

    //region methods

    //region accessors

    // Check for property accessibility
	private final function _accessible_fct($name)
	{
		// Check for available accessors
		if ((method_exists($this, "set_$name")) || 
			(method_exists($this, "get_$name")))
			return true;
		
		// // Inform dev why access to a field was denied
		// throw new Exception((property_exists($this, $name) == false) 
		// 			? "Property $name does not exist"
		// 			: "Property $name not _accessible_fct");
		return FALSE;
	}
    
    /**
     * getter
     */
	public final function __get($name) 
	{
		if ($this->_accessible_fct($name))
		{
			// call get accessor
			if (method_exists($this, "get_$name"))
				return $this->{"get_$name"}();
			else
				throw new Exception("Writeonly Property $name");	
		}
	}
 
    /**
     * setter
     */
	public final function __set($name, $value)
	{
		if ($this->_accessible_fct($name))
		{
			// call set accessor (if available)
			if (method_exists($this, "set_$name"))
				$this->{"set_$name"}($value);
			else
				throw new Exception("Readonly Property $name");
		}
	}

    //endregion accessors

    //endregion methods
}