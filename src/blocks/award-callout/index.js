/**
 * Registers the suburbancm/award-callout block.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-registration/
 */
import { registerBlockType } from '@wordpress/blocks';

import json from './block.json';
import Edit from './edit';

import './editor.scss';

const { name } = json;

registerBlockType(name, {
	edit: Edit,
	// Dynamic block: markup is rendered by view.php.
	save: () => null,
});
