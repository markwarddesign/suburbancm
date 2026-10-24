import { __ } from '@wordpress/i18n';
import { useBlockProps, RichText, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, SelectControl, Button } from '@wordpress/components';
import { updateItem } from '../_shared/media';

export default function Edit( { attributes, setAttributes } ) {
	const { title = '', cards = [], background = 'bone' } = attributes;
	const blockProps = useBlockProps( { className: `scm-values scm-bg-${ background }` } );

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
				</PanelBody>
			</InspectorControls>
			<section { ...blockProps }>
				<div className="scm-wrap scm-section">
					<RichText tagName="h2" className="scm-d scm-h-l scm-values__title" value={ title } onChange={ ( value ) => setAttributes( { title: value } ) } placeholder={ __( 'Heading…', 'suburbancm' ) } />
					{ cards.map( ( card, i ) => (
						<div key={ i } className="scm-values__row">
							<RichText tagName="h3" className="scm-d" value={ card.cardTitle } onChange={ ( value ) => setAttributes( { cards: updateItem( cards, i, { cardTitle: value } ) } ) } placeholder={ __( 'Value…', 'suburbancm' ) } />
							<RichText tagName="p" value={ card.description } onChange={ ( value ) => setAttributes( { cards: updateItem( cards, i, { description: value } ) } ) } placeholder={ __( 'What it means…', 'suburbancm' ) } />
							<Button size="small" isDestructive icon="trash" label={ __( 'Remove row', 'suburbancm' ) } onClick={ () => setAttributes( { cards: cards.filter( ( _, j ) => j !== i ) } ) } />
						</div>
					) ) }
					<Button variant="secondary" style={ { marginTop: 24 } } onClick={ () => setAttributes( { cards: [ ...cards, { icon: '', cardTitle: '', description: '' } ] } ) }>
						{ __( 'Add row', 'suburbancm' ) }
					</Button>
				</div>
			</section>
		</>
	);
}
