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

    public function widget( $args, $instance ) {

        if (!empty($_SERVER['PANTHEON_SITE_NAME'])) {
            $pantheon_site_machine_name = $_SERVER['PANTHEON_SITE_NAME'];
        } else {
            $pantheon_site_machine_name = '';
        }

        if ($pantheon_site_machine_name === 'hed-anthropology') {
            $h1 = "Explore Humanity's History";
            $lead = "Uncovering new truth through the biological, cognitive, and social sciences";
        } else if ($pantheon_site_machine_name === 'hed-ee') {
            $h1 = "Take The Leap";
            $lead = "Be on the cutting edge of the next technological revolution";
        } else if ($pantheon_site_machine_name === 'hed-creative-writing') {
            $h1 = "A Novel Approach";
            $lead = "Our supportive faculty will help you write your truth";
        } else {
            $h1 = "Preparation for Tomorrow";
            $lead = "Learn the fundamentals today and be ready for whatever the future holds";
        }
        echo '<div class="jumbotron py-5 jumbotron-fluid bg-primary text-white" style="background-image: url(https://image.shutterstock.com/z/stock-photo-teenagers-young-team-together-cheerful-concept-337964138.jpg); background-repeat: no-repeat; background-position: center">
<div class="container py-5">
	<div class="row">
		<div class="col-md-7">
<h1 class="display-3">'.$h1 .'</h1>
	<p class="lead">'. $lead . '</p>
<a class="btn btn-success btn-lg py-3" href="https://gumroad.com/l/CQrW">Apply Now</a><br/>
<a class="btn btn-sm btn-link text-white-50" href="#" role="button">See our majors</a>
<a class="btn btn-sm btn-link text-white-50" href="#" role="button">Course list</a>
</div>
</div>
</div>
</div>';


    }

}