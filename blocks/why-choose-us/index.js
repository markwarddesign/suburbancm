import { registerBlockType } from '@wordpress/blocks';
import './style.css'; 

import Edit from './edit'; // Import the Edit component
import metadata from './block.json'; // Import metadata

registerBlockType( metadata.name, {
    /**
     * @see ./edit.js
     */
    edit: Edit, // Use the imported Edit component

    /**
     * This is a dynamic block, saving is handled by PHP.
     */
    save: () => null,
} );
