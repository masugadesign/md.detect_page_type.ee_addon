<?php
/*
===============================================================================
File: pi.md_detect_page_type.php
Thread: http://expressionengine.com/forums/viewthread/92307/
Docs: http://www.masugadesign.com/the-lab/scripts/md-detect-page-type/
Misc Related Links:
http://expressionengine.com/forums/viewthread/55700/P18/
-------------------------------------------------------------------------------
Purpose: Detect if the page you are on is a pagination, category, or yearly 
         archive page.
===============================================================================
*/
$plugin_info = array(
						'pi_name'			=> 'MD Detect Page Type',
						'pi_version'			=> '1.0.1',
						'pi_author'			=> 'Ryan Masuga',
						'pi_author_url'		=> 'http://www.masugadesign.com/',
						'pi_description'		=> 'Detect if the page you are on is a pagination, category, or yearly archive page.',
						'pi_usage'			=> Md_detect_page_type::usage()
					);

class Md_detect_page_type {

var $return_data = "";
	
	function Md_detect_page_type()
	{
			global $TMPL, $IN, $FNS, $PREFS;
      $tagdata = $TMPL->tagdata;
			$conds = array();
			$category_word = $PREFS->ini("reserved_category_word");
			
			if ($TMPL->fetch_param('url_segment') !== FALSE)
			{
				$url_segment = $TMPL->fetch_param('url_segment');
			}
			else
			{
				$url_segment = end($IN->SEGS);
			}
			
			$conds['pagination_page'] = (preg_match('/^[P][0-9]+$/i', $url_segment)) ? TRUE : FALSE;
			$conds['category_page'] = (preg_match("/$category_word/", $url_segment)) ? TRUE : FALSE;
			$conds['yearly_archive_page'] = (preg_match("/^\d{4}$/", $url_segment)) ? TRUE : FALSE;

		// Prep output
		$tagdata = $FNS->prep_conditionals($tagdata, $conds);

		// return
		$this->return_data = $tagdata;

	}
    
// ----------------------------------------
//  Plugin Usage
// ----------------------------------------

// This function describes how the plugin is used.
//  Make sure and use output buffering

function usage()
{
ob_start(); 
?>
Useful if you're tying to use a single template to do paginated entries, categories and a single-entry. May have other uses - get creative!

PARAMETERS: 
The tag has one parameter:

1. url_segment - The segment to check. [REQUIRED]

Example usage:
{exp:md_detect_page_type url_segment="{segment_3}"}
Pagination Page: {if pagination_page}This is a Paginated Page{/if}<br />
Category Page: {if category_page}This is a Category Page{/if}<br />
Yearly Archive Page: {if yearly_archive_page}This is a Yearly Archive Page{/if}
{/exp:md_detect_page_type}

<?php
$buffer = ob_get_contents();
	
ob_end_clean(); 

return $buffer;
}
// END

}
?>