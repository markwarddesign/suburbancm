import { __ } from '@wordpress/i18n';
import { useBlockProps, RichText, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, TextControl, SelectControl, Button } from '@wordpress/components';
import { updateItem } from '../_shared/media';

export default function Edit( { attributes, setAttributes } ) {
	const { title, description, buttonText, buttonLink, items = [], background = 'ink' } = attributes;
	const blockProps = useBlockProps( { className: `scm-features scm-bg-${ background }` } );

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Style and link', 'suburbancm' ) }>
					<SelectControl
						label={ __( 'Background', 'suburbancm' ) }
						value={ background }
						options={ [
							{ label: __( 'Charcoal', 'suburbancm' ), value: 'ink' },
							{ label: __( 'Light (bone)', 'suburbancm' ), value: 'bone' },
						] }
						onChange={ ( value ) => setAttributes( { background: value } ) }
					/>
					<TextControl label={ __( 'Link URL', 'suburbancm' ) } value={ buttonLink } onChange={ ( value ) => setAttributes( { buttonLink: value } ) } />
				</PanelBody>
			</InspectorControls>
			<section { ...blockProps }>
				<div className="scm-wrap scm-section">
					<header className="scm-features__head">
						<RichText tagName="h2" className="scm-d scm-h-l" value={ title } onChange={ ( value ) => setAttributes( { title: value } ) } placeholder={ __( 'Heading…', 'suburbancm' ) } />
						<div className="scm-features__aside">
							<RichText tagName="p" className="scm-lede" value={ description } onChange={ ( value ) => setAttributes( { description: value } ) } placeholder={ __( 'Optional intro…', 'suburbancm' ) } />
							<RichText tagName="span" className="scm-link" value={ buttonText } onChange={ ( value ) => setAttributes( { buttonText: value } ) } placeholder={ __( 'Optional link text →', 'suburbancm' ) } allowedFormats={ [] } />
						</div>
					</header>
					<div className="scm-features__grid">
						{ items.map( ( item, i ) => (
							<div key={ i } className="scm-feature">
								<RichText tagName="h3" className="scm-d" value={ item.title } onChange={ ( value ) => setAttributes( { items: updateItem( items, i, { title: value } ) } ) } placeholder={ __( 'Point title…', 'suburbancm' ) } />
								<RichText tagName="p" value={ item.description } onChange={ ( value ) => setAttributes( { items: updateItem( items, i, { description: value } ) } ) } placeholder={ __( 'Short description…', 'suburbancm' ) } />
								<Button size="small" isDestructive icon="trash" label={ __( 'Remove point', 'suburbancm' ) } onClick={ () => setAttributes( { items: items.filter( ( _, j ) => j !== i ) } ) } />
							</div>
						) ) }
					</div>
					<Button variant="secondary" style={ { marginTop: 24 } } onClick={ () => setAttributes( { items: [ ...items, { title: '', description: '' } ] } ) }>
						{ __( 'Add point', 'suburbancm' ) }
					</Button>
				</div>
			</section>
		</>
	);
}
