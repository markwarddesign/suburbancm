/**
 * Registers the suburbancm/projectaire block, with a ready-made "Detailed" variation.
 */
import { __ } from '@wordpress/i18n';
import { registerBlockType } from '@wordpress/blocks';

import json from './block.json';
import Edit from './edit';

registerBlockType( json.name, {
	edit: Edit,
	// Dynamic block: markup is rendered by view.php.
	save: () => null,
	variations: [
		{
			name: 'detailed',
			title: __( 'ProjectAire — detailed', 'suburbancm' ),
			description: __( "During construction and the Owner's Manual at handoff, each with a screenshot.", 'suburbancm' ),
			attributes: {
				layout: 'detailed',
				title: 'Every project runs on ProjectAire.',
				titleHighlight: '',
				text: "ProjectAire grew out of our own job sites. It's where our team, your team and the architect work from one record — and it's how you see your project the day things happen, not at the next meeting.",
				secondaryText: 'Client login ↗',
			},
			isActive: ( attrs ) => attrs.layout === 'detailed',
			scope: [ 'inserter', 'transform' ],
		},
	],
} );
