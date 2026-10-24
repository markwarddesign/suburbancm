/**
 * Registers the suburbancm/facts block.
 */
import { registerBlockType } from '@wordpress/blocks';

import json from './block.json';
import Edit from './edit';

registerBlockType( json.name, {
	edit: Edit,
	// Dynamic block: markup is rendered by view.php.
	save: () => null,
} );
