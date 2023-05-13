<?php
/**
 * Results block.
 *
 * @package HivePress\Blocks
 */

namespace HivePress\Blocks;

use HivePress\Helpers as hp;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Wraps and renders query results.
 */
class Results extends Container {

	/**
	 * Renders block HTML.
	 *
	 * @return string
	 */
	public function render() {
		$output = '';

		if ( have_posts() || hivepress()->request->get_context( 'featured_ids' ) ) {
			$output .= parent::render();
		} elseif ( ! $this->optional ) {
			//echo "no reSULT HERE....";
			//exit;
			echo "<pre>";
			print_r($_REQUEST);
			echo "<pre>";
			if($_REQUEST['latitude']!="")
			{
				$newRequest	=	array("nearby"=>1);
				foreach($_REQUEST as $reqParamName=>$reqParamValue)
				{
					if($reqParamName=="latitude" || $reqParamName=="longitude")
					{
						continue;
					}
					
					$newRequest[]=	$reqParamName."=".$reqParamValue;
					
				}
				$newReqString	=	implode("&",$newRequest);
				// find out the QueryString:
				//$queryString = $_SERVER['QUERY_STRING'];
				// put it all together:
				
				$newRedirectURL = "https://obosbxstag.wpengine.com/?". $newReqString;
				echo	 "<script type='text/javascript'>
								window.location.href = '$newRedirectURL';
							</script>";
				//echo "New URL without Lat/Long is :<br>".$newRedirectURL;
				//exit;
			}
			else
			{
				$output .= ( new Part( [ 'path' => 'page/no-results-message' ] ) )->render();
			}
		}

		return $output;
	}
}
