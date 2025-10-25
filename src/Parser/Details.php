<?php

namespace MediaWiki\Extension\AllowlistHTMLTags\Parser;

use MediaWiki\Parser\PPFrame;
use MediaWiki\Parser\Sanitizer;
use Parser;

class Details {

	/**
	 * Render the <details> tag safely.
	 */
	public static function renderDetails( string $input, array $args, Parser $parser, bool|PPFrame $frame ): string {
		$attrs = self::buildAttributes(
			$args,
			[
				'class',
				'id',
				'open',
			]
		);

		return '<details' . $attrs . '>' . $parser->recursiveTagParse( $input, $frame ) . '</details>';
	}

	/**
	 * Render the <summary> tag safely.
	 */
	public static function renderSummary( string $input, array $args, Parser $parser, bool|PPFrame $frame ): string {
		$attrs = self::buildAttributes( $args, [ 'class' ] );

		return '<summary' . $attrs . '>' . $parser->recursiveTagParse( $input, $frame ) . '</summary>';
	}

	///
	/// HTML Attributes
	///

	private const BOOLEAN_ATTRIBUTES = [
		"open",
	];

	private static function isBooleanAttribute( string $attribute ): bool {
		return in_array( $attribute, self::BOOLEAN_ATTRIBUTES );
	}

	/**
	 * Helper to safely assemble HTML attributes.
	 */
	private static function buildAttributes( array $args, array $allowed ): string {
		$allowedAttributes = array_fill_keys( $allowed, true );
		$validAttributes = Sanitizer::validateAttributes( $args, $allowedAttributes );

		$attributes = '';
		foreach ( $validAttributes as $attribute => $value ) {
			$attributes .= " " . $attribute;

			if ( !self::isBooleanAttribute( $attribute ) ) {
				$attributes .= '="' . Sanitizer::encodeAttribute( $value ) . '"';
			}
		}

		return $attributes;
	}
}
