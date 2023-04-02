<?php
/*
Plugin Name: Housing Calculator
Plugin URI: https://github.com/Matthewpco/WP-Plugin-Housing-Calculator
Description: A plugin that calculates the maximum amount you should spend on housing per month based on 30% of your gross monthly income.
Version: 1.1.0
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

function housing_calculator_form() {
    if (isset($_POST['income_type']) && isset($_POST['income_amount']) && isset($_POST['income_percentage'])) {
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
        echo '<p style="padding: 2% 0 0 2%;">Based on ' . ($_POST['income_percentage']) . '% of your monthly income, your maximum monthly housing expense should be: $' . number_format($max_housing, 2) . '</p>';
    }
    ?>
    <form method="post" style="padding: 2% 0 0 2%;">
        <label for="income_type">Enter your income type:</label>
        <select name="income_type" id="income_type">
            <option value="hourly">Hourly</option>
            <option value="annual">Annual</option>
            <option value="monthly">Monthly</option>
        </select><br><br>
        <label for="income_amount">Enter your income amount:</label>
        <input type="text" name="income_amount" id="income_amount"><br><br>
        <label for="income_percentage">Enter the percentage of income to use for calculation:</label>
        <input type="text" name="income_percentage" id="income_percentage" value="30"><br><br>
        <input type="submit" value="Calculate">
    </form>
    <?php
}

add_shortcode('housing_calculator', 'housing_calculator_shortcode');

function housing_calculator_shortcode() {
    ob_start();
    housing_calculator_form();
    return ob_get_clean();
}