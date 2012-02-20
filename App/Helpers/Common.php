<?php
/*
*
* A little helper outer
* A load of common functions that are often used
* Thrown into here to be easily accessed through the
* little framework created here
*
* @autor Ashley Banks
* Created November 2011
*
*/


/**
 * Gets the extension of a file.
 */
function get_extension ( $file )
{
	$path_parts = pathinfo ( $file );
	return $path_parts['extension'];
}


/*
* Grab a specific segement in the URI
* 
* @param $num
* @return uri segment value
*/
function uri_seg ( $num )
{
	$url = $_SERVER['REQUEST_URI'];
	
	$url = str_replace( URI_SPLIT , "" , $url) ;
	
	$uri = preg_split( '[\\/]', $url, -1, PREG_SPLIT_NO_EMPTY );	
	
	return $uri[ $num ];
}

/*
* Converts string into a friendly URL string
* 
* @param $string
* @return the friendly URL
*/
function friendly_url ( $string )
{
	$string = preg_replace( "`\[.*\]`U", "", $string );
	$string = preg_replace( '`&(amp;)?#?[a-z0-9]+;`i', '-', $string );
	$string = htmlentities( $string, ENT_COMPAT, 'utf-8' );
	$string = preg_replace( "`&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig|quot|rsquo);`i", "\\1", $string );
	$string = preg_replace( array( "`[^a-z0-9]`i","`[-]+`") , "-", $string );
	return strtolower( trim( $string, '-' ) );
}

/*
*
* Limit the amount of words for lists and stuff.
* @source - codeIgnitor Framework, as it works perfectly!
*
*/
function word_limiter( $str, $limit = 100, $end_char = '&#8230;' )
{
	if ( trim( $str ) == '' )
	{
		return $str;
	}

	preg_match( '/^\s*+(?:\S++\s*+){1,' . (int)$limit .'}/', $str, $matches );

	if ( strlen( $str ) == strlen( $matches[0] ) )
	{
		$end_char = '';
	}

	return rtrim( $matches[0] ) . $end_char;
}

/*
*
* Create a random password
*
*/
function create_password ()
{ 
	$chars = "abcdefghijkmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ023456789"; 
	
	srand( (double)microtime() * 1000000);
	
	$i = 0; 
	$pass = '' ; 
	while ($i <= 7) 
	{ 
		$num = rand() % 33; 
		$tmp = substr( $chars, $num, 1 ); 
		$pass = $pass . $tmp; 
		$i++; 
	} 
	return $pass; 
}




/*
*  
* Inserts a tag of some kind after a given amount of words
* @param $string - the string to put shit in
* @param $num - the number of words to insert it in
* @param $tags - the tags to put in - default <span>
* 
*/
function insert_tags ( $string, $num, $tags = '</span><span>' )
{
	// Explode the string from spaces.
	$string = explode ( " ", $string );
	
	$result = array();
	
	// Loop through the array incrementing i
    for( $i = 0; $i < sizeof( $string ); $i++ ) 
	{
		// Check that this matches our number and whether to insert tag
        if( $i % $num == 0 && $i != 0 ) 
		{
            $result[] = $tags;
        }
        $result[] = $string[ $i ];
    }
	
	// Implode the result with some spaces.
    $result = implode( ' ', $result );
	
	return $result;
}



/*
*
* FORCE the download upon the server.
*
*/
function force_download ( $filename )
{
	if ( !$filename ) 
	{
		die ( 'must provide a file to download!' );		
	}
	else 
	{
	
		$path = PATH . 'Assets/Uploads/Documents/' . $filename;
		
		if ( file_exists( $path ) && is_readable( $path ) ) {
			
			$size = filesize( $path );
			header( 'Content-Type: application/octet-stream' );
			header( 'Content-Length: ' . $size );
			header( 'Content-Disposition: attachment; filename=' . $filename );
			header( 'Content-Transfer-Encoding: binary' );
		
			$file = fopen( $path, 'rb' );
		
			if ( $file ) 
			{
				fpassthru( $file );
				exit;
			} 
			else 
			{
				echo $err;
			}
		} 
		else 
		{
			die ( 'Appears to be a problem with downloading that file.' );		
		}
	
	}		
}

function format_string ( $the_string )
{
	for ( $i = 0; $i < func_num_args()-1; $i++ )
	{
		$arg = func_get_arg( $i+1 );
		$the_string = str_replace( "{" . $i . "}", $arg, $the_string );
	}
	
	return $the_string;
}

function get_include ( $include )
{
	$contents = file_get_contents ( $_SERVER['DOCUMENT_ROOT'] . '/' . DIRECTORY . '/Assets/Includes/' . ucwords ( $include ) . '.php' );
	return $contents;		
}


?>