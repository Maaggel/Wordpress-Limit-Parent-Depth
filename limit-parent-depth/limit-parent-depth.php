<?php
/**
 * Plugin Name: Limit Parent Depth
 * Text Domain: limitparentdepth
 * Description: Limit the Parent selector, and menu builder depth to a selected max level
 * Author:      Mikkel Bundgaard @ Inspire Me
 * Author URI:  http://inspireme.dk/
 * Version:     1.0.0
 *
 * @package WordPress
 * @author  Mikkel Bundgaard <info@inspireme.dk>
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version 2017-06-07
 */

/**
 * Preset options
 */
$preset = (object)array(
    "limit"                     => 0,
    "limitParentSelector"       => true,
    "limitMenuLevel"            => true
);

//Set the limit
$limit = getLimit();

//Javascript
function limitparentdepth_admin_head_javascript()
{
    //Globalize
    global $limit;

    //Print the script - Parent selector limit
    if(limitParentSelector())
        echo '
            <script type="text/javaScript">
                //Limit the dropdown
                jQuery(document).ready(function($) {
                    //Hide dropdowns
                    $("#parent_id option:not(:first)").hide();
                    $("#post_parent option:not(:first)").hide();

                    //Show the valid once
                    for(var i = 0; i <= '.$limit.'; i++)
                    {
                        //Show this
                        $("#parent_id .level-"+i).show();
                        $("#post_parent .level-"+i).show();
                    }
                });
            </script>
        ';
}
add_action('admin_head', 'limitparentdepth_admin_head_javascript');

//Limit max menu depth in admin panel
function limitparentdepth_limit_menu_depth($hook)
{
    //Globalize
    global $limit;

    //Return if wrong hook
    if(!limitMenuLevel() || $hook != 'nav-menus.php')
        return;

    //Override default value right after 'nav-menu' JS
    wp_add_inline_script('nav-menu', 'wpNavMenu.options.globalMaxDepth = '.($limit+1).';', 'after');
}
add_action('admin_enqueue_scripts', 'limitparentdepth_limit_menu_depth');

//Add menu items
function limitparentdepth_add_admin_item() {
    add_options_page(
        __( 'Limit Parent Depth', 'limitparentdepth' ),
		__('Limit Parent Depth', 'limitparentdepth'),
        'manage_options',
        'limit-parent-depth/admin/general.php'
    );
}
add_action('admin_menu', 'limitparentdepth_add_admin_item');

//Get the limit
function getLimit()
{
    //Globalize
    global $preset;

    //Return preset?
    if(usePreset())
        return $preset->limit;

    //Return
    return intval(get_option('limitparentdepth_limit'));
}

//Get the limit
function LimitParentSelector()
{
    //Globalize
    global $preset;

    //Return preset?
    if(usePreset())
        return $preset->limitParentSelector;

    //Return
    return intval(get_option('limitparentdepth_limit-parent-selector'));
}

//Get the limit
function limitMenuLevel()
{
    //Globalize
    global $preset;

    //Return preset?
    if(usePreset())
        return $preset->limitMenuLevel;

    //Return
    return intval(get_option('limitparentdepth_limit-menu-level'));
}

//Use preset options?
function usePreset()
{
    //Return inverse
    return (intval(get_option('limitparentdepth_firstSave')) ? false : true);
}
?>