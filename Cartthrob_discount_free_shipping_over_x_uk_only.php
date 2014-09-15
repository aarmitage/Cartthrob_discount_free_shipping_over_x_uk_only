<?php if ( ! defined('CARTTHROB_PATH')) Cartthrob_core::core_error('No direct script access allowed');

class Cartthrob_discount_free_shipping_over_x_uk_only extends Cartthrob_discount
{
	public $title = 'free_shipping_over_x_uk_only_title';
	public $settings = array(
		array(
			'name' => 'amount_off',
			'short_name' => 'amount_off',
			'note' => 'amount_off_note',
			'type' => 'text'
		),
		array(
			'name' => 'if_order_over',
			'short_name' => 'order_over',
			'note' => 'enter_required_minimum',
			'type' => 'text'
		)
	);
	
	public function get_discount()
	{
		$shipping_postcode_exceptions = array('AB30', 'AB31', 'AB32', 'AB33', 'AB34', 'AB35', 'AB36', 'AB37', 'AB38', 'AB44', 'AB45', 'AB46', 'AB47', 'AB48', 'AB49', 'AB50', 'AB51', 'AB52', 'AB53', 'AB54', 'AB55', 'AB56', 'FK17', 'FK18', 'FK19', 'FK20', 'FK21', 'G83', 'IV1', 'IV2', 'IV3', 'IV4', 'IV5', 'IV6', 'IV7', 'IV8', 'IV9', 'IV10', 'IV11', 'IV12', 'IV13', 'IV14', 'IV15', 'IV16', 'IV17', 'IV18', 'IV19', 'IV20', 'IV21', 'IV22', 'IV23', 'IV24', 'IV25', 'IV26', 'IV27', 'IV28', 'IV30', 'IV31', 'IV32', 'IV36', 'IV40', 'IV41', 'IV42', 'IV43', 'IV44', 'IV45', 'IV46', 'IV47', 'IV48', 'IV49', 'IV51', 'IV52', 'IV53', 'IV54', 'IV55', 'IV56', 'IV63', 'KA27', 'KA28', 'KW1', 'KW2', 'KW3', 'KW4', 'KW5', 'KW6', 'KW7', 'KW8', 'KW8', 'KW9', 'KW10', 'KW11', 'KW12', 'KW13', 'KW14', 'KW15', 'KW16', 'KW17', 'PA20', 'PA21', 'PA22', 'PA23', 'PA24', 'PA25', 'PA26', 'PA27', 'PA28', 'PA29', 'PA30', 'PA31', 'PA32', 'PA33', 'PA34', 'PA35', 'PA36', 'PA37', 'PA38', 'PA39', 'PA40', 'PA41', 'PA42', 'PA43', 'PA44', 'PA45', 'PA46', 'PA47', 'PA48', 'PA49', 'PA60', 'PA61', 'PA62', 'PA63', 'PA64', 'PA65', 'PA66', 'PA67', 'PA68', 'PA69', 'PA70', 'PA71', 'PA72', 'PA73', 'PA74', 'PA75', 'PA76', 'PA77', 'PA78', 'PH18', 'PH19', 'PH20', 'PH21', 'PH22', 'PH23', 'PH24', 'PH25', 'PH26', 'PH30', 'PH31', 'PH32', 'PH33', 'PH34', 'PH35', 'PH36', 'PH37', 'PH38', 'PH39', 'PH40', 'PH41', 'PH43', 'PH44', 'PH49', 'PH50', 'PH51', 'HS1', 'HS2', 'HS3', 'HS4', 'HS5', 'HS6', 'HS7', 'HS8', 'BT1', 'BT2', 'BT3', 'BT4', 'BT5', 'BT6', 'BT7', 'BT8', 'BT9', 'BT10', 'BT11', 'BT12', 'BT13', 'BT14', 'BT15', 'BT16', 'BT17', 'BT18', 'BT19', 'BT20', 'BT21', 'BT22', 'BT23', 'BT24', 'BT25', 'BT26', 'BT27', 'BT28', 'BT29', 'BT30', 'BT31', 'BT32', 'BT33', 'BT34', 'BT35', 'BT36', 'BT37', 'BT38', 'BT39', 'BT40', 'BT41', 'BT42', 'BT43', 'BT44', 'BT45', 'BT46', 'BT47', 'BT48', 'BT49', 'BT50', 'BT51', 'BT52', 'BT53', 'BT54', 'BT55', 'BT56', 'BT57', 'BT58', 'BT59', 'BT60', 'BT61', 'BT62', 'BT63', 'BT64', 'BT65', 'BT66', 'BT67', 'BT68', 'BT69', 'BT70', 'BT71', 'BT72', 'BT73', 'BT74', 'BT75', 'BT76', 'BT77', 'BT78', 'BT79', 'BT80', 'BT81', 'BT82', 'BT83', 'BT84', 'BT85', 'BT86', 'BT87', 'BT88', 'BT89', 'BT90', 'BT91', 'BT92', 'BT93', 'BT94', 'BT95', 'BT96', 'BT97', 'BT98', 'BT99', 'ZE1', 'ZE2', 'ZE3', 'JE1', 'JE2', 'JE3', 'JE4', 'JE5', 'GY1', 'GY2', 'GY3', 'GY4', 'GY5', 'GY6', 'GY7', 'GY8', 'GY9', 'GY10', 'IM1', 'IM2', 'IM3', 'IM4', 'IM5', 'IM6', 'IM7', 'IM8', 'IM9', 'TR21', 'TR22', 'TR23', 'TR24', 'TR25');
		
		//uk post code regex
		$post_code_pattern = '/^(([A-PR-UW-Z]{1}[A-IK-Y]?)([0-9]?[A-HJKS-UW]?[ABEHMNPRVWXY]?|[0-9]?[0-9]?))\s?([0-9]{1}[ABD-HJLNP-UW-Z]{2})$/';
		if(preg_match($post_code_pattern, strtoupper($this->core->cart->customer_info("shipping_zip")), $matches))
			{
				//get first part of post code incl numbers, eg. LA1, DN55, WC1E etc.
				$pc_prefix = $matches[1];
			}		
	
		if ($this->core->cart->subtotal() >= $this->core->sanitize_number($this->plugin_settings('order_over')))
		{
			if($this->core->cart->shipping_info("shipping_option") != 'Standard Delivery' && $this->core->cart->customer_info("shipping_country_code") == '')
			{
				//shipping is not standard delivery and country code is empty, so no discount to apply
				$this->core->cart->set_discounted_shipping();
				//Shipping rates are hardcoded for standard delivery
/*
				switch ($this->core->cart->shipping_info("shipping_option"))
				{
				    case 'Next Day':
				        $this->core->cart->set_discounted_shipping();
				        break;
				    case 'Next Day 10am':
				        $this->core->cart->set_discounted_shipping();
				        break;
				    case 'Next Day 12pm':
				        $this->core->cart->set_discounted_shipping();
				        break;
					case 'Saturday':
				        $this->core->cart->set_discounted_shipping();
				        break;
				}
*/
				//echo $this->core->cart->shipping_info("shipping_option");
				//echo $this->core->cart->shipping();
				
			}
			elseif(isset($pc_prefix) && !in_array($pc_prefix, $shipping_postcode_exceptions) && $this->core->cart->shipping_info("shipping_option") === 'Standard Delivery' && $this->core->cart->customer_info("shipping_country_code") == '')
			{
				// a postcode was entered, but its not in our list of exceptions, so set shipping discount to 0
				$this->core->cart->set_discounted_shipping(0);
			}
			elseif(isset($pc_prefix) && in_array($pc_prefix, $shipping_postcode_exceptions) && $this->core->cart->customer_info("shipping_country_code") == '')
			{
				// a postcode was entered, and it is in our list of exceptions and country code is empty, so set discounted shipping to hard coded rates based on the shippable weight
				if($this->core->cart->shippable_weight() <= 0.06)
				{
					$this->core->cart->set_discounted_shipping(1);
				}
				if($this->core->cart->shippable_weight() <= 1.5)
				{
					$this->core->cart->set_discounted_shipping(4.5);
				}
				elseif($this->core->cart->shippable_weight() <= 2500)
				{
					$this->core->cart->set_discounted_shipping(9);
				}
			}
			else {
				return;
			}
		}
		
		return 0; 
	}
	
}