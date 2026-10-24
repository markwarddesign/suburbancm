/**
 * Shared editor controls for the redesigned blocks.
 */
import { __ } from '@wordpress/i18n';
import { MediaUpload, MediaUploadCheck } from '@wordpress/block-editor';
import { Button, TextControl } from '@wordpress/components';

/**
 * Sidebar image picker with alt text. Calls onChange({ id, url, alt }).
 *
 * @param {Object}   props
 * @param {string}   props.label    Panel label.
 * @param {number}   props.id       Attachment ID.
 * @param {string}   props.url      Image URL.
 * @param {string}   props.alt      Alt text.
 * @param {Function} props.onChange Receives { id, url, alt }.
 */
export function ImageControl( { label, id, url, alt, onChange } ) {
	return (
		<div className="scm-image-control" style={ { marginBottom: 16 } }>
			<p style={ { margin: '0 0 8px', fontWeight: 600 } }>{ label }</p>
			{ url && <img src={ url } alt="" style={ { display: 'block', maxWidth: '100%', marginBottom: 8 } } /> }
			<MediaUploadCheck>
				<MediaUpload
					onSelect={ ( media ) => onChange( { id: media.id, url: media.url, alt: media.alt || alt || '' } ) }
					allowedTypes={ [ 'image' ] }
					value={ id }
					render={ ( { open } ) => (
						<Button variant={ url ? 'secondary' : 'primary' } onClick={ open }>
							{ url ? __( 'Replace image', 'suburbancm' ) : __( 'Choose image', 'suburbancm' ) }
						</Button>
					) }
				/>
			</MediaUploadCheck>
			{ url && (
				<>
					<Button variant="link" isDestructive onClick={ () => onChange( { id: undefined, url: '', alt: '' } ) }>
						{ __( 'Remove', 'suburbancm' ) }
					</Button>
					<TextControl
						label={ __( 'Alt text', 'suburbancm' ) }
						value={ alt }
						onChange={ ( value ) => onChange( { id, url, alt: value } ) }
					/>
				</>
			) }
		</div>
	);
}

/**
 * Replace one item in an array attribute without mutating it.
 *
 * @param {Array}  list  Current array.
 * @param {number} index Item index.
 * @param {Object} patch Fields to merge (or a new value for string items).
 * @return {Array} New array.
 */
export const updateItem = ( list, index, patch ) =>
	list.map( ( item, i ) => {
		if ( i !== index ) {
			return item;
		}
		return typeof item === 'object' && item !== null ? { ...item, ...patch } : patch;
	} );
