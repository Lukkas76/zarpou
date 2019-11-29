<?php 

class MY_Form_validation extends CI_Form_validation
{
	/**
     * Encodes a string.
     * 
     * @param string $string The string to encrypt.
     * @param string $key[optional] The key to encrypt with.
     * @param bool $url_safe[optional] Specifies whether or not the
     *                returned string should be url-safe.
     * @return string
     */
    

	/**
	 * Alpha
	 *
	 * @access	public
	 * @param	string
	 * @return	bool
	 */
	public function alpha_whitespace($str)
	{
		return ( ! preg_match("/^([a-zà-ú\s])+$/i", $str)) ? FALSE : TRUE;
	}

	/**
	 * Alpha Numeric
	 *
	 * @access	public
	 * @param	string
	 * @return	bool
	 */
	public function alphanumeric_whitespace($str)
	{
		return ( ! preg_match("/^([a-zà-ú0-9\s])+$/i", $str)) ? FALSE : TRUE;
	}


}
