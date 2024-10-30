<?php

	//SHORTCODE START

	add_shortcode('mcvt-visitor-tally', 'mc6397vt_make_shortcode');

	function mc6397vt_make_shortcode($mc6397vtatts)

{    $mc6397vtoptions = shortcode_atts(array('headline' => ''), $mc6397vtatts);


		$mc6397vtdata=mc6397vt_get_visitor_data();
		$mc6397vtyear=get_option('mc6397vt_showyear');
		$mc6397vt_type=get_option('mc6397vt_table_type');
		$mc6397vt_color=get_option('mc6397vt_table_color');
		$mc6397vt_resp=get_option('mc6397vt_table_resp');

		ob_start();
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

		<?php $mc6397vtcontent = ob_get_contents();
		ob_end_clean();
		return $mc6397vtcontent; ?>

<?php

}

