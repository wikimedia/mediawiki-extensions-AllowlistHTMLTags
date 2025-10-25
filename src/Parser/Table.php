<?php

namespace MediaWiki\Extension\AllowlistHTMLTags\Parser;

class Table {

	/**
	 * @return callable[]
	 */
	public static function getTagsAndMethods(): array {
		return [
			// <detail> and <summary>
			"details" => [
				Details::class,
				"renderDetails"
			],
			"summary" => [
				Details::class,
				"renderSummary"
			],
		];
	}

}
