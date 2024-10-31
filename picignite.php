<?php
/*
Plugin Name: Pic Ignite
Plugin URI: http://www.picignite.com
Description: A plugin to automatically adds display advertising to the bottom of your post images and you earn you revenue on a CPC basis. You must be approved on picignite.com.
Version: 0.5
Author: Pic Ignite
Author URI: http://www.picignite.com
*/
?>
<?php
function picignite_init() {
        if ( is_admin() ) {
                add_action( 'admin_menu', 'add_picignite' );
        } elseif ( get_option( 'pi_cid' ) ) {
	        function pi_add() {
	        		$pi_show_ad = get_option('pi_show_ad');
	        		$pi_align = get_option('pi_align');
	        		$pi_width = get_option('pi_width');
	        		$pi_height = get_option('pi_height');
			    	if(get_option( 'pi_attr' ) == "id"){
				    	$pi_attribute = "#";
			    	} else if(get_option( 'pi_attr' ) == "class"){
				    	$pi_attribute = ".";
			    	}
			    	if($pi_show_ad === false){
				    	$pi_show_ad = 1;
			    	}
			    	if($pi_align === false){
				    	$pi_align = "bottom";
			    	}
			    	if($pi_width === false){
				    	$pi_width = 234;
			    	}
			    	if($pi_height === false){
				    	$pi_height = 60;
			    	}
				        $new_content .= '
				        <script>
					        jQuery(document).ready(function() {
					        	count_img = 1;
					        	jQuery("'.$pi_attribute.get_option('pi_target').' img").each(function() {
								    console.log(count_img);
							    	var pi_width = this.clientWidth;
									var pi_height = this.clientHeight;
									if(pi_width > '.$pi_width.' && pi_height > '.$pi_height.'){
										photo_item = "photo" + count_img + "";
							            jQuery(this).prop("id",photo_item);
							            var display = "<script id=\"pi-load\">";
										display += "var zflag_nid_728=\"2856\";\n";
										display += "var zflag_cid_728=\"'.get_option('pi_cid').'\";\n"; 
										display += "var zflag_sid_728=\"'.get_option('pi_sid').'\";\n"; 
										display += "var zflag_sz_728=\"14\";\n"; 
										display += "var zd_src_728=\"http://xp2.zedo.com/jsc/xp2/fo.js\";\n"; 
										display += "var zflag_nid_468=\"2856\";\n";
										display += "var zflag_cid_468=\"'.get_option('pi_cid').'\";\n"; 
										display += "var zflag_sid_468=\"'.get_option('pi_sid').'\";\n"; 
										display += "var zflag_sz_468=\"0\";\n"; 
										display += "var zd_src_468=\"http://xp2.zedo.com/jsc/xp2/fo.js\";\n"; 
										display += "var zflag_nid_234=\"2856\";\n";
										display += "var zflag_cid_234=\"'.get_option('pi_cid').'\";\n"; 
										display += "var zflag_sid_234=\"'.get_option('pi_sid').'\";\n";
										display += "var zflag_sz_234=\"1\";\n";
										display += "var zd_src_234=\"http://xp2.zedo.com/jsc/xp2/fo.js\";\n";
										display += "var zz_ld_ad='.$pi_show_ad.';\n";
										display += "var zz_ad_cl=1;\n";
										display += "var zz_fr_cp=100;\n";
										display += "var zz_photo_id=photo_item\n";
										display += "var zz_align=\"'.$pi_align.'\";\n"; 
										display += "<\/script>"; 
										var previous_count_img = count_img-1;
										console.log(previous_count_img);
										if (count_img > 1){
											jQuery("#pi-load" + previous_count_img + "").after(display);
										} else {
											jQuery("'.$pi_attribute.get_option('pi_target').'").not("noscript").prepend(display);
										}
										jQuery("#pi-load").after("<script type=\"text/javascript\" src=\"http://c1.zedo.com/utils/faop.js\"><\/script>");
							            jQuery("#pi-load").prop("id","pi-load" + count_img + "");
										count_img++;
									}
							    });
					        });
			            </script>
			            ';
					echo $new_content;
			}
			add_action( 'wp_head', 'pi_add' );
        }
}
add_action( 'init', 'picignite_init' );
function add_picignite() {
    add_menu_page('Pic Ignite Plugin Settings', 'Pic Ignite', 'administrator', __FILE__, 'picignite_options',plugins_url('/images/logo_pi.png', __FILE__));
    add_action( 'admin_init', 'register_picignite' );
}
function register_picignite() {
    register_setting( 'picignite-group', 'pi_cid', 'intval' );
    register_setting( 'picignite-group', 'pi_sid', 'intval' );
    register_setting( 'picignite-group', 'pi_attr', 'strval' );
    register_setting( 'picignite-group', 'pi_target', 'strval' );
    register_setting( 'picignite-group', 'pi_align', 'strval' );
    register_setting( 'picignite-group', 'pi_width', 'strval' );
    register_setting( 'picignite-group', 'pi_height', 'strval' );
    register_setting( 'picignite-group', 'pi_show_ad', 'intval' );
}
function picignite_options() {
	echo '<div class="wrap">';
        echo "<h2>" . __( 'Pic Ignite Options', 'picignite_form' ) . "</h2>";
        ?>
        <form name="pi_form" method="post" action="options.php">
            <input type="hidden" name="pi_hidden" value="Y">
            <?php
            settings_fields( 'picignite-group' );
            ?>
        <table class="form-table">
            <tr valign="top">
            <th scope="row">Signup at picignite.com</th>
            <td><a href="http://www.picignite.com" target="_blank">Register Here</a></td>
            </tr>
        </table>
        <table class="form-table">
            <tr valign="top">
            <th scope="row">Pic Ignite CID</th>
            <td><input type="text" name="pi_cid" value="<?php echo esc_attr(get_option('pi_cid')); ?>" /></td>
            </tr>
        </table>
        <table class="form-table">
            <tr valign="top">
            <th scope="row">Pic Ignite SID</th>
            <td><input type="text" name="pi_sid" value="<?php echo esc_attr(get_option('pi_sid')); ?>" /></td>
            </tr>
        </table>
        <table class="form-table">
            <tr valign="top">
            <th scope="row">Pic Ignite Attribute Name (enter either id or class)</th>
            <td><input type="text" name="pi_attr" value="<?php echo esc_attr(get_option('pi_attr')); ?>" /></td>
            </tr>
        </table>
        <table class="form-table">
            <tr valign="top">
            <th scope="row">Pic Ignite Attribute Value (name of id or class)</th>
            <td><input type="text" name="pi_target" value="<?php echo esc_attr(get_option('pi_target')); ?>" /></td>
            </tr>
        </table>
        <table class="form-table">
            <tr valign="top">
            <th scope="row">Pic Ignite Ad Alignment(enter either top or bottom)</th>
            <td><input type="text" name="pi_align" value="<?php echo esc_attr(get_option('pi_align')); ?>" /></td>
            </tr>
        </table>
        <table class="form-table">
            <tr valign="top">
            <th scope="row">Pic Ignite Image Width(Set a minimum size width for an ad to show on i.e 234. Default = 234)</th>
            <td><input type="text" name="pi_width" value="<?php echo esc_attr(get_option('pi_width')); ?>" /></td>
            </tr>
        </table>
        <table class="form-table">
            <tr valign="top">
            <th scope="row">Pic Ignite Image Height(Set a minimum size height for an ad to show on i.e 60. Default = 60)</th>
            <td><input type="text" name="pi_height" value="<?php echo esc_attr(get_option('pi_height')); ?>" /></td>
            </tr>
        </table>
        <table class="form-table">
            <tr valign="top">
            <th scope="row">Pic Ignite Show Ad(enter 0 for on rollover and 1 for automatically)</th>
            <td><input type="text" name="pi_show_ad" value="<?php echo esc_attr(get_option('pi_show_ad')); ?>" /></td>
            </tr>
        </table>
        <?php


        echo '<p class="submit">';
        ?>
            <?php submit_button(); ?>
        <?php 
        echo '</p>';
        echo '</form>';
        echo '</div> ';
}
?>