<?php

namespace StatenTimber\Format;


class Phone {

	private $phone = null;
	private $formatted = null;

	public function __construct( $phone ) {

		$this->phone = $phone;

	}

	public function get_formatted() {
		return $this->format();
	}

	public function get_raw() {
		return $this->phone;
	}

	private function format() {

		if ( $this->formatted ) {
			return $this->formatted;
		}

		$phone  = $this->phone;
		$format = "/(?:(?:\\+?\\s*(?:[.-]\\s*)?)?(?:\\(\\s*([2-9]1[02-9]|[2-9][02-8]1|[2-9][02-8][02-9])\\s*\\)|([2-9]1[02-9]|[2-9][02-8]1|[2-9][02-8][02-9]))\\s*(?:[.-]\\s*)?)?([2-9]1[02-9]|[2-9][02-9]1|[2-9][02-9]{2})\\s*(?:[.-]\\s*)?([0-9]{4})(?:\\s*(?:#|x\\.?|ext\\.?|extension)\\s*(\\d+))?$/";

		$alt_format = '/^(\+\s*)?((0{0,2}1{1,3}[^\d]+)?\(?\s*([2-9][0-9]{2})\s*[^\d]?\s*([2-9][0-9]{2})\s*[^\d]?\s*([\d]{4})){1}(\s*([[:alpha:]#][^\d]*\d.*))?$/';
		$phone      = trim( $phone );
		$phone      = preg_replace( '/\s+(#|x|ext(ension)?)\.?:?\s*(\d+)/', ' ext \3', $phone );
		if ( preg_match( $alt_format, $phone, $matches ) ) {
			return '(' . $matches[4] . ') ' . $matches[5] . '-' . $matches[6] . ( ! empty( $matches[8] ) ? ' ' . $matches[8] : '' );
		} elseif ( preg_match( $format, $phone, $matches ) ) {
			$phone = preg_replace( $format, "($2) $3-$4", $phone );
			$phone = ltrim( $phone, '-' );
			if ( false !== strpos( trim( $phone ), '()', 0 ) ) {
				$phone = ltrim( trim( $phone ), '()' );
			}

			$this->formatted = preg_replace( '/\\s+/', ' ', trim( $phone ) );

			return $this->formatted;
		}

		return false;


	}
}
