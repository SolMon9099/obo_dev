<?php
/**
 * Tags field.
 *
 * @package HivePress\Fields
 */

namespace HivePress\Fields;

use HivePress\Helpers as hp;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Tags field class.
 *
 * @class Tags
 */
class Tags extends Select {

	/**
	 * Class initializer.
	 *
	 * @param array $meta Field meta.
	 */
	public static function init( $meta = [] ) {
		$meta = hp\merge_arrays(
			[
				'label'      => null,
				'filterable' => false,
			],
			$meta
		);

		parent::init( $meta );
	}

	/**
	 * Class constructor.
	 *
	 * @param array $args Field arguments.
	 */
	public function __construct( $args = [] ) {
		$args = hp\merge_arrays(
			$args,
			[
				'multiple'   => true,

				'attributes' => [
					'data-input' => 'true',
				],
			]
		);

		parent::__construct( $args );
	}

	/**
	 * Validates field value.
	 *
	 * @return bool
	 */
	public function validate() {
		if ( Field::validate() && ! is_null( $this->value ) ) {
			foreach ( $this->value as $value ) {
				if ( is_string( $value ) && ! preg_match( '/^[\w\s]+$/u', $value ) ) {
					$this->add_errors( sprintf( hivepress()->translator->get_string( 'field_contains_invalid_value' ), $this->get_label( true ) ) );

					break;
				}
			}

			if ( $this->max_values && count( (array) $this->value ) > $this->max_values ) {
				$this->add_errors( sprintf( hivepress()->translator->get_string( 'field_contains_too_many_values' ), $this->get_label( true ) ) );
			}
		}

		return empty( $this->errors );
	}
}
