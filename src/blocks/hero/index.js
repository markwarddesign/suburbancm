import { registerBlockType } from '@wordpress/blocks';
import Edit from './edit';
import metadata from './block.json'; // Import metadata

// Import styles
import './editor.scss'; // Backend styles

registerBlockType( metadata.name, { // Use name from block.json
    /**
     * @see ./edit.js
     */
    edit: Edit,
    /**
         * This is a dynamic block.
         */
    save: () => null,
    
} );

// Optional: Create empty SCSS files if you reference them, even if empty initially
// src/style.scss
// src/editor.scss