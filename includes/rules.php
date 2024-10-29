<?php

/**
 * Register the backend rules and evaluation
 * 
 * @since 1.0.0
 */

use GeoIp2\Database\Reader;

class Extra_Conditional_Logic_For_Bb_Rules {

	public function init() {

		add_action( 'bb_logic_init', function() {
			BB_Logic_Rules::register( array(
				'extra-conditional-logic-for-bb/paged' => array($this, 'paged_evaluation'),
				'extra-conditional-logic-for-bb/post-format' => array ($this, 'post_format_evaluation'),
				'extra-conditional-logic-for-bb/user-country-code' => array($this, 'user_country_code'),
			) );
		});
	}

	/**
	 * Paged Evaluation
	 *
	 * @param [type] $rule
	 * @return void
	 * @since 1.0.0
	 */
	public function paged_evaluation( $rule ) {
		
		$paged = (get_query_var('paged')) ? get_query_var('paged') : false;

		// Evaluate the rule compared to the current page and return a boolean
		return BB_Logic_Rules::evaluate_rule( array(
			'value' => $paged,
			'operator' => $rule->operator,
			'compare' => $rule->value,
		) );
	}

	/**
	 * Post Format Evaluation
	 *
	 * @param [type] $rule
	 * @return void
	 * @since 1.0.0
	 */
	public function post_format_evaluation( $rule ) {

		$post_format = "standard"; // Default if no post_format set

		if( get_post_format() ) {
			$post_format = strval( get_post_format() );
		}
		
		// Evaluate the post format compared to the current post
		return BB_Logic_Rules::evaluate_rule( array(
			'value' => $post_format,
			'operator' => $rule->operator,
			'compare' => $rule->format,
		) );

	}

	/**
	 * Get user IP
	 * 
	 * @param void
	 * @return String
	 * @since 1.0.0
	 */

	public function get_user_ip() {
		// Cloudflare
		if ( isset($_SERVER["HTTP_CF_CONNECTING_IP"] ) ) {
			$_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
			$_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
		}
		$client  = @$_SERVER['HTTP_CLIENT_IP'];
		$forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
		$remote  = $_SERVER['REMOTE_ADDR'];

		if(filter_var($client, FILTER_VALIDATE_IP)) { $ip = $client; }
		elseif(filter_var($forward, FILTER_VALIDATE_IP)) { $ip = $forward; }
		else { $ip = $remote; }

		return $ip;
	}
	
	/**
	 * User Country Code
	 * 
	 * @param [type] $rule
	 * @return void
	 * @since 1.0.0
	 */
	
	public function user_country_code( $rule ) {

		// Get local IP address
    $ip = $this->get_user_ip();

		// lookups.
		$reader = new Reader(EXTRA_CONDITIONAL_LOGIC_FOR_BB_DIR.'vendor/geoip2/geoip2/GeoLite2-Country.mmdb');
		$record = $reader->country($ip);
		$countryCode = $record->country->isoCode;
    
    return BB_Logic_Rules::evaluate_rule( array(
        'value'     	=> $countryCode,
        'operator'    => $rule->operator,
        'compare'     => strtoupper( $rule->compare ),
    ) );
	}
}
