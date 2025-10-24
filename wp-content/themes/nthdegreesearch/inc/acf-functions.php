<?php
/**
 * Site Settings → Advanced → Custom HTML → Head
 */
add_action( 'wp_head', 'nds_custom_html_head' );
function nds_custom_html_head() {
    $acf_general_settings = get_field( 'acf_advanced_custom_html', 'option' );

    if ( $acf_general_settings ) {
        $custom_html_head = !empty( $acf_general_settings['head'] ) ? $acf_general_settings['head'] : '';

        if ( $custom_html_head ) {
            echo htmlspecialchars_decode( $custom_html_head ) . "\n";
        }
    }
}


/**
 * Site Settings → Advanced → Custom HTML → Head (Admin)
 */
add_action( 'admin_head', 'nds_custom_html_head_admin' );
function nds_custom_html_head_admin() {
    $acf_general_settings = get_field( 'acf_advanced_custom_html', 'option' );

    if ( $acf_general_settings ) {
        $custom_html_head = !empty( $acf_general_settings['head_admin'] ) ? $acf_general_settings['head_admin'] : '';

        if ( $custom_html_head ) {
            echo htmlspecialchars_decode( $custom_html_head ) . "\n";
        }
    }
}


/**
 * Site Settings → Advanced → Custom HTML → Body
 */
add_action( 'nds_header', 'nds_custom_html_body_top' );
function nds_custom_html_body_top() {
    $acf_general_settings = get_field( 'acf_advanced_custom_html', 'option' );

    if ( $acf_general_settings ) {
        $custom_html_body_top = !empty( $acf_general_settings['body_top'] ) ? $acf_general_settings['body_top'] : '';

        if ( $custom_html_body_top ) {
            echo htmlspecialchars_decode( $custom_html_body_top ) . "\n";
        }
    }
}


/**
 * Site Settings → Advanced → Custom HTML → Body (Footer)
 */
add_action( 'wp_footer', 'nds_custom_html_body_footer' );
function nds_custom_html_body_footer() {
    $acf_general_settings = get_field( 'acf_advanced_custom_html', 'option' );

    if ( $acf_general_settings ) {
        $custom_html_body_footer = !empty( $acf_general_settings['body_footer'] ) ? $acf_general_settings['body_footer'] : '';

        if ( $custom_html_body_footer ) {
            echo htmlspecialchars_decode( $custom_html_body_footer ) . "\n";
        }
    }
}


/**
 * Define screen sizes for CSS media queries
 */
define( 'SCREEN_TABLET', '1023px' );
define( 'SCREEN_MOBILE', '781px' );


/**
 * Theme Styles from Site Settings
 */
add_action( 'wp_head', 'nds_css_head' );
add_action( 'admin_head', 'nds_css_head' );
function nds_css_head(){
    global $pagenow;

    $design_settings = get_field( 'acf_design_settings', 'option' );
    $acf_advanced_gutenberg_settings = get_field( 'acf_advanced_gutenberg_settings', 'option' );
    $acf_allowed_post_types = isset( $acf_advanced_gutenberg_settings['allowed_post_types'] ) && is_array( $acf_advanced_gutenberg_settings['allowed_post_types'] ) ? $acf_advanced_gutenberg_settings['allowed_post_types'] : [];

    $allowed_post_types = ['post', 'page'];

    if ( !empty( $acf_allowed_post_types ) && is_array( $acf_allowed_post_types ) ) {
        foreach ( $acf_allowed_post_types as $post_type ) {
            if ( !empty( $post_type['post_type_slug'] ) ) {
                $allowed_post_types[] = $post_type['post_type_slug'];
            }
        }
    }

    if ( is_admin() ) $current_screen = get_current_screen();

    if ( !is_admin() || ( is_admin() && in_array( $current_screen->post_type, $allowed_post_types ) && ( $pagenow == 'post.php' || $pagenow == 'post-new.php' ) || ( is_admin() && $pagenow == 'widgets.php' ) ) ) {

        $container_max_width = !empty( $design_settings['container_max_width'] ) ? $design_settings['container_max_width'] : '1600';
        $container_max_width_unit = !empty( $design_settings['container_max_width_unit'] ) ? $design_settings['container_max_width_unit'] : 'px';
        $container_padding = !empty( $design_settings['container_padding'] ) ? $design_settings['container_padding'] : '1.25';

        $colors =  $design_settings['colours'];
        $color_base = !empty( $colors['color_base'] ) ? $colors['color_base'] : '#000';
        $color_primary = !empty( $colors['color_primary'] ) ? $colors['color_primary'] : '#4da3a2';
        $color_secondary = !empty( $colors['color_secondary'] ) ? $colors['color_secondary'] : '#7dc4be';
        $color_trinary = !empty( $colors['color_trinary'] ) ? $colors['color_trinary'] : '#d4468e';
        $more_colours = isset( $colors['more_colours'] ) ? $colors['more_colours'] : null;

        $typography = $design_settings['typography'];
        $base_font = !empty( $typography['base_font'] ) ? $typography['base_font'] : 'Arial, "Helvetica Neue", Helvetica, sans-serif';
        $title_font = !empty( $typography['title_font'] ) ? $typography['title_font'] : 'Arial, "Helvetica Neue", Helvetica, sans-serif';
        $more_fonts = isset( $typography['more_fonts'] ) ? $typography['more_fonts'] : null;

        $base_font_weight = !empty( $typography['base_font_weight'] ) ? $typography['base_font_weight'] : '400';
        $title_font_weight = !empty( $typography['title_font_weight'] ) ? $typography['title_font_weight'] : '700';
        $base_font_size = !empty( $typography['dt_base_font_size'] ) ? $typography['dt_base_font_size'] : '1.125rem';
        $base_line_height = !empty( $typography['dt_base_line_height'] ) ? $typography['dt_base_line_height'] : '155.556%';
        $title_line_height = !empty( $typography['dt_title_line_height'] ) ? $typography['dt_title_line_height'] : '147.619%';
        $tb_base_font_size = $typography['tb_base_font_size'];
        $tb_base_line_height = $typography['tb_base_line_height'];
        $tb_title_line_height = $typography['tb_title_line_height'];
        $mb_base_font_size = $typography['mb_base_font_size'];
        $mb_base_line_height = $typography['mb_base_line_height'];
        $mb_title_line_height = $typography['mb_title_line_height'];

        ob_start();
?>
<style id="nds-global-theme-style">
:root{
    --nds-color-base: <?php echo $color_base; ?>;
    --nds-color-primary: <?php echo $color_primary; ?>;
    --nds-color-secondary: <?php echo $color_secondary; ?>;
    --nds-color-trinary: <?php echo $color_trinary; ?>;

    <?php
    if ( is_array( $more_colours ) && !empty( $more_colours ) ) : 

        $ctr_color = 0;

        foreach ( $more_colours as $color ) {

            $ctr_color++;

            if ( empty( $color['more_colour'] ) ) {
                continue;
            }

            $color_slug = !empty( $color['color_slug'] ) ? $color['color_slug'] : $ctr_color;
    ?>
    --nds-color-<?php echo $color_slug; ?>: <?php echo $color['more_colour']; ?>;
    <?php
        }
    endif;
    ?>

    --font-family-base: <?php echo $base_font; ?>;
    --font-family-title: <?php echo $title_font; ?>;
    --font-base-size: <?php echo $base_font_size; ?>;
    --font-base-weight: <?php echo $base_font_weight; ?>;
    --font-title-weight: <?php echo $title_font_weight; ?>;
    <?php
    if ( is_array( $more_fonts ) && !empty( $more_fonts ) ) : 

        $ctr_fonts = 0;

        foreach ( $more_fonts as $font ) {
            $ctr_fonts++;
            if ( empty( $font['font'] ) ) {
                continue;
            }
    ?>
    --font-family-<?php echo $ctr_fonts; ?>: <?php echo $font['font']; ?>;
    <?php
       }
    endif;
    ?>
    --base-line-height: <?php echo $base_line_height; ?>;
    --title-line-height: <?php echo $title_line_height; ?>;
}
body{
    color: var(--nds-color-base);
    font-family: var(--font-family-base);
    font-size: var(--font-base-size);
    font-weight: var(--font-base-weight);
    line-height: var(--base-line-height);
}
.container{
    padding-left: <?php echo $container_padding; ?>rem;
    padding-right: <?php echo $container_padding; ?>rem;
    max-width: <?php echo $container_max_width . $container_max_width_unit; ?>;
}
.color-base{
    color: var(--nds-color-base);
}
.color-primary{
    color: var(--nds-color-primary);
}
.color-secondary{
    color: var(--nds-color-secondary);
}
<?php
if ( is_array( $more_colours ) && !empty( $more_colours ) ) : 
    $ctr_color = 0;
    foreach ( $more_colours as $color ) {
        $ctr_color++;
        if ( empty( $color['more_colour'] ) ) {
            continue;
        }
        $color_slug = !empty( $color['color_slug'] ) ? $color['color_slug'] : $ctr_color;
?>
.color-<?php echo $color_slug; ?>: var(--color-<?php echo $ctr_color; ?>);
<?php
    }
endif;
?>
.font-base{
    font-family: var(--font-family-base);
}
.font-title{
    font-family: var(--font-family-title);
}
<?php
if ( is_array( $more_fonts ) && !empty( $more_fonts ) ) : 
    $ctr_fonts = 0;
    foreach ( $more_fonts as $font ) {
        $ctr_fonts++;
        if ( empty( $font['font'] ) ) {
           continue;
        }
?>
.font-<?php echo $ctr_fonts; ?>{
    font-family: var(--font-family-<?php echo $ctr_fonts; ?>);
}
<?php
    }
endif;
?>
@media (max-width: 1279px){
    .container{
        padding-left: 1.25rem;
        padding-right: 1.25rem;
    }
}
@media (max-width: 1023px){
    <?php if ( $tb_base_font_size || $tb_base_line_height || $tb_title_line_height ) { ?>
    :root{
        <?php if ( $tb_base_font_size ) { ?> --font-base-size: <?php echo $tb_base_font_size; ?>; <?php } ?>
        <?php if ( $tb_base_line_height ) { ?> --base-line-height: <?php echo $tb_base_line_height; ?>; <?php } ?>
        <?php if ( $tb_title_line_height ) { ?> --title-line-height: <?php echo $tb_title_line_height; ?>; <?php } ?>
    }
    <?php } ?>
}
<?php if ( $mb_base_font_size || $mb_base_line_height || $mb_title_line_height ) { ?>
@media (max-width: 767px){
    :root{
        <?php if ( $mb_base_font_size ) { ?> --font-base-size: <?php echo $mb_base_font_size; ?>; <?php } ?>
        <?php if ( $mb_base_line_height ) { ?> --base-line-height: <?php echo $mb_base_line_height; ?>; <?php } ?>
    }
    <?php if ( $mb_title_line_height ) { ?>
        --title-line-height: <?php echo $mb_title_line_height; ?>;
    <?php } ?>
}
<?php } ?>
</style>
<?php
        $minified_css = ob_get_clean();
        $minified_css = preg_replace( '/\s+/', ' ', $minified_css );
        echo $minified_css;
    }
}


/**
 * Add custom category for blocks and place it at the top
 */
add_filter( 'block_categories_all', function( $categories ) {

    // Prepend the custom category
    array_unshift( $categories, array(
        'slug'  => 'nds-blocks',
        'title' => 'NDS'
    ));

    return $categories;

});


/**
 * Dynamically register ACF blocks from /blocks/acf/
 */
add_action( 'init', 'nds_register_acf_blocks' );
function nds_register_acf_blocks() {

    if ( ! function_exists( 'register_block_type' ) ) {
        return;
    }

    $blocks_dir = get_template_directory() . '/blocks/acf/';
    
    if ( ! is_dir( $blocks_dir ) ) {
        return;
    }

    // Scan for directories inside /blocks/acf/
    $block_folders = array_filter( glob( $blocks_dir . '*', GLOB_ONLYDIR ) );

    foreach ( $block_folders as $folder_path ) {
        register_block_type( $folder_path );
    }
}


/**
 * Remove ACF inner block
 */
add_filter( 'acf/blocks/wrap_frontend_innerblocks', 'nds_acf_should_wrap_innerblocks', 10, 2 );
function nds_acf_should_wrap_innerblocks( $wrap, $name ) {

    if ( $name == 'acf/container' ) {
        return true;
    }

    return false;
    
}


/**
 * Render section css
 */
function nds_css_section_container( $settings_arr ){

    ob_start();
    
    $block_data = $settings_arr['block_data'];
    $block_id = $block_data['block_id'];
    $block_name = $block_data['block_name'];
    $supports = $settings_arr['supports'];
    $style = isset( $supports['style'])  ? $supports['style'] : null;

    if ( $supports['dimensions']['minHeight'] == 1 && !empty( $style['dimensions']['minHeight'] ) ){
        $min_height = $style['dimensions']['minHeight'];
    }

    $background = $settings_arr['background'];
    $background_value = $background['background'] ?? '';

    $custom_css = !empty( $settings_arr['custom_css'] ) ? $settings_arr['custom_css'] : '';

    if ( $custom_css ) $custom_css = str_replace( 'selector', '.section[data-block-id="' . $block_id . '"]', $custom_css );

    $container = $settings_arr['container'] ?? '';
    $container_custom = $settings_arr['container_custom'] ?? '';
    $columns_gap = $settings_arr['columns_gap'] ?? '';

    $css = '';
    $desktop_css = '';
    $tablet_css = '';
    $mobile_css= '';
    $container_css = '';

    if ( ( $background && ( $background_value['bg_image'] || $background_value['bg_image_tablet'] || $background_value['bg_image_mobile'] || $background_value['bg_color'] ) ) || ( $supports['dimensions']['minHeight'] && !empty( $min_height ) ) || ( $container == 'Custom' && $container_custom ) || !empty( $custom_css ) ) :

        if ( $container == 'Custom' && $container_custom ) {
            $container_css .= 'max-width: ' . $container_custom . ';';
        }

        if ( !empty( $background_value['bg_color'] ) ) {
            $css .= 'background-color: ' . $background_value['bg_color'] . ';';
        }

        if ( !empty( $background_value['bg_image'] ) ) {
            $css .= 'background-image: url("' . $background_value['bg_image']['url'] . '");';
        }   

        if ( !empty( $background_value['bg_image'] ) && !empty( $background_value['bg_size'] ) && $background_value['bg_size'] != 'Custom' ) {
            $css .= 'background-size: ' . strtolower( $background_value['bg_size'] ) . ';';
        } elseif ( !empty( $background_value['bg_image'] ) && $background_value['bg_size'] == 'Custom' && !empty( $background_value['bg_custom_size'] ) ) {
            $css .= 'background-size: ' . strtolower( $background_value['bg_custom_size'] ) . ';';
        }

        if ( !empty( $background_value['bg_image'] ) && !empty( $background_value['bg_repeat'] ) ) {
            $css .= 'background-repeat: ' . str_replace( ' ', '-', strtolower( $background_value['bg_repeat'] ) ) . '; ';
        }

        if ( !empty( $background_value['bg_image'] ) && !empty( $background_value['bg_position'] ) && $background_value['bg_position'] != 'Custom' ) {
            $css .= 'background-position: ' . strtolower( $background_value['bg_position'] ) . ';';
        } elseif ( !empty( $background_value['bg_image'] ) && !empty( $background_value['bg_position'] ) && $background_value['bg_position'] == 'Custom' ){
            $css .= 'background-position: ' . strtolower( $background_value['bg_custom_position'] ) . ';';
        }

        if ( $supports['dimensions']['minHeight'] && !empty( $style['dimensions']['minHeight'] ) ) {
            $css .= 'min-height: ' . $min_height . '; ';
        }

        if ( !empty( $background_value['bg_image_tablet'] ) ){

            $tablet_css = '@media only screen and (max-width: ' . SCREEN_TABLET . '){ .div[data-block-id="' . $block_id . '"]{';

                if ( !empty( $background_value['bg_image_tablet'] ) ) $tablet_css .= 'background-image: url("' . $background_value['bg_image_tablet']['url'] . '");';

            $tablet_css .= '} }';

        }

        if ( !empty( $background_value['bg_image_mobile'] ) ){

            $mobile_css = '@media only screen and (max-width: ' . SCREEN_MOBILE . '){ .div[data-block-id="' . $block_id . '"]{';

                if ( !empty( $background_value['bg_image_mobile'] ) ) $mobile_css .= 'background-image: url("' . $background_value['bg_image_mobile']['url'] . '");';

            $mobile_css .= '} }';

        }
        
        if ( !empty( $container_css ) || !empty( $columns_gap ) || !empty( $desktop_css ) || !empty( $css ) || !empty( $tablet_css ) || !empty( $mobile_css ) || !empty( $custom_css ) ) {
?>

<style>
    <?php if ( $container_css || $columns_gap || $desktop_css ){ ?>@media only screen and (min-width: 1024px){ <?php if ( $container_css ){ ?>div[data-block-id="<?php echo $block_id; ?>"]{ <?php echo $container_css;?> }<?php } ?> <?php if ( $desktop_css  ){ ?>div[data-block-id="<?php echo $block_id; ?>"]{<?php echo $desktop_css; ?>}<?php } ?> <?php if ( $columns_gap ){ ?>div[data-block-id="<?php echo $block_id; ?>"] .wp-block-columns{ column-gap: <?php echo $columns_gap;?> }<?php } ?> }<?php } ?><?php if ( $css  ){ ?>div[data-block-id="<?php echo $block_id; ?>"]{<?php echo $css; ?>}<?php } ?><?php if ( $tablet_css ) echo $tablet_css; ?><?php if ( $mobile_css ) echo $mobile_css; ?><?php if ( $custom_css ) echo $custom_css; ?>
</style>

<?php
        }

    endif;

    return ob_get_clean();

}


/**
 * Section block CSS (Backend)
 */
function nds_css_section_container_backend( $settings_arr ){

    if ( is_admin() ) :

        ob_start();

        echo nds_css_section_container( $settings_arr );

        $minified_css = ob_get_clean();
        $minified_css = preg_replace( '/\s+/', ' ', $minified_css );   

        echo $minified_css;

    endif;

}


/**
 * Blocks CSS (Frontend)
 */
add_action( 'wp_head', 'nds_css_section_container_head_frontend' );
//add_action( 'admin_head', 'nds_css_head_section' );
function nds_css_section_container_head_frontend(){

    if ( !is_admin() ) {

        $post_id = get_the_ID();
        $main_content = get_post_field( 'post_content', $post_id );
        $main_blocks = parse_blocks( $main_content );

        $footer_pattern = get_page_by_title( 'Site Footer', OBJECT, 'wp_block' );
        $footer_blocks = $footer_pattern ? parse_blocks( $footer_pattern->post_content ) : [];

        // Merge both blocks
        $all_blocks = array_merge( $main_blocks, $footer_blocks );

        ob_start();
?>

<style id="blocks-theme-style">

<?php 
foreach ( $all_blocks as $block ) {

    $block_name = $block['blockName'];

    if ( $block_name == 'nds/section' ) {      

        nds_css_section_container_head_frontend_render( $block );

        if ( isset( $block['innerBlocks'] ) && is_array( $block['innerBlocks'] ) ) {
            foreach ( $block['innerBlocks'] as $block_inner ) {
                if ( $block_inner['blockName'] === 'nds/container' ) {
                    nds_css_section_container_head_frontend_render( $block_inner );
                }
            }
        }

        $minified_css_all = ob_get_clean();
        $minified_css_all = preg_replace( '/\s+/', ' ', $minified_css_all );    

        echo $minified_css_all;

    }

} 
?>

</style>

<?php
    }
    
}


/**
 * Blocks render CSS (Frontend)
 */

function nds_css_section_container_head_frontend_render( $block ) {
    
    $css = '';
    $desktop_css = '';
    $tablet_css = '';
    $mobile_css= '';
    $container_css = '';
    $block_id = $block['attrs']['anchor'];
    $data = $block['attrs']['data'];
    $css_class_name = 'div[data-block-id="' . $block_id . '"]';
    $style = $block['attrs']['style'] ?? ''; 

    if ( isset( $data ) || isset( $style ) ) {

        $bg_color = $data['background_background_bg_color'];
        $bg_image_id = $data['background_background_bg_image'];
        $bg_image_url = wp_get_attachment_url( $bg_image_id );
        $bg_image_tablet_id = $data['background_background_bg_image_tablet'];
        $bg_image_tablet_url = wp_get_attachment_url( $bg_image_tablet_id );
        $bg_image_mobile_id = $data['background_background_bg_image_mobile'];
        $bg_image_mobile_url = wp_get_attachment_url( $bg_image_mobile_id );
        $bg_size = strtolower( $data['background_background_bg_size'] );
        $bg_size_custom = !empty( $data['background_background_bg_custom_size'] ) ? $data['background_background_bg_custom_size'] : '';

        if ( $bg_size == 'custom' && $bg_size_custom ) $bg_size = $bg_size_custom;

        $bg_repeat = nds_create_slug( $data['background_background_bg_repeat'] );
        $bg_position = strtolower( $data['background_background_bg_position'] );
        $bg_position_custom = !empty( $data['background_background_bg_custom_position'] ) ? $data['background_background_bg_custom_position'] : '';

        if ( $bg_position == 'custom' && $bg_position_custom ) $bg_position = $bg_position_custom;

        $min_height = '';

        if ( $style && isset( $style['dimensions']['minHeight'] ) ) $min_height = $style['dimensions']['minHeight'];      

        if ( $bg_color ) $css .= 'background-color: ' . $bg_color . ';';

        if ( $bg_image_id ) $css .= 'background-image: url("' . $bg_image_url . '");';

        if ( $bg_image_id && $bg_size ) $css .= 'background-size: ' . $bg_size. ';';

        if ( $bg_image_id && $bg_repeat ) $css .= 'background-repeat: ' . $bg_repeat. ';';

        if ( $bg_image_id && $bg_position ) $css .= 'background-position: ' . $bg_position. ';';

        if ( $min_height ) $css .= 'min-height: ' . $min_height . ';';    

        $container = $data['container_size'] ?? '';
        $container_custom = $data['custom_container_size'] ?? '';

        if ( $container == 'Custom' && $container_custom ) {
            $container_css .= 'max-width: ' . $container_custom . ';';
        }

        $columns_gap = $data['columns_gap'] ?? '';

        if ( $bg_image_tablet_id ) {

            $tablet_css = '@media only screen and (max-width: ' . SCREEN_TABLET . '){ ' . $css_class_name . '{';

            if ( $bg_image_tablet_id ) $tablet_css .= 'background-image: url("' . $bg_image_tablet_url . '");';

            $tablet_css .= '} }';

        }

        if ( $bg_image_mobile_id ) {

            $mobile_css = '@media only screen and (max-width: ' . SCREEN_MOBILE . '){ ' . $css_class_name . '{';

            if ( $bg_image_mobile_id ) $mobile_css .= 'background-image: url("' . $bg_image_mobile_url . '");';

            $mobile_css .= '} }';

        }     

    }

    if ( !empty( $container_css ) || !empty( $columns_gap ) || !empty( $desktop_css ) ) { 

        echo '@media only screen and (min-width: 1024px){';     

        if ( !empty( $container_css ) ) echo 'div[data-block-id="' . $block_id . '"]{ ' . $container_css . ' }';

        if ( !empty( $desktop_css ) ) echo 'div[data-block-id="' . $block_id . '"]{ ' . $desktop_css . ' }';

        if ( !empty( $columns_gap ) ) echo 'div[data-block-id="' . $block_id . '"] .wp-block-columns{ column-gap: ' . $columns_gap . ' }';

        echo '}';

    }

    if ( !empty( $css ) ) {
        $minified_css = preg_replace( '/\s+/', ' ', $css );
        echo $css_class_name . '{' 
            . $minified_css . 
        '}';
    }

    if ( !empty( $tablet_css ) ) {
        $minified_tablet_css = preg_replace( '/\s+/', ' ', $tablet_css );
        echo $minified_tablet_css;

    }

    if ( !empty( $mobile_css ) ) {
        $minified_mobile_css = preg_replace( '/\s+/', ' ', $mobile_css );
        echo $minified_mobile_css;
    }

    $custom_css = $data['custom_css'] ?? '';
    $custom_css = str_replace( 'selector', 'div[data-block-id="' . $block_id . '"]', $custom_css );

    if ( $custom_css ) echo $custom_css;
}


/**
 * Generate an id on blocks if empty
 */
add_filter(
    'acf/pre_save_block',
    function( $attributes ) {

        if ( empty( $attributes['anchor'] ) ) {
            $attributes['anchor'] = nds_generate_unique_anchor( get_the_ID() );
        }

        return $attributes;

    }
);


function nds_generate_unique_anchor( $post_id ) {
    $base = 'block-' . uniqid();
    $anchors = [];

    // Parse existing anchors
    $blocks = parse_blocks( get_post_field( 'post_content', $post_id ) );
    foreach ( $blocks as $block ) {
        if ( ! empty( $block['attrs']['anchor'] ) ) {
            $anchors[] = $block['attrs']['anchor'];
        }
    }

    // Check and regenerate if needed
    while ( in_array( $base, $anchors ) ) {
        $base = 'block-' . uniqid();
    }

    return $base;
}


/**
 * ACF section block spacing
 */
function nds_acf_section_block_spacing( $spacing ) {

    $classes = [];

    // Desktop (Margin)
    if ( $spacing['dt_margin_top'] === 'none' ) {
        $classes[] = 'mt-0';
    } else {
        $classes[] = 'mt-' . $spacing['dt_margin_top'];
    }

    if ( $spacing['dt_margin_bottom'] === 'none' ) {
        $classes[] = 'mb-0';
    } else {
        $classes[] = 'mb-' . $spacing['dt_margin_bottom'];
    }

    // Tablet (Margin)
    if ( $spacing['tb_margin_top'] != 'inherit' ) {
        if ( $spacing['tb_margin_top'] === 'none' ) {
            $classes[] = 'mt-t-0';
        } else {
            $classes[] = 'mt-t-' . $spacing['tb_margin_top'];
        }
    } 

    if ( $spacing['tb_margin_bottom'] != 'inherit' ) {
        if ( $spacing['tb_margin_bottom'] === 'none' ) {
            $classes[] = 'mb-t-0';
        } else {
            $classes[] = 'mb-t-' . $spacing['tb_margin_bottom'];
        }
    }

    // Mobile (Margin)
    if ( $spacing['mb_margin_top'] != 'inherit' ) {
        if ( $spacing['mb_margin_top'] === 'none' ) {
            $classes[] = 'mt-m-0';
        } else {
            $classes[] = 'mt-m-' . $spacing['mb_margin_top'];
        }
    }

    if ( $spacing['mb_margin_bottom'] != 'inherit' ) {
        if ( $spacing['mb_margin_bottom'] === 'none' ) {
            $classes[] = 'mb-m-0';
        } else {
            $classes[] = 'mb-m-' . $spacing['mb_margin_bottom'];
        }
    }

    // Desktop (Padding)
    if ( !$spacing['dt_padding_top'] ){
        $classes[] = 'pt-md';
    }
    elseif ( $spacing['dt_padding_top'] === 'none' ) {
        $classes[] = 'pt-0';
    } else {
        $classes[] = 'pt-' . $spacing['dt_padding_top'];
    }

    if ( !$spacing['dt_padding_bottom'] ){
        $classes[] = 'pb-md';
    }
    elseif ( $spacing['dt_padding_bottom'] === 'none' ) {
        $classes[] = 'pb-0';
    } else {
        $classes[] = 'pb-' . $spacing['dt_padding_bottom'];
    }

    // Tablet (Padding)
    if ( $spacing['tb_padding_top'] != 'inherit' ) {
        if ( $spacing['tb_padding_top'] === 'none' ) {
            $classes[] = 'pt-t-0';
        } else {
            $classes[] = 'pt-t-' . $spacing['tb_padding_top'];
        }
    } 

    if ( $spacing['tb_padding_bottom'] != 'inherit' ) {
        if ( $spacing['tb_padding_bottom'] === 'none' ) {
            $classes[] = 'pb-t-0';
        } else {
            $classes[] = 'pb-t-' . $spacing['tb_padding_bottom'];
        }
    }

    // Mobile (Padding)
    if ( $spacing['mb_padding_top'] != 'inherit' ) {
        if ( $spacing['mb_padding_top'] === 'none' ) {
            $classes[] = 'pt-m-0';
        } else {
            $classes[] = 'pt-m-' . $spacing['mb_padding_top'];
        }
    }

    if ( $spacing['mb_padding_bottom'] != 'inherit' ) {
        if ( $spacing['mb_padding_bottom'] === 'none' ) {
            $classes[] = 'pb-m-0';
        } else {
            $classes[] = 'pb-m-' . $spacing['mb_padding_bottom'];
        }
    }

    // Remove duplicates
    $classes = array_unique($classes);

    return implode(' ', $classes);
}