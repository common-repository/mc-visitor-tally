<?php

	// ADDS MC VISITOR TALLY WIDGET

	class MC6397vt_Widget extends WP_Widget {

 
     	// REGISTER WIDGET IN WORDPRESS

    public function __construct() {

        parent::__construct(
            'mc6397vt_widget', // Base ID
            'MC Visitor Tally', // Name
            array( 'description' => __( 'Add visitor tally widget to your website.', 'text_domain' ), ) // Args
        );

    }

	// FRONT-END DISPLAY OF WIDGET

    	public function widget( $args, $instance ) {
        extract( $args );
        $title = apply_filters( 'widget_title', $instance['title'] );

        echo $before_widget;
        if ( ! empty( $title ) ) {
            echo $before_title . $title . $after_title;
        }

	$mc6397vtdata=mc6397vt_get_visitor_data();
	$mc6397vtyear=get_option('mc6397vt_showyear');
	$mc6397vt_type=get_option('mc6397vt_table_type');
	$mc6397vt_color=get_option('mc6397vt_table_color');
	$mc6397vt_resp=get_option('mc6397vt_table_resp');
?>

	<div>
        <table class = "<?php echo "$mc6397vt_type" ?> <?php echo "$mc6397vt_color" ?> <?php echo "$mc6397vt_resp" ?>" >
            <tr>
                <td>Today</td>
                <td align="right"><?php echo $mc6397vtdata['today'] ?></td>
            </tr>
            <tr>
                <td>Yesterday</td>
                <td align="right"><?php echo $mc6397vtdata['yesterday'] ?></td>
            </tr>
            <tr>
                <td>Past 7 Days</td>
                <td align="right"><?php echo $mc6397vtdata['pastWeek']; ?></td>
            </tr>
            <tr>
                <td>Month of <?php echo current_time( 'F' ) ?></td>
                <td align="right">&nbsp<?php echo $mc6397vtdata['thisMonth'] ?></td>
            </tr>
            <tr>
                <td><?php if ($mc6397vtyear!='No') echo "Year "; if ($mc6397vtyear!='No') echo current_time("Y"); ?></td>
                <td align="right"><?php if ($mc6397vtyear!='No') echo $mc6397vtdata['thisYear'] ?></td>
            </tr>
        </table>
	</div>

<?php
	$mc6397vtcontent = ob_get_contents();
	return $mc6397vtcontent;
        echo $after_widget;
    }

 
	// BACK-END WIDGET FORM

    public function form( $instance ) {
        if ( isset( $instance[ 'title' ] ) ) {
            $title = $instance[ 'title' ];
        }
        else {
            $title = __( 'Unique Daily Visitors', 'text_domain' );
        }
        ?>

        <p>
            <label for="<?php echo $this->get_field_name( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
         </p>
    <?php

    }

 
	// SANITIZE WIDGET FORM VALUES

    	public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        return $instance;
    }


} // class MC6397vt_Widget

	// REGISTER THE WIDGET
	add_action( 'widgets_init', 'register_mc6397vt' );
 
	function register_mc6397vt() { 
    	register_widget( 'MC6397vt_Widget' ); 
}

