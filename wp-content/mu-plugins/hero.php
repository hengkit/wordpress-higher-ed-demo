<?php
/*
  Plugin Name: Demo Hero
  Plugin URI: https://pantheon.io/
  Description: Provide a hero for the homepage of EDU demo sites
  Version: 0.1
  Author: Pantheon
  Author URI: https://pantheon.io/
*/


add_action(
    'widgets_init', function () {
    register_widget( 'EDU_Demo_Hero_Header' );
}
);

class EDU_Demo_Hero_Header extends WP_Widget {

    /**
     * Sets up a new Tag Cloud widget instance.
     *
     * @since 2.8.0
     */
    public function __construct() {
        $widget_ops = array(
            'description' => __( 'Hero header used on Pantheon EDU demo sites' ),
            'customize_selective_refresh' => true,
        );
        parent::__construct( 'edu_demo_hero_header', __( 'EDU Demo hero header' ), $widget_ops );
    }

    /**
     * Outputs the content for the current Tag Cloud widget instance.
     *
     * @since 2.8.0
     *
     * @param array $args     Display arguments including 'before_title', 'after_title',
     *                        'before_widget', and 'after_widget'.
     * @param array $instance Settings for the current Tag Cloud widget instance.
     */
    public function widget( $args, $instance ) {




        $site_name = "Sample Jumbotron";
        echo '<div class="jumbotron py-5 jumbotron-fluid bg-primary text-white" style="background-image: url(https://image.shutterstock.com/z/stock-photo-teenagers-young-team-together-cheerful-concept-337964138.jpg); background-repeat: no-repeat; background-position: center">
<div class="container py-5">
	<div class="row">
		<div class="col-md-7">
<h1 class="display-3">'.$site_name .'</h1>
	<p class="lead">Welcome to the UnderStrap demo site.</p>
<a class="btn btn-success btn-lg py-3" href="https://gumroad.com/l/CQrW">Apply Now</a><br/>
<a class="btn btn-sm btn-link text-white-50" href="https://github.com/holger1411/understrap"  target="_blank" role="button">Visit Github</a>
<a class="btn btn-sm btn-link text-white-50" href="https://understrap.com"  target="_blank" role="button">Visit understrap.com</a>
</div>
</div>
</div>
</div>';


    }

}