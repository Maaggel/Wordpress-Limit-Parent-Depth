<?php
//Save uptions
if(isset($_POST["parent-limit"]))
{
	//Set the option
    if(!add_option("limitparentdepth_limit", $_POST["parent-limit"]))
        update_option("limitparentdepth_limit", $_POST["parent-limit"]);
		
	//Set the option
    if(!add_option("limitparentdepth_limit-parent-selector", (isset($_POST["limit-parent-selector"]) ? 1 : 0)))
        update_option("limitparentdepth_limit-parent-selector", (isset($_POST["limit-parent-selector"]) ? 1 : 0));
		
	//Set the option
    if(!add_option("limitparentdepth_limit-menu-level", (isset($_POST["limit-menu-level"]) ? 1 : 0)))
        update_option("limitparentdepth_limit-menu-level", (isset($_POST["limit-menu-level"]) ? 1 : 0));
		
		

	//Set "Do not use preset", first save
    add_option("limitparentdepth_firstSave", 1);

    //Show success
    limitparentdepth_post_success(__( 'The settings have been saved!', 'limitparentdepth' ));
}

//Get the option
$limit = getLimit();
$limitParentSelector = intval(get_option('limitparentdepth_limit-parent-selector'));
$limitMenuLevel = intval(get_option('limitparentdepth_limit-menu-level'));
?>
	<div class="wrap">

		<div id="limitparentdepth_settings_header">
			<div id="icon-limitparentdepth" class="icon32"><br></div>
			<h2><?php _e( 'Limit Parent Depth', 'limitparentdepth' );?></h2>
			<div id="dropmessage" class="updated" style="display:none;"></div>
		</div>

		<form method="post" action="#">
			<?php post_admin_meta_box(__( 'Limit Parent Depth Settings', 'limitparentdepth' ), '
				<h2>Settings</h2>
				<p>
					<i>Here you can limit the depth of the parent selector in the pages.</i>
				</p>
                <p>
					<strong>Depth Limit:</strong>
					<br />
                    <select name="parent-limit">
                        <option value="-1" '.($limit == -1 ? 'selected' : '').'>Do not allow nesting</option>
                        <option value="0" '.($limit == 0 ? 'selected' : '').'>Only top level</option>
                        <option value="1" '.($limit == 1 ? 'selected' : '').'>First level</option>
                        <option value="2" '.($limit == 2 ? 'selected' : '').'>Second level</option>
                        <option value="3" '.($limit == 3 ? 'selected' : '').'>Third level</option>
                        <option value="4" '.($limit == 4 ? 'selected' : '').'>Fourth level</option>
                        <option value="5" '.($limit == 5 ? 'selected' : '').'>Fift level</option>
                        <option value="6" '.($limit == 6 ? 'selected' : '').'>Sixth level</option>
                        <option value="7" '.($limit == 7 ? 'selected' : '').'>Seventh level</option>
                    </select>
					<br />
					<br /><input type="checkbox" name="limit-parent-selector" '.($limitParentSelector ? 'checked' : '').'/>Limit parent selector dropdown
					<br /><input type="checkbox" name="limit-menu-level" '.($limitMenuLevel ? 'checked' : '').'/>Limit menu builder
				</p>
				<p>
					<input type="submit" value="'.__( 'Save settings', 'limitparentdepth' ).'" class="button button-primary button-large" />
				</p>
			');?>
		</form>

	</div>

<script type="text/javaScript">
	jQuery(document).ready(function($) {
		$(".wrap .handlediv").each(function(index) {
			//Bind the click
			$(this).click(function(e) {
				$(this).parent().toggleClass('closed');
			});
		});
	});
</script>

<?php
//Post meta box
function post_admin_meta_box($title = '', $content = '')
{
	echo '
		<div class="limitparentdepth_top">
			<div class="limitparentdepth_top_sidebar limitparentdepth_options_wrapper">
				<div id="normal-sortables" class="meta-box-sortables ui-sortable">
					<div id="limitparentdepth-list" class="postbox ">
						<button type="button" class="handlediv button-link" aria-expanded="true"><span class="screen-reader-text">Toggle panel: '.$title.'</span>
						<span class="toggle-indicator" aria-hidden="true"></span></button><h2 class="hndle ui-sortable-handle"><span style="cursor: default!important; font-size: 15px; font-family: Georgia, \'Times New Roman\', \'Bitstream Charter\', Times, serif; font-weight: normal; padding: 7px 10px; margin: 0; line-height: 1; position: relative; top: -8px;">'.$title.'</span></h2>
						<div class="inside">
							<div class="limitparentdepth_metabox_wrapper">
								<div class="limitparentdepth_metabox_text">
									'.$content.'
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	';
}

//Post success
function limitparentdepth_post_success($msg)
{
	echo '
		<div class="notice notice-success is-dismissible"> 
			<p><strong>'.$msg.'</strong></p>
			<button type="button" class="notice-dismiss">
				<span class="screen-reader-text">Dismiss this notice.</span>
			</button>
		</div>
	';
}
?>