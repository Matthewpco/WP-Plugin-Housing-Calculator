<?php
/*
Plugin Name: Housing Calculator
Plugin URI: https://github.com/Matthewpco/WP-Plugin-Housing-Calculator
Description: A plugin that calculates the maximum amount you should spend on housing per month based on 30% of your gross monthly income.
Version: 1.0.0
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
    if (isset($_POST['hourly_rate'])) {
        $hourly_rate = $_POST['hourly_rate'];
        $monthly_income = $hourly_rate * 40 * 52 / 12;
        $max_housing = $monthly_income * 0.3;
        echo '<p style="padding: 2% 0 0 2%;">Based on 30% of your monthly income, your maximum monthly housing expense should be: $' . number_format($max_housing, 2) . '</p>';
    }
    ?>
    <form method="post" style="padding: 2% 0 0 2%;">
        <label for="hourly_rate">Enter your hourly rate:</label>
        <input type="text" name="hourly_rate" id="hourly_rate">
        <input type="submit" value="Calculate">
    </form>
    <?php
}