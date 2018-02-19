<?php

class Bingo_Categories extends WP_Widget {

    function __construct() {
        $widget_ops = array( 'classname' => 'bingo_categories', 'description' => __( "Styled list or dropdown of categories.",'bingo'  ) );
        parent::__construct('bingo_categories', __('Bingo Categories','bingo' ), $widget_ops);
    }

    function widget( $args, $instance ) {
        extract( $args );

        $title = apply_filters('widget_title', empty( $instance['title'] ) ? __( 'bingo_Categories','bingo'  ) : $instance['title'], $instance, $this->id_base);
        $c = ! empty( $instance['count'] ) ? '1' : '0';
        $h = ! empty( $instance['hierarchical'] ) ? '1' : '0';
        $d = ! empty( $instance['dropdown'] ) ? '1' : '0';

        echo $before_widget;

        ?>
        <div class="widget links-widget">
            <!-- <div class="title-lines-left"> -->
                <?php if ( $title ) echo $before_title . $title . $after_title; ?>
            <!-- </div> -->
            <div class="widget-content">
                <?php
                $cat_args = array(
                    'orderby' => 'name',
                    'show_count' => $c,
                    'hierarchical' => $h,
                    'hide_if_empty' => true,


                );

                if ( $d ) {
                    $cat_args['show_option_none'] = __('Select Category','bingo' );
                    wp_dropdown_categories(apply_filters('widget_categories_dropdown_args', $cat_args));
                    ?>

                    <script type='text/javascript'>
                        /* <![CDATA[ */
                        var dropdown = document.getElementById("cat");
                        function onCatChange() {
                            if ( dropdown.options[dropdown.selectedIndex].value > 0 ) {
                                location.href = "<?php echo home_url(); ?>/?cat="+dropdown.options[dropdown.selectedIndex].value;
                            }
                        }
                        dropdown.onchange = onCatChange;
                        /* ]]> */
                    </script>

                <?php
                } else {
                    ?>
                    <ul>
                        <?php
                        $cat_args['title_li'] = '';
                        wp_list_categories(apply_filters('widget_categories_args', $cat_args));
                        ?>
                    </ul>
                <?php
                }
                ?>
            </div>
        </div>
        <?php
        echo $after_widget;
    }

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['count'] = !empty($new_instance['count']) ? 1 : 0;
        $instance['hierarchical'] = !empty($new_instance['hierarchical']) ? 1 : 0;
        $instance['dropdown'] = !empty($new_instance['dropdown']) ? 1 : 0;

        return $instance;
    }

    function form( $instance ) {
        //Defaults
        $instance = wp_parse_args( (array) $instance, array( 'title' => '') );
        $title = esc_attr( $instance['title'] );
        $count = isset($instance['count']) ? (bool) $instance['count'] :false;
        $hierarchical = isset( $instance['hierarchical'] ) ? (bool) $instance['hierarchical'] : false;
        $dropdown = isset( $instance['dropdown'] ) ? (bool) $instance['dropdown'] : false;
        ?>
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:','bingo' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

        <p><input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('dropdown'); ?>" name="<?php echo $this->get_field_name('dropdown'); ?>"<?php checked( $dropdown ); ?> />
            <label for="<?php echo $this->get_field_id('dropdown'); ?>"><?php _e( 'Display as dropdown','bingo'  ); ?></label><br />

            <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>"<?php checked( $count ); ?> />
            <label for="<?php echo $this->get_field_id('count'); ?>"><?php _e( 'Show post counts','bingo'  ); ?></label><br />

            <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('hierarchical','bingo' ); ?>" name="<?php echo $this->get_field_name('hierarchical'); ?>"<?php checked( $hierarchical ); ?> />
            <label for="<?php echo $this->get_field_id('hierarchical'); ?>"><?php _e( 'Show hierarchy','bingo'  ); ?></label></p>
    <?php
    }

}

add_action('widgets_init', 'bingo_categories');

function bingo_categories(){
    register_widget('Bingo_Categories');
}








/**
 * Recent_Posts widget class
 *
 * @since 2.8.0
 */
class Bingo_Recent_Posts extends WP_Widget {

    function __construct() {
        $widget_ops = array('classname' => 'recent-posts-widget', 'description' => __( "Bingo&#8217;s most recent Posts.", 'bingo') );
        parent::__construct('bingo-recent-posts', __('Bingo Recent Posts', 'bingo'), $widget_ops);
        $this->alt_option_name = 'recent-posts-widget';

        add_action( 'save_post', array($this, 'flush_widget_cache') );
        add_action( 'deleted_post', array($this, 'flush_widget_cache') );
        add_action( 'switch_theme', array($this, 'flush_widget_cache') );
    }

    function widget($args, $instance) {


            $cache = wp_cache_get( 'widget_recent_posts', 'widget' );


        if ( ! is_array( $cache ) ) {
            $cache = array();
        }

        if ( ! isset( $args['widget_id'] ) ) {
            $args['widget_id'] = $this->id;
        }

        if ( isset( $cache[ $args['widget_id'] ] ) ) {
            echo $cache[ $args['widget_id'] ];
            return;
        }

        ob_start();
        extract($args);

        $title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Bingo Recent Posts', 'bingo' );
        $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
        $number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
        if ( ! $number )
            $number = 5;
        $show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;

        /**
         * Filter the arguments for the Recent Posts widget.
         *
         * @since 3.4.0
         *
         * @see WP_Query::get_posts()
         *
         * @param array $args An array of arguments used to retrieve the recent posts.
         */
        $r = new WP_Query( array(
            'posts_per_page'      => $number,
            'no_found_rows'       => true,
            'post_status'         => 'publish',
            'ignore_sticky_posts' => true
        ) );

        if ($r->have_posts()) : ?>

        <?php echo $before_widget; ?>
        <?php if ( $title ) echo $before_title . $title . $after_title; ?>
        <div class="widget-content">
            <ul>
            <?php while ( $r->have_posts() ) : $r->the_post(); ?>
                <li>

                    <?php if (has_post_thumbnail()) : ?>

                        <?php
                            $thumb_id = get_post_thumbnail_id();
                            $thumb_url_array = wp_get_attachment_image_src($thumb_id, 'recent-posts-thumb', true);
                            $thumb_url = $thumb_url_array[0];
                        ?>

                        <img class="thumb" src="<?php echo $thumb_url; ?>">


                    <?php else: ?>
                    <img src="<?php print IMAGES . '/no-image.png'; ?>" alt="" class="thumb">
                    <?php endif; ?>
                    <h6><a href="<?php the_permalink(); ?>"><?php get_the_title() ? the_title() : the_ID(); ?></a></h6>
                    <p><?php
                            $content = get_the_content();
                            $trimmed_content = wp_trim_words( $content, 10 );
                            echo $trimmed_content;
                        ?>
                    </p>
                <?php if ( $show_date ) : ?>
                    <span class="post-date"><?php echo get_the_date(); ?></span>
                <?php endif; ?>
                </li>
            <?php endwhile; ?>
            </ul>
        </div>

        <?php echo $after_widget;
        // Reset the global $the_post as this query will have stomped on it
        wp_reset_postdata();

        endif;

        $cache[$args['widget_id']] = ob_get_flush();
        wp_cache_set('widget_recent_posts', $cache, 'widget');
    }

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['number'] = (int) $new_instance['number'];
        $instance['show_date'] = isset( $new_instance['show_date'] ) ? (bool) $new_instance['show_date'] : false;
        $this->flush_widget_cache();

        $alloptions = wp_cache_get( 'alloptions', 'options' );
        if ( isset($alloptions['widget_recent_entries']) )
            delete_option('widget_recent_entries');

        return $instance;
    }

    function flush_widget_cache() {
        wp_cache_delete('widget_recent_posts', 'widget');
    }

    function form( $instance ) {
        $title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
        $number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
        $show_date = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : false;
?>
        <p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'bingo' ); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

        <p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to show:', 'bingo' ); ?></label>
        <input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>

        <p><input class="checkbox" type="checkbox" <?php checked( $show_date ); ?> id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>" />
        <label for="<?php echo $this->get_field_id( 'show_date' ); ?>"><?php _e( 'Display post date?', 'bingo' ); ?></label></p>
<?php
    }
}



add_action('widgets_init', 'bingo_recent_posts');

function bingo_recent_posts(){
    register_widget('Bingo_Recent_Posts');
}









/**
 * Tag cloud widget class
 *
 * @since 2.8.0
 */
class Bingo_Tag_Cloud extends WP_Widget {

    function __construct() {
        $widget_ops = array( 'description' => __( "Bingo Tag cloud of your most used tags.", 'bingo') );
        parent::__construct('tag_cloud', __('Bingo Tag Cloud','bingo'), $widget_ops);
    }

    function widget( $args, $instance ) {
        extract($args);
        $current_taxonomy = $this->_get_current_taxonomy($instance);
        if ( !empty($instance['title']) ) {
            $title = $instance['title'];
        } else {
            if ( 'post_tag' == $current_taxonomy ) {
                $title = __('Tags','bingo');
            } else {
                $tax = get_taxonomy($current_taxonomy);
                $title = $tax->labels->name;
            }
        }

        /** This filter is documented in wp-includes/default-widgets.php */
        $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

        echo $before_widget;
        if ( $title )
            echo $before_title . $title . $after_title;
        // echo '<ul class="footer-tags clearfix">';

        /**
         * Filter the taxonomy used in the Tag Cloud widget.
         *
         * @since 2.8.0
         * @since 3.0.0 Added taxonomy drop-down.
         *
         * @see wp_tag_cloud()
         *
         * @param array $current_taxonomy The taxonomy to use in the tag cloud. Default 'tags'.
         */
        wp_tag_cloud( array(
            'smallest' => '1',
            'largest'  => '2',
            'unit'     => 'em',
            'number'   => 7,
            'taxonomy' => $current_taxonomy,
            'format'   => 'list',
        ) );

        // echo "</ul>\n";
        echo $after_widget;
    }

    function update( $new_instance, $old_instance ) {
        $instance['title'] = strip_tags(stripslashes($new_instance['title']));
        $instance['taxonomy'] = stripslashes($new_instance['taxonomy']);
        return $instance;
    }

    function form( $instance ) {
        $current_taxonomy = $this->_get_current_taxonomy($instance);
?>
    <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','bingo') ?></label>
    <input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php if (isset ( $instance['title'])) {echo esc_attr( $instance['title'] );} ?>" /></p>
    <p><label for="<?php echo $this->get_field_id('taxonomy'); ?>"><?php _e('Taxonomy:','bingo') ?></label>
    <select class="widefat" id="<?php echo $this->get_field_id('taxonomy'); ?>" name="<?php echo $this->get_field_name('taxonomy'); ?>">
    <?php foreach ( get_taxonomies() as $taxonomy ) :
                $tax = get_taxonomy($taxonomy);
                if ( !$tax->show_tagcloud || empty($tax->labels->name) )
                    continue;
    ?>
        <option value="<?php echo esc_attr($taxonomy) ?>" <?php selected($taxonomy, $current_taxonomy) ?>><?php echo $tax->labels->name; ?></option>
    <?php endforeach; ?>
    </select></p><?php
    }

    function _get_current_taxonomy($instance) {
        if ( !empty($instance['taxonomy']) && taxonomy_exists($instance['taxonomy']) )
            return $instance['taxonomy'];

        return 'post_tag';
    }
}


add_action('widgets_init', 'bingo_tag_cloud');

function bingo_tag_cloud(){
    register_widget('Bingo_Tag_Cloud');
}





class Bingo_flickr_widget extends WP_Widget {

    function Bingo_flickr_widget()
    {
        $widget_ops = array('classname' => 'flickr', 'description' => '');

        $control_ops = array('id_base' => 'flickr-widget');

        $this->WP_Widget('flickr-widget', 'Bingo - Flickr', $widget_ops, $control_ops);
    }

    function widget($args, $instance)
    {
        extract($args);
        $title = apply_filters('widget_title', $instance['title']);
        $flickr_id = $instance['flickr_id'];

        $count = $instance['count'];

        echo $before_widget;

        if($title) {
            echo $before_title.$title.$after_title;
        }

        if($flickr_id) { ?>

        <script type="text/javascript">


        jQuery(document).ready(function($){
            $('#flickr_<?php echo $args['widget_id']; ?>').jflickrfeed({
                    limit: <?php echo $count; ?>,
                    qstrings: {
                        id: '<?php echo $flickr_id; ?>'
                    },
                    itemTemplate: '<li class="col-xs-4"><span><a href="{{image_b}}"><img src="{{image_s}}" alt="{{title}}" /></a></span></li>'
            });
        });





        </script>




            <ul class="flickr-photos" id="flickr_<?php echo $args['widget_id']; ?>">

            </ul>



        <?php }

        echo $after_widget;
    }

    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;

        $instance['title'] = strip_tags($new_instance['title']);
        $instance['flickr_id'] = $new_instance['flickr_id'];

        $instance['count'] = $new_instance['count'];

        return $instance;
    }

    function form($instance)
    {
        $defaults = array('title' => 'Flickr', 'flickr_id' => '37304598@N02', 'count' => 9);
        $instance = wp_parse_args((array) $instance, $defaults); ?>

        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
            <input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('flickr_id'); ?>">Flickr ID:</label>
            <input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('flickr_id'); ?>" name="<?php echo $this->get_field_name('flickr_id'); ?>" value="<?php echo $instance['flickr_id']; ?>" />
        </p>

            <label for="<?php echo $this->get_field_id('count'); ?>">Number of Photos:</label>
            <input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" value="<?php echo $instance['count']; ?>" />
        </p>

    <?php
    }
}

add_action('widgets_init', 'bingo_flickr_init');

function bingo_flickr_init()
{
    register_widget('Bingo_flickr_widget');
}




/**
*newsletter widget
**/
class Bingo_newsletter extends WP_Widget {
   function __construct() {
        $widget_ops = array( 'description' => __('Widget for social network','bingo') );
        parent::__construct( 'bingo-newsletter', __('Bingo NewsLetter','bingo'), $widget_ops );
    }
    function widget( $args, $instance ) {
        extract( $args );
            // $title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'KEEP IN TOUCH', 'bingo' );
            $title = apply_filters('widget_title', empty( $instance['title'] ) ? __( 'KEEP IN TOUCH','bingo'  ) : $instance['title'], $instance, $this->id_base);
            $text = apply_filters( 'widget_text', empty( $instance['text'] ) ? '' : $instance['text'], $instance );
            $bingo_newsletter  = isset( $instance['bingo_newsletter'] ) ? esc_attr( $instance['bingo_newsletter'] ) : '';
        ?>
        <?php echo $before_widget; ?>
            <?php if ( $title ) echo $before_title . $title . $after_title; ?>

            <p><?php echo !empty( $instance['filter'] ) ? wpautop( $text ) : $text; ?></p>
                
                <div class="footer-subscribe">
                    <?php if( !empty($bingo_newsletter) ){ ?>
                    
                        <form action="<?php echo esc_url( $bingo_newsletter ); ?>">
                            <input type="email" name="newsletter_email" placeholder="Enter email address" method="post">
                            <input type="submit" value="&#xf067;">
                        </form>

                    <?php }else{ ?>
                                <p><?php _e('Please add action link.', 'bingo'); ?></p>
                    <?php } ?>
                </div>
        <?php echo $after_widget; ?>

      
    <?php
}
  
    function update( $new_instance, $old_instance ) {
        // update logic goes here
        $updated_instance = $new_instance;
        if ( current_user_can('unfiltered_html') )
            $instance['text'] =  $new_instance['text'];
        else
            $instance['text'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['text']) ) );
        return $updated_instance;

    }
   
    function form( $instance ) {
        
        $title  = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
        $text = esc_textarea($instance['text']);
        $bingo_newsletter  = isset( $instance['bingo_newsletter'] ) ? esc_attr( $instance['bingo_newsletter'] ) : '';
        ?>

        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'bingo' ); ?></label> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>

        <textarea class="widefat" rows="16" cols="20" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo $text; ?></textarea>

        <p><label for="<?php echo $this->get_field_id('bingo_newsletter'); ?>"><?php _e(' Link:', 'bingo' ); ?></label> <input class="widefat" id="<?php echo $this->get_field_id('bingo_newsletter'); ?>" name="<?php echo $this->get_field_name('bingo_newsletter'); ?>" type="text" value="<?php echo esc_url( $bingo_newsletter ); ?>" /></p>


<?php
       
    }
}

add_action('widgets_init', 'bingo_newsletter');

function bingo_newsletter(){
    register_widget('Bingo_newsletter');
}

//Bingo social widget

class Bingo_social_widget extends WP_Widget {

    function Bingo_social_widget()
    {
        $widget_ops = array('classname' => 'bingo-social', 'description' => '');

        $control_ops = array('id_base' => 'bingo-social-widget');

        $this->WP_Widget('bingo-social-widget', 'Bingo - Social', $widget_ops, $control_ops);
    }

    function widget($args, $instance)
    {
        extract($args);
        $title = apply_filters('widget_title', $instance['title']);
        $social = $instance['social'];
        $social_link = $instance['social_link'];
        

        echo $before_widget;

        if($title) {
            echo $before_title.$title.$after_title;
        }

        if($social) { ?>

            <ul class="social-nav model-8 social-nav1">
                <?php 
                    foreach($social as $value){
                        ?>
                        <li><a href="<?php echo $social_link[$value]; ?>" class="<?php echo $value; ?>"><i></i></a></li>
                        <?php
                    }
                ?>
            </ul>

        <?php }

        echo $after_widget;
    }

    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;

        $instance['title'] = strip_tags($new_instance['title']);
         $instance['social'] = array();
         $instance['social_link'] = array();

            if ( isset ( $new_instance['social'] ) )
            {
                foreach ( $new_instance['social'] as $value )
                {
                    if ( '' !== trim( $value ) )
                        $instance['social'][] = $value;
                }
            }
            if ( isset ( $new_instance['social_link'] ) )
            {
                foreach ( $new_instance['social_link'] as $key => $value )
                {
                    if ( '' !== trim( $value ) )
                        $instance['social_link'][$key] = $value;
                }
            }

        $instance['count'] = $new_instance['count'];

        return $instance;
    }

    function form($instance)
    {
        $defaults = array('title' => 'Follow Us');
        $social =  ($instance['social']) ? $instance['social'] :  array();
        $social_link =  ($instance['social_link']) ? $instance['social_link'] :  array();
        $instance = wp_parse_args((array) $instance, $defaults); 
        ?>

        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
            <input  class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
        </p>
        
        <p>
            <label>Facebook:</label>
            <input type="checkbox" class="widefat" name="<?php echo $this->get_field_name('social'); ?>[]" value="facebook" <?php echo in_array('facebook', $social) ? 'checked' : ''; ?> />
        </p>
        <p>
            <label>Facebook link:</label>
            <input  class="widefat" style="width: 216px;" name="<?php echo $this->get_field_name('social_link'); ?>[facebook]" value="<?php echo $social_link['facebook']; ?>" />
        </p>
        <p>
            <label>Twitter:</label>
            <input type="checkbox" class="widefat" name="<?php echo $this->get_field_name('social'); ?>[]" value="twitter" <?php echo in_array('twitter', $social) ? 'checked' : ''; ?> />
        </p>
        <p>
            <label>Twitter link:</label>
            <input  class="widefat" style="width: 216px;" name="<?php echo $this->get_field_name('social_link'); ?>[twitter]" value="<?php echo $social_link['twitter']; ?>" />
        </p>
        <p>
            <label>Google+:</label>
            <input type="checkbox" class="widefat" name="<?php echo $this->get_field_name('social'); ?>[]" value="g" <?php echo in_array('g', $social) ? 'checked' : ''; ?> />
        </p>
        <p>
            <label>Google link:</label>
            <input  class="widefat" style="width: 216px;" name="<?php echo $this->get_field_name('social_link'); ?>[g]" value="<?php echo $social_link['g']; ?>" />
        </p>
        <p>
            <label>Pinterest:</label>
            <input type="checkbox" class="widefat" name="<?php echo $this->get_field_name('social'); ?>[]" value="p" <?php echo in_array('p', $social) ? 'checked' : ''; ?> />
        </p>
        <p>
            <label>Pinterest link:</label>
            <input  class="widefat" style="width: 216px;" name="<?php echo $this->get_field_name('social_link'); ?>[p]" value="<?php echo $social_link['p']; ?>" />
        </p>

    <?php
    }
}

add_action('widgets_init', 'Bingo_social_widget_init');

function Bingo_social_widget_init()
{
    register_widget('Bingo_social_widget');
}

// END Bingo social widget


//Bingo custom menu widget

class Bingo_custom_menu_widget extends WP_Widget {

    function Bingo_custom_menu_widget()
    {
        $widget_ops = array('classname' => 'bingo-custom-menu', 'description' => '');

        $control_ops = array('id_base' => 'bingo-custom-menu-widget');

        $this->WP_Widget('bingo-custom-menu-widget', 'Bingo - Custom Menu', $widget_ops, $control_ops);
    }

    function widget($args, $instance)
    {
        extract($args);
        $title = apply_filters('widget_title', $instance['title']);

        echo $before_widget;

        if($title) {
            echo $before_title.$title.$after_title;
        }

        if($instance['menu']) { ?>

            <?php
            $args = array(
                    'menu'            => $instance['menu'],              
                    'container'       => '',           // (string) Контейнер меню. Обворачиватель ul. Указывается тег контейнера (по умолчанию в тег div)
                    'container_class' => '',              // (string) class контейнера (div тега)
                    'container_id'    => '',              // (string) id контейнера (div тега)
                    'menu_class'      => 'footer-nav',          // (string) class самого меню (ul тега)
                    'menu_id'         => '',              // (string) id самого меню (ul тега)
                    'echo'            => true,            // (boolean) Выводить на экран или возвращать для обработки
                    'fallback_cb'     => 'wp_page_menu',  // (string) Используемая (резервная) функция, если меню не существует (не удалось получить)
                    'before'          => '',              // (string) Текст перед <a> каждой ссылки
                    'after'           => '',              // (string) Текст после </a> каждой ссылки
                    'link_before'     => '',              // (string) Текст перед анкором (текстом) ссылки
                    'link_after'      => '',              // (string) Текст после анкора (текста) ссылки
                    'depth'           => 0,               // (integer) Глубина вложенности (0 - неограничена, 2 - двухуровневое меню)
                    'walker'          => '',              // (object) Класс собирающий меню. Default: new Walker_Nav_Menu
                    'theme_location'  => ''               // (string) Расположение меню в шаблоне. (указывается ключ которым было зарегистрировано меню в функции register_nav_menus)
            );
            wp_nav_menu($args);
            ?>

        <?php }

        echo $after_widget;
    }

    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;

        $instance['title'] = strip_tags($new_instance['title']);

        $instance['menu'] = $new_instance['menu'];

        return $instance;
    }

    function form($instance)
    {
        $defaults = array('title' => 'Navigation');
        $instance = wp_parse_args((array) $instance, $defaults); 
        $menus = get_terms('nav_menu');
        ?>

        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
            <input  class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
        </p>
        
        <p>
            <label>Select menu:</label>
            <select class='widefat' style="width: 216px;" name="<?php echo $this->get_field_name('menu'); ?>">
                <?php
                    if ($menus){
                        foreach($menus as $menu){
                            if($menu->slug == $instance['menu']){
                                $selected = 'selected';
                            }else{
                                $selected = '';
                            }
                            ?>
                            <option value='<?php echo $menu->slug ?>' <?php echo $selected; ?>><?php echo $menu->name; ?></option>
                            <?php
                        }
                    }
                ?>
            </select>
            
            
        </p>

    <?php
    }
}

add_action('widgets_init', 'Bingo_custom_menu_widget_init');

function Bingo_custom_menu_widget_init()
{
    register_widget('Bingo_custom_menu_widget');
}

/*function bingo_newsletter(){
    register_widget('Bingo_newsletter');
}*/

//Bingo social widget

class Bingo_advanced_search extends WP_Widget {

    function Bingo_advanced_search()
    {
        $widget_ops = array('classname' => 'bingo-social', 'description' => '');

        $control_ops = array('id_base' => 'bingo-social-widget');

        $this->WP_Widget('bingo-social-widget', 'Bingo - Advanced Search', $widget_ops, $control_ops);
    }

    function widget($args, $instance)
    {
        extract($args);
        $title = apply_filters('widget_title', $instance['title']);

        echo $before_widget;

        if($title) {
            echo $before_title.$title.$after_title;
        }

        $wb_n_c 		= new wb_get_cat();
        $wb_data_arr 	= $wb_n_c->wb_get_arr_cat();
        $wb_sub_cat_arr = json_encode($wb_n_c->get_tree_sub($wb_data_arr));

        if (isset($_GET['save_filter_name']) && !empty($_GET['save_filter_name'])){
            save_advanced_filter($_GET['save_filter_name']);
        }

        ?>
        <form action="\" method="GET" class="form-vertical advanced-search-form" enctype="multipart/form-data" id="advanced_search_form" autocomplete="off">
            <input type="hidden" value name="s">
            <input type="hidden" value="product" name="post_type">
            <div class="form-group">
                <h4>Seach by action</h4>
                <div class="no-padding">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" id="emergency" value='Emergency' name="breaking[]" />Emergency 
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" id="natural_disaster" value="Natural Disaster" name="breaking[]" />Natural Disaster 
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" id="accident" value="Accident" name="breaking[]" />Accident 
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" id="health" value="Health" name="breaking[]" />Health 
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" id="disturbance" value="Disturbance" name="breaking[]" />Disturbance
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" id="crime" value="Crime" name="breaking[]" />Crime
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" id="politics" value="Politics" name="breaking[]" />Politics
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" id="public_event" value="Public Event" name="breaking[]" />Public Event
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" id="business_commerce" value="Business/Commerce" name="breaking[]" />Business/Commerce
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" id="famous_person" value="Famous Person" name="breaking[]" />Famous Person
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" id="other" value="" name="" />Other
                        </label>
                        <input id="other-breaking" name="breaking[]" disabled />

                    </div>

                </div>
            </div>

            <div class="form-group">
                <h4>Search by category</h4>
                <div class="no-padding">
                    <label for="category">Category:</label>
                    <span id="cat-info" class="error-info"></span>

                    <select id="category" class="form-control" onchange="get_sub_cat(this.value); return false;">
                        <option value="0"><span style="color:#cccccc;">Select category</span></option>
                        <?php
                        $wb_n_c->wb_get_tree($wb_data_arr, 1);
                        ?>
                    </select>
                </div>

                <div class="no-padding">
                    <label for="sub_category">Subcategory:</label>
                    <select id="sub_category" class="form-control" name="category">
                        <option value="0">Select subcategory</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <h4>Search by location</h4>
                <div class="no-padding">
                    <label class="" for="title">Location: *</label>
                    <span id="loc-info" class="error-info"></span>
                    <input type="text" id="add-location" class="form-control" name="location" />
                </div>
            </div>

            <div class="form-group">
                <h4>Seach by time</h4>
                <div class="no-padding">
                    <div class="radio">
                        <label>
                            <input type="radio" id="now" value='now' name="time" />Now
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" id="last_hour" value="last_hour" name="time" />Last hour
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" id="today" value="today" name="time" />Today
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" id="this_week" value="this_week" name="time" />This week
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" id="this_month" value="this_month" name="time" />This month
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" id="other_date" value="other_date" name="time" />Search archives
                        </label><br>
                        <label class="" for="custom_date_from">From:</label>
                        <input type="date" id="custom_date_from" value="" name="other_time_from" disabled/><br>
                        <label class="" for="custom_date_from">To:</label>
                        <input type="date" id="custom_date_to" value="" name="other_time_to" disabled/>

                    </div>

                </div>
            </div>

            <div class="form-group">
                <h4>Sorting</h4>
                <div class="no-padding">
                    <div class="radio">
                        <label>
                            <input type="radio" id="date_sorting" value='date' name="sorting" />Time, most recent first
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" id="popular_sorting" value="popular" name="sorting" />Most popular
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <h4>Search by tags</h4>
                <div class="no-padding">
                    <label class="" for="search_tags">Tags(separated by comma):</label>
                    <span id="loc-info" class="error-info"></span>
                    <input type="text" id="search_tags" class="form-control" name="tags" />
                </div>
            </div>

            <?php if (is_user_logged_in()){ ?>

            <div class="form-group">
                <h4>Save filter</h4>
                <div class="no-padding">
                    <label class="" for="save_filter">Name for filter:</label>
                    <span id="loc-info" class="error-info"></span>
                    <input type="text" id="save_filter" class="form-control" name="save_filter_name" />
                </div>
            </div>
            <?php
                $user_id = get_current_user_id();

                $user_filters = get_user_meta($user_id, 'advanced_filters',true);

                $user_filters = unserialize($user_filters);
            ?>
            <div class="form-group">
                <h4>Saved filters</h4>
                <div class="no-padding filter-list">
                    <?php
                    foreach ($user_filters as $filter_key => $filter){
                        ?>
                            <br><a href="?s=&post_type=product&filter_name=<?php echo $filter_key;?>" data-filter="<?php echo $filter_key; ?>"><?php echo $filter_key; ?></a> <span class="remove_filter" data-filter="<?php echo $filter_key; ?>"> x</span>
                        <?php
                    }
                    ?>

                </div>
            </div>


            <?php } ?>

            <div class="form-group">

                    <input type="submit" id="submit" class="form-control" name="submit" value ="Search" />

            </div>

            <?php if (!is_user_logged_in()){ ?>

            <div class="form-group">
                <div class="no-padding">

                    <a href="/login">** to save filter of your favorite search please login</a>

                </div>
            </div>

            <?php } ?>


        </form>

        <script type="text/javascript">
            var $ = jQuery;
            function get_sub_cat(data){
                var arr = <?php echo $wb_sub_cat_arr;?>;
                $("#sub_category").empty();
                $("#sub_category").append( $('<option value="0">Select subcategory</option>'));
                var cat_id = $('#sub_category').attr('data-category-id');
                var selected;
                if(data > 0){
                    $('#sub_category').show();
                    $.each(arr, function(i, val) {
                        if(data == i){
                            val.sort(function(a, b){return a-b});
                            $.each(val, function(s, d) {
                                if (cat_id == d.id){
                                    selected = 'selected';
                                }else{
                                    selected = '';
                                }
                                $("#sub_category").append( $('<option value="'+d.id+'" '+selected+'>'+d.title+'</option>'));
                            });
                        }
                    });
                }
            }

            $('#other').on('change', function(){
                if (this.checked){
                    $('#other-breaking').attr('disabled', false);
                }else{
                    $('#other-breaking').val('');
                    $('#other-breaking').attr('disabled', true);

                }
            });

            $('input[name="time"').on('change', function(){
                if (jQuery(this).attr('id') == 'other_date'){
                    $('#custom_date_from').attr('disabled', false);
                    $('#custom_date_to').attr('disabled', false);
                }else{
                    $('#custom_date_from').val('');
                    $('#custom_date_from').attr('disabled', true);
                    $('#custom_date_to').val('');
                    $('#custom_date_to').attr('disabled', true);

                }
            });

            function add_location() {
                var input = $('#add-location')[0];
                var options = {
                    types: ['(regions)']
                };
                window.autocomplete = new google.maps.places.Autocomplete(input, options);
                google.maps.event.addListener(autocomplete, 'place_changed', function() {
                    var place = window.autocomplete.getPlace();
                });
            }
            google.maps.event.addDomListener(window, 'load', add_location);


        </script>



        <?php





        echo $after_widget;
    }

    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;

        $instance['title'] = strip_tags($new_instance['title']);

//        if ( isset ( $new_instance['social'] ) )
//        {
//            foreach ( $new_instance['social'] as $value )
//            {
//                if ( '' !== trim( $value ) )
//                    $instance['social'][] = $value;
//            }
//        }

        return $instance;
    }

    function form($instance){
        $defaults = array('title' => 'Advanced Search');
        $instance = wp_parse_args((array) $instance, $defaults);
        ?>

        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
            <input  class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
        </p>

        <?php
    }
}

add_action('widgets_init', 'Bingo_advanced_search_init');

function Bingo_advanced_search_init(){
    register_widget('Bingo_advanced_search');
}

function save_advanced_filter($filter_name =''){

    $user_id = get_current_user_id();

    $user_filters = get_user_meta($user_id, 'advanced_filters',true);

    $user_filters = unserialize($user_filters);

    $user_filters[$filter_name] = $_GET;

    $user_filters  = serialize($user_filters);

    $status = update_user_meta($user_id,'advanced_filters', $user_filters);

    return $status;
}

function get_advanced_filter($filter_name = ''){
    $user_id = get_current_user_id();

    $user_filters = get_user_meta($user_id, 'advanced_filters',true);

    $user_filters = unserialize($user_filters);

    $filter = $user_filters[$filter_name];

    return $filter;

}
// END Bingo custom menu widget




