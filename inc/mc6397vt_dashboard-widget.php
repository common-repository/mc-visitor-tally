<?php

	add_action('wp_dashboard_setup', 'mc6397vt_dashboard_widget');
	function mc6397vt_dashboard_widget()
{
    wp_add_dashboard_widget(
        'mc6397vt_dashboard_widget',
        'MC Visitor Tally<br>Unique Visitor Counts by Time Frame' ,
        'mc6397vt_dashboard_widget_display'
    );
}
	function mc6397vt_dashboard_widget_display()

{ ?>
    <?php $mc6397vtdata = mc6397vt_get_visitor_data(); ?>
	<?php $mc6397vtiDate = get_option('mc6397vt_installed'); ?>
	<?php $mc6397vtMonths = get_option('mc6397vt_showmonths'); ?>

	<div class="table-responsive">    
   	<table class="widefat striped">
	<em>Installed on <?php echo "$mc6397vtiDate" ?></em>
            <tr>
                <td> <span class="dashicons dashicons-yes"></span> Today</td>
                <td align="right"><?php echo $mc6397vtdata['today'] ?></td>
            </tr>
            <tr>
                <td> <span class="dashicons dashicons-yes"></span> Yesterday</td>
                <td align="right"><?php echo $mc6397vtdata['yesterday'] ?></td>
            </tr>
            <tr>
                <td> <span class="dashicons dashicons-yes"></span> The Past 7 Days</td>
                <td align="right"><?php echo $mc6397vtdata['pastWeek']; ?></td>
            </tr>
            <tr>
                <td> <span class="dashicons dashicons-yes"></span> The Month of <?php echo current_time( 'F' ) ?></td>
                <td align="right"><?php echo $mc6397vtdata ['thisMonth'] ?></td>
            </tr>
            <tr>
                <td> <span class="dashicons dashicons-calendar-alt"></span> The Year <?php echo current_time("Y"); ?></td>
                <td align="right"><?php echo $mc6397vtdata['thisYear'] ?></td>
            </tr>
    </table>

	<?php if ($mc6397vtMonths != "No") { ?>

   	 <table class="widefat striped">
            <strong>Month-to-Month Comparison </strong><br/><em>(To remove this table, go to this plugin's <a href="options-general.php?page=mcvisitortally">Settings Page</a>.)</em><br/>Note: The month of <?php echo current_time('F') ?> (below) shows the total through today, plus any visitors from the remaining days of last <?php echo current_time('F') ?>.
            <tr>
                <td>January</td>
                <td align="right"><?php echo $mc6397vtdata['January'] ?></td>
            </tr>
            <tr>
                <td>February</td>
                <td align="right"><?php echo $mc6397vtdata['February'] ?></td>
            </tr>
            <tr>            
                <td>March</td>
                <td align="right"><?php echo $mc6397vtdata['March'] ?></td>
            </tr>
           <tr>
                <td>April</td>
                <td align="right"><?php echo $mc6397vtdata['April'] ?></td>
            </tr>
            <tr>
                <td>May</td>
                <td align="right"><?php echo $mc6397vtdata['May'] ?></td>
            </tr>
            <tr>            
                <td>June</td>
                <td align="right"><?php echo $mc6397vtdata['June'] ?></td>
            </tr>
            <tr>
                <td>July</td>
                <td align="right"><?php echo $mc6397vtdata['July'] ?></td>
            </tr>
            <tr>
                <td>August</td>
                <td align="right"><?php echo $mc6397vtdata['August'] ?></td>
            </tr>
            <tr>            
                <td>September</td>
                <td align="right"><?php echo $mc6397vtdata['September'] ?></td>
            </tr>
           <tr>
                <td>October</td>
                <td align="right"><?php echo $mc6397vtdata['October'] ?></td>
            </tr>
            <tr>
                <td>November</td>
                <td align="right"><?php echo $mc6397vtdata['November'] ?></td>
            </tr>
            <tr>            
                <td>December</td>
                <td align="right"><?php echo $mc6397vtdata['December'] ?></td>
            </tr>
            <tr>
                <td>Total for the Past 12 Months</td>
                <td align="right"><?php echo $mc6397vtdata['Year'] ?></td>
            </tr>

            <?php } else { echo "<em>To enable the Month-to-Month Comparison table, go to this plugin's <a href='options-general.php?page=mcvisitortally'> Settings Page</a></em>"; } ?>

    </table>

    </div>
    <?php
}
