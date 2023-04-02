<?php
/*
Plugin Name: Housing Calculator
Plugin URI: https://github.com/Matthewpco/WP-Plugin-Housing-Calculator
Description: A plugin that calculates the maximum amount you should spend on housing per month based on 30% of your gross monthly income.
Version: 1.6.0
Author: Gary Matthew Payne
Author URI: https://wpwebdevelopment.com/
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

function housing_calculator_menu() {
    add_menu_page('Housing Calculator', 'Housing Calculator', 'manage_options', 'housing-calculator', 'housing_calculator_page');
}

add_action('admin_menu', 'housing_calculator_menu');

function housing_calculator_page() {
    housing_calculator_form();
}

function housing_calculator_form($text_align = 'left') {
    ?>
    <form method="post" style="padding: 2%; text-align: <?php echo $text_align; ?>">
        <label for="income_type">Enter your income type:</label>
        <select name="income_type" id="income_type">
            <option value="hourly">Hourly</option>
            <option value="annual">Annual</option>
            <option value="monthly">Monthly</option>
        </select><br><br>
        <label for="income_amount">Enter your income amount:</label>
        <input type="text" name="income_amount" id="income_amount"><br><br>
        <label for="income_percentage">Select the percentage of income to use for calculation:</label>
        <select name="income_percentage" id="income_percentage">
            <option value="25">25%</option>
            <option value="30" selected>30%</option>
            <option value="35">35%</option>
            <option value="40">40%</option>
        </select><br><br>
        <input type="submit" value="Calculate">
    </form>
    <?php
    if (isset($_POST['income_type']) && isset($_POST['income_amount']) && isset($_POST['income_percentage'])) {
		
		if(is_numeric($_POST['income_amount'])) {
			$income_type = $_POST['income_type'];
			$income_amount = $_POST['income_amount'];
			$income_percentage = $_POST['income_percentage'] / 100;
			if ($income_type == 'hourly') {
				$monthly_income = $income_amount * 40 * 52 / 12;
			} elseif ($income_type == 'annual') {
				$monthly_income = $income_amount / 12;
			} else {
				$monthly_income = $income_amount;
			}
			$max_housing = $monthly_income * $income_percentage;
			echo '<p style="text-align: '.$text_align.';">Based on your income and selected percentage, the maximum amount you should spend on housing per month is: $' . number_format($max_housing, 2) . '</p>';
		} else {
			echo '<p style="color:red; text-align: '.$text_align.';">Please enter a valid income amount.</p>';
		}
    }
}

function housing_calculator_shortcode($atts) {
    ob_start();
    $atts = shortcode_atts(array(
        'text_align' => 'left',
    ), $atts);
    housing_calculator_form($atts['text_align']);
    return ob_get_clean();
}

add_shortcode('housing_calculator', 'housing_calculator_shortcode');