<?php


// http://justintadlock.com/archives/2013/10/07/post-relationships-parent-to-child

/* Hook meta box to just the 'place' post type. */
add_action( 'add_meta_boxes_place', 'my_add_meta_boxes' );

/* Creates the meta box. */
function my_add_meta_boxes( $post ) {

    add_meta_box(
        'my-place-parent',
        __( 'Neighborhood', 'example-textdomain' ),
        'my_place_parent_meta_box',
        $post->post_type,
        'side',
        'core'
    );
}

/* Displays the meta box. */
function my_place_parent_meta_box( $post ) {

    $parents = get_posts(
        array(
            'post_type'   => 'neighborhood', 
            'orderby'     => 'title', 
            'order'       => 'ASC', 
            'numberposts' => -1 
        )
    );

    if ( !empty( $parents ) ) {

        echo '<select name="parent_id" class="widefat">'; // !Important! Don't change the 'parent_id' name attribute.

        foreach ( $parents as $parent ) {
            printf( '<option value="%s"%s>%s</option>', esc_attr( $parent->ID ), selected( $parent->ID, $post->post_parent, false ), esc_html( $parent->post_title ) );
        }

        echo '</select>';
    }
}