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

    public function cta_text() {
      // return 'Apply now to join our next freshman class';
       return 'Apply now to join the class of 2023';
    }



    public function widget( $args, $instance ) {

        if (!empty($_SERVER['PANTHEON_SITE_NAME'])) {
            $pantheon_site_machine_name = $_SERVER['PANTHEON_SITE_NAME'];
        } else {
            $pantheon_site_machine_name = '';
        }

//        $pantheon_site_machine_name = 'hed-creative-writing';
  //      $pantheon_site_machine_name = 'hed-anthropology';
//        $pantheon_site_machine_name = 'hed-ee';
        $cta = $this->cta_text();
        $background_position = 'center';
        $padding = "pt-5 pb-5";
        $height= "auto";

        if ($pantheon_site_machine_name === 'hed-anthropology') {
            $h1 = "Explore Humanity's History";
            $lead = "Uncovering new truth through the biological, cognitive, and social sciences";
            $image = "shutterstock_222382861.jpg";

            $columns = 'col-md-5';
        } else if ($pantheon_site_machine_name === 'hed-ee') {
            $h1 = "Reach Your Full Potential";
            $lead = "Be on the cutting edge of the next technological revolution";
            $image = 'shutterstock_327572696.jpg';
            $columns = 'col-md-5';
        } else if ($pantheon_site_machine_name === 'hed-creative-writing') {

            $h1 = "A Novel Approach to Writing";
            $lead = "Our supportive faculty will help you write your truth";
            $padding = "pt-3 pb-5";
            $columns = 'col-md-12';
            $image = "shutterstock_320092919.jpg";
            $background_position= 'bottom';
            $height= "600px";

        } else {
            $h1 = "Preparation for Tomorrow";
            $lead = "Learn the fundamentals today and be ready for whatever the future holds";
            $image = "shutterstock_669390109.jpg";

            $padding = "pt-3 pb-5";
            $columns = 'col-md-5';
        }
        echo '<div class="jumbotron jumbotron-fluid bg-primary" style="height: '. $height . '; background-image: url(https://dev-alumni-magazine.pantheonsite.io/sites/default/files/images/' . $image . '); background-repeat: no-repeat; background-position: '. $background_position . '; background-size: cover" >
<div class="container ' . $padding.'">
	<div class="row">
		<div class="' . $columns . ' bg-transparent-white">
<h1 class="display-3">'.$h1 .'</h1>
	<p class="lead">'. $lead . '</p>
<a class="btn btn-department-highlight btn-lG" href="#">'. $cta . '</a><br/>
<a class="btn btn-sm btn-link" href="#" role="button">See our majors</a>
<a class="btn btn-sm btn-link" href="#" role="button">Course list</a>
</div>
</div>
</div>
</div>';


    }

}
