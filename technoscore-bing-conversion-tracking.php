<?php  
/*
Plugin Name: Technoscore Bing Conversion Tracking
Plugin URI: http://nddw.com/demo3/sws-res-slider/
Description: This plugin adds Bing Conversion Tracking code to footer part of Selected/All webpages.
Version:  1.0.0
Author: Technoscore
Author URI: http://www.technoscore.com/
Text Domain: techno_
*/

add_action('admin_menu', 'techno_bing_conversion');

function techno_bing_conversion() {

	//create new top-level menu
	add_menu_page('Bing Conversion Tracking', 'Bing Conversion Tracking', 'administrator', __FILE__, 'techno_bing_conversion_page');
	
		//call register settings function
	add_action( 'admin_init', 'techno_bing_conversion_register_settings' );
}


function techno_bing_conversion_register_settings() {
	//register our settings
	register_setting( 'techno-settings-group', 'techno_bing_page_id' );
	register_setting( 'techno-settings-group', 'techno_bing_script' );
	
}

function techno_show_bing(){
global $post;
$techno_bing_script = esc_attr( get_option('techno_bing_script') );
$techno_bing_page_id_empty = esc_attr( get_option('techno_bing_page_id') );
if(!empty($techno_bing_script)){
	if(!empty($techno_bing_page_id_empty)){
	$techno_bing_page_id = explode(',',get_option('techno_bing_page_id'));
		if(count($techno_bing_page_id)>0){
			if(in_array($post->ID,$techno_bing_page_id)){
				echo  get_option('techno_bing_script'); 
			}
		}
	}else{
	echo get_option('techno_bing_script');
	}
}

}
add_action('wp_footer','techno_show_bing',999);

function techno_bing_conversion_page() {

?>
<div class="wrap">
<h1> Bing Conversion Integration</h1>
<form method="post" action="options.php">
    <?php settings_fields( 'techno-settings-group' ); ?>
    <?php do_settings_sections( 'techno-settings-group' ); ?>
    <table class="form-table">

        <tr valign="top">
        <th scope="row">List Of Page Ids</th>
        <td><input type="text" name="techno_bing_page_id" class="regular-text code" value="<?php echo esc_attr( get_option('techno_bing_page_id') ); ?>" />&nbsp; ex: 2,3,139,101 or leave blank to apply bing conversion code on all pages</td>
        </tr>  
		
		<tr valign="top">
        <th scope="row">Bing Conversion Script</th>
        <td>
		<textarea name="techno_bing_script" cols="100" rows="20" ><?php echo esc_attr( get_option('techno_bing_script') ); ?></textarea></td>
        </tr>  


		
    </table>
    <?php submit_button(); ?>
</form>
</div>

<?php } ?>