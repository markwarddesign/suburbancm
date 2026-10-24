/**
 * Registers the suburbancm/form-panel block.
 */
import { registerBlockType } from '@wordpress/blocks';
import { InnerBlocks } from '@wordpress/block-editor';

import json from './block.json';
import Edit from './edit';

registerBlockType( json.name, {
	edit: Edit,
	// The form itself is saved as inner blocks; view.php draws everything around it.
	save: () => <InnerBlocks.Content />,
} );
