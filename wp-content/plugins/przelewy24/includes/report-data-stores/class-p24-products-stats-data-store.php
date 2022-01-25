<?php
/**
 * Products data store.
 *
 * @package Przelewy24
 */

use Automattic\WooCommerce\Admin\API\Reports\Products\Stats\DataStore;
use Automattic\WooCommerce\Admin\API\Reports\Orders\DataStore as OrdersDataStore;

/**
 * Class P24_Products_Stats_Data_Store.
 */
class P24_Products_Stats_Data_Store extends DataStore {
	/**
	 * Updates the database query with parameters used for Products Stats report: categories and order status.
	 *
	 * @param array $query_args       Query arguments supplied by the user.
	 */
	protected function update_sql_query_params( $query_args ) {
		parent::update_sql_query_params( $query_args );
		$metadata_join = P24_Multi_Currency::get_currency_filter_for_reports( OrdersDataStore::get_db_table_name() );
		$this->interval_query->add_sql_clause( 'join', $metadata_join );
		$this->total_query->add_sql_clause( 'join', $metadata_join );
	}

	/**
	 * Get cache key.
	 *
	 * @param array $params Parameters.
	 *
	 * @return string
	 */
	protected function get_cache_key( $params ) {
		return parent::get_cache_key( $params ) . '_' . P24_Multi_Currency::get_admin_reports_currency();
	}
}
