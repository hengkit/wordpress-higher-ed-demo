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

    public function widget( $args, $instance ) {

        // This is the section to edit in the demo.
         $button_classes = 'btn btn-lG';
	 //$button_classes = 'btn btn-lG highlight';

        if (!empty($_SERVER['PANTHEON_SITE_NAME'])) {
            $pantheon_site_machine_name = $_SERVER['PANTHEON_SITE_NAME'];
        } else {
            $pantheon_site_machine_name = '';
        }

        $cta = $this->cta_text();
        $background_position = 'center';
        $padding = "pt-5 pb-5";
        $height = "auto";
        $light_dark = 'light';

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
            $light_dark = 'dark';
            $height= "700px";
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
            $light_dark = 'light';
        }

        echo '<div class="jumbotron jumbotron-fluid bg-primary ' . $light_dark . '" style="height: '. $height . '; background-image: url(https://dev-alumni-magazine.pantheonsite.io/sites/default/files/images/' . $image . '); background-repeat: no-repeat; background-position: '. $background_position . '; background-size: cover" >
            <div class="container ' . $padding.'">
	            <div class="row">
		            <div class="' . $columns . ' bg-semi-transparent">
		                <h1 class="display-3">'.$h1 .'</h1>
			            <p class="lead">'. $lead . '</p>
		                <a class="'.$button_classes .'" href="#">'. $cta . '</a><br/>
		                <a class="btn btn-sm btn-link" href="#" role="button">See our majors</a>
		                <a class="btn btn-sm btn-link" href="#" role="button">Course list</a>
		            </div>
		        </div>
            </div>
        </div>';

    }

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
        return 'Apply now to join our next freshman class';
    }


    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['color'] = $new_instance['color'];
        return $instance;
    }
/*
 * @todo, configurable settings
 *
    public function form( $instance ) {
        // PART 1: Extract the data from the instance variable
        $instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
        $title = $instance['title'];
        $color = $instance['color'];

        // PART 2-3: Display the fields
        ?>


        <!-- PART 3: Widget color field START -->
        <p>
            <label for="<?php echo $this->get_field_id('text'); ?>">color:
                <select class='widefat' id="<?php echo $this->get_field_id('color'); ?>"
                        name="<?php echo $this->get_field_name('color'); ?>" type="text">
                    <option value='light'<?php echo ($color=='light')?'selected':''; ?>>
                        Light
                    </option>
                    <option value='dark'<?php echo ($color=='dark')?'selected':''; ?>>
                        Dark
                    </option>
                </select>
            </label>
        </p>
        <!-- Widget color field END -->
        <?php
    }
*/



}
