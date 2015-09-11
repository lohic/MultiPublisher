<?php


//// http://wordpress.stackexchange.com/questions/128622/creating-a-relationship-between-two-post-types
//
// http://justintadlock.com/archives/2009/06/04/using-custom-taxonomies-to-create-a-movie-database
// http://justintadlock.com/archives/2013/10/07/post-relationships-parent-to-child

// Using a Plugin

// Some very good plugins for relationships:

// ACF Relationship Field
// Posts-2-Posts
// Using a Metabox

// You can build a simple relationship using metaboxes:

add_action( 'admin_init', 'add_meta_boxes' );
function add_meta_boxes() {
    add_meta_box( 'some_metabox', 'Movies Relationship', 'movies_field', 'series' );
}

function movies_field() {
    global $post;
    $selected_movies = get_post_meta( $post->ID, '_movies', true );
    $all_movies = get_posts( array(
        'post_type' => 'movies',
        'numberposts' => -1,
        'orderby' => 'post_title',
        'order' => 'ASC'
    ) );
    ?>
    <input type="hidden" name="movies_nonce" value="<?php echo wp_create_nonce( basename( __FILE__ ) ); ?>" />
    <table class="form-table">
    <tr valign="top"><th scope="row">
    <label for="movies">Movies</label></th>
    <td><select name="movies">
    <?php foreach ( $all_movies as $movie ) : ?>
        <option value="<?php echo $movie->ID; ?>"<?php echo ' selected="selected"' ? in_array( $movie->ID, $selected_movies ) : ''; ?>><?php echo $movie->post_title; ?></option>
    <?php endforeach; ?>
    </select></td></tr>
    </table>
    <?php
}

add_action( 'save_post', 'save_movie_field' );
function save_movie_field( $post_id ) {

    // only run this for series
    if ( 'series' != get_post_type( $post_id ) )
        return $post_id;        

    // verify nonce
    if ( empty( $_POST['movies_nonce'] ) || !wp_verify_nonce( $_POST['movies_nonce'], basename( __FILE__ ) ) )
        return $post_id;

    // check autosave
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
        return $post_id;

    // check permissions
    if ( !current_user_can( 'edit_post', $post_id ) ) {
        return $post_id;

    // save
    update_post_meta( $post_id, '_movies', array_map( 'intval', $_POST['movies'] ) );

}
//And then, to get the movies relationship as a list for series posts:

$series = new WP_Query( array(
    'post_type' => 'movies',
    'post__in' => get_post_meta( $series_id, '_movies', true ),
    'nopaging' => true
) );

if ( $series-> have_posts() ) { while ( $series->have_posts() ) {
    $series->the_post();
    ?>
    <li><a href="<?php the_permalink(); ?>"><?php the_title(); ></a></li>
    <?php
} }
