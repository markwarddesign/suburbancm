import { __ } from '@wordpress/i18n';
import { useBlockProps, RichText, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, SelectControl, TextControl, Button } from '@wordpress/components';
import { ImageControl, updateItem } from '../_shared/media';

export default function Edit( { attributes, setAttributes } ) {
	const { title, image, imageAlt, lead, text, chipsLabel, chips = [], chipLinks = [], background } = attributes;
	const blockProps = useBlockProps( { className: `scm-split scm-bg-${ background }` } );

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Style', 'suburbancm' ) }>
					<SelectControl
						label={ __( 'Background', 'suburbancm' ) }
						value={ background }
						options={ [
							{ label: __( 'Light (bone)', 'suburbancm' ), value: 'bone' },
							{ label: __( 'Charcoal', 'suburbancm' ), value: 'ink' },
						] }
						onChange={ ( value ) => setAttributes( { background: value } ) }
					/>
					<ImageControl
						label={ __( 'Image under the heading (optional, e.g. a logo)', 'suburbancm' ) }
						url={ image }
						alt={ imageAlt }
						onChange={ ( { url, alt } ) => setAttributes( { image: url, imageAlt: alt } ) }
					/>
				</PanelBody>
				<PanelBody title={ __( 'Tag chips', 'suburbancm' ) } initialOpen={ false }>
					<TextControl label={ __( 'Label above the chips', 'suburbancm' ) } value={ chipsLabel } onChange={ ( value ) => setAttributes( { chipsLabel: value } ) } />
					{ chips.map( ( chip, i ) => (
						<div key={ i } style={ { borderTop: '1px solid #ddd', paddingTop: 8, marginTop: 8 } }>
							<TextControl label={ __( 'Chip text', 'suburbancm' ) } value={ chip } onChange={ ( value ) => setAttributes( { chips: updateItem( chips, i, value ) } ) } />
							<TextControl
								label={ __( 'Link (optional — linked chips are filled)', 'suburbancm' ) }
								value={ chipLinks[ i ] || '' }
								onChange={ ( value ) => {
									const next = [ ...chipLinks ];
									next[ i ] = value;
									setAttributes( { chipLinks: next } );
								} }
							/>
							<Button
								variant="link"
								isDestructive
								onClick={ () =>
									setAttributes( {
										chips: chips.filter( ( _, j ) => j !== i ),
										chipLinks: chipLinks.filter( ( _, j ) => j !== i ),
									} )
								}
							>
								{ __( 'Remove chip', 'suburbancm' ) }
							</Button>
						</div>
					) ) }
					<Button variant="secondary" onClick={ () => setAttributes( { chips: [ ...chips, '' ] } ) }>
						{ __( 'Add chip', 'suburbancm' ) }
					</Button>
				</PanelBody>
			</InspectorControls>

			<section { ...blockProps }>
				<div className="scm-wrap scm-section scm-split__inner">
					<div className="scm-split__head">
						<RichText tagName="h2" className="scm-d scm-h-l" value={ title } onChange={ ( value ) => setAttributes( { title: value } ) } placeholder={ __( 'Heading…', 'suburbancm' ) } />
						{ image && <img className="scm-split__image" src={ image } alt={ imageAlt } /> }
					</div>
					<div className="scm-split__body">
						<RichText tagName="p" className="scm-split__lead" value={ lead } onChange={ ( value ) => setAttributes( { lead: value } ) } placeholder={ __( 'Optional bold lead line…', 'suburbancm' ) } />
						<RichText
							tagName="p"
							value={ text }
							onChange={ ( value ) => setAttributes( { text: value } ) }
							placeholder={ __( 'Text… (Shift+Enter twice starts a new paragraph)', 'suburbancm' ) }
						/>
						{ chips.length > 0 && (
							<div className="scm-split__chips">
								{ chipsLabel && <p className="scm-eyebrow">{ chipsLabel }</p> }
								<ul>
									{ chips.map( ( chip, i ) => (
										<li key={ i }>
											<span className={ chipLinks[ i ] ? 'is-linked' : undefined }>{ chip }</span>
										</li>
									) ) }
								</ul>
							</div>
						) }
					</div>
				</div>
			</section>
		</>
	);
}
