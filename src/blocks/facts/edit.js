import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls, RichText } from '@wordpress/block-editor';
import { PanelBody, SelectControl, Button } from '@wordpress/components';

const Edit = ( { attributes, setAttributes } ) => {
	const { items = [], background = 'ink' } = attributes;
	const blockProps = useBlockProps( { className: `scm-facts scm-bg-${ background }` } );

	const update = ( index, key, value ) =>
		setAttributes( { items: items.map( ( item, i ) => ( i === index ? { ...item, [ key ]: value } : item ) ) } );

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Style', 'suburbancm' ) }>
					<SelectControl
						label={ __( 'Background', 'suburbancm' ) }
						value={ background }
						options={ [
							{ label: __( 'Charcoal with gold numbers', 'suburbancm' ), value: 'ink' },
							{ label: __( 'Gold with charcoal numbers', 'suburbancm' ), value: 'gold' },
						] }
						onChange={ ( value ) => setAttributes( { background: value } ) }
					/>
				</PanelBody>
			</InspectorControls>
			<section { ...blockProps }>
				<div className="scm-wrap scm-facts__grid">
					{ items.map( ( item, index ) => (
						<div key={ index } className="scm-fact">
							<RichText
								tagName="div"
								className="scm-d scm-fact__value"
								value={ item.value }
								onChange={ ( value ) => update( index, 'value', value ) }
								placeholder={ __( 'Number', 'suburbancm' ) }
								allowedFormats={ [] }
							/>
							<RichText
								tagName="div"
								className="scm-fact__label"
								value={ item.label }
								onChange={ ( value ) => update( index, 'label', value ) }
								placeholder={ __( 'What it means', 'suburbancm' ) }
								allowedFormats={ [] }
							/>
							<Button
								size="small"
								isDestructive
								icon="trash"
								label={ __( 'Remove fact', 'suburbancm' ) }
								onClick={ () => setAttributes( { items: items.filter( ( _, i ) => i !== index ) } ) }
							/>
						</div>
					) ) }
				</div>
				<div className="scm-wrap">
					<Button variant="secondary" onClick={ () => setAttributes( { items: [ ...items, { value: '', label: '' } ] } ) }>
						{ __( 'Add fact', 'suburbancm' ) }
					</Button>
				</div>
			</section>
		</>
	);
};

export default Edit;
