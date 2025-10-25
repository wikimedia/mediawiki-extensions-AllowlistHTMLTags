<?php

namespace MediaWiki\Extension\AllowlistHTMLTags;

use MediaWiki\Extension\AllowlistHTMLTags\Parser\Table;
use MediaWiki\MediaWikiServices;
use Parser;

class Hooks {

	///
	/// Hook implementation
	///

	/**
	 * Initialize parser hooks for each tag in $wgAllowlistHTMLTags.
	 *
	 * @param Parser $parser The MediaWiki parser being initialized
	 *
	 * @return bool
	 */
	public static function onParserFirstCallInit( Parser $parser ): bool {
		$config = MediaWikiServices::getInstance()->getMainConfig();
		$tags = $config->get( 'AllowlistHTMLTags' );

		$table = Table::getTagsAndMethods();

		foreach ( $tags as $tag ) {
			if ( array_key_exists( $tag, $table ) ) {
				$parser->setHook( $tag, $table[$tag] );
			} else {
				wfWarn( "Unrecognized tag '$tag' configured in AllowlistHTMLTags" );
			}
		}

		return true;
	}
}
