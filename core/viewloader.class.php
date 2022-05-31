<?php
/*
* ViewLoader Class
* by Timothy 'TiM' Oliver
* http://www.timoliver.com.au
*
* A class that handles blending of dynamic data with an HTML template
* following the design of the Model-View-Controller paradigm.
* 
* ============================================================================
* 
* Copyright (C) 2011 by Tim Oliver
* 
* Permission is hereby granted, free of charge, to any person obtaining a copy
* of this software and associated documentation files (the "Software"), to deal
* in the Software without restriction, including without limitation the rights
* to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
* copies of the Software, and to permit persons to whom the Software is
* furnished to do so, subject to the following conditions:
* 
* The above copyright notice and this permission notice shall be included in
* all copies or substantial portions of the Software.
* 
* THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
* IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
* FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
* AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
* LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
* OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
* THE SOFTWARE.
* 
*/

class ViewLoader
{
	/* Relative route to the templates folder */
	var $route = '';
	
	/*acceptable file extensions for templates */
	var $template_ext = NULL;
	
	/**
	* Class Constructor
	*
	* @param String $template_dir Absolute (or relative from the calling script) path of the location of the templates directory
	*/
	function __construct( $template_dir )
	{	
		$this->template_ext = '.php';
		
		if( strpos( $template_dir, '/' ) !== 0 )
			$template_dir = $template_dir;
			
		$this->route = $template_dir;
	}
	
	/**
	* Load template
	* 
	* Load the target template file into the class.
	* If no extension was supplied, then it will search for files
	* with compatible extensions, else it will validate the file
	* 
	* NB: All variables in this method are prefixed with a '_'
	* to stop any potential conflicts with variable names extracted from $data
	*
	* @param String $_template	Relative from the templates dir, the name of the template file to load.
	* @param String $_data  	Associative array of data that will be applied to the template (array('foo' => 'bar') -> $foo = 'bar')
	* @param Bool 	$_echo 		Whether this function should echo the calculated output, or simply return it as a string
	*/
	function load_template( $_template, $_data = NULL, $_echo = true )
	{
		
		//append the file extension if not supplied
		if( strpos( $_template, $this->template_ext ) === FALSE )
			$_template .= $this->template_ext;
			
		//set the working dir to the templates folder
		//(save current working dir to revert to when we're done)
		$_cwd = getcwd();
		chdir($this->route);
		
		//load the file into the class. Throw an exception if it fails for some reason
		if( ($_template_data = file_get_contents( $_template ) ) === FALSE ) 
		{
			chdir( $_cwd );
			throw new Exception( 'TemplateController: Was unable to open template file: '.$this->route.$_template );
			return FALSE;
		}

		//if data is an array, break out all of its keys into variables
		if( isset( $_data) && is_array( $_data ) )
			extract( $_data, EXTR_OVERWRITE );

		//start a new output buffering session to collect all of the printed data
		ob_start();

		//evalutate the code
		//(IMPORTANT: PHP documentation states that a trailing space is needed
		// for the <?php brace to be picked up.)
		eval( '?> '.$_template_data.' <?php ' );

		//retrieve the output from the eval
		$_output = ob_get_contents();

		//close the buffering session
		ob_end_clean();

		//revert the working dir to default
		chdir( $_cwd );
		
		//output the resulting text based on parameters
		if( $_echo )
			echo $_output;
		else
			return $_output;
			
		return TRUE;
	}
	
	/**
	* Add template Extension
	* 
	* Sets another extension other than '.php' for loading
	* template files
	*
	* @param String $ext The new file extension to use.
	*/
	function set_template_ext( $ext = NULL )
	{
		//make sure the extension starts with a .
		if( strpos( $ext, '.' ) !== 0 )
			$ext = '.'.$ext;
		
		$this->template_ext = $ext;
	}
	
}

/*EOF*/