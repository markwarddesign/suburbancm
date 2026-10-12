import Edit from './edit';
import { registerBlockType } from '@wordpress/blocks';
import metadata from './block.json';
import './editor.scss'; // Backend styles

registerBlockType(metadata.name, {
    edit: Edit,
    save() {
        return null; // dynamic block or handled in PHP
    },
});
