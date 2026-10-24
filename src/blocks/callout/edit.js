import { __ } from '@wordpress/i18n';
import { RichText, useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, TextControl, Button } from '@wordpress/components';
import { updateItem } from '../_shared/media';

/**
 * suburbancm/callout editor view — mirrors view.php.
 *
 * @param {Object} props props
 * @return {Object} JSX
 */
const Edit = ( { attributes, setAttributes } ) => {
	const { title, description, list = [], afterText, buttonText, buttonUrl } = attributes;
	const blockProps = useBlockProps( { className: 'scm-callout scm-bg-gold' } );

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Button link', 'suburbancm' ) }>
					<TextControl label={ __( 'Button URL', 'suburbancm' ) } value={ buttonUrl } onChange={ ( value ) => setAttributes( { buttonUrl: value } ) } />
				</PanelBody>
			</InspectorControls>
			<section { ...blockProps }>
				<div className="scm-wrap scm-section scm-callout__inner">
					<div className="scm-callout__text">
						<RichText tagName="h2" className="scm-d scm-h-l" value={ title } onChange={ ( value ) => setAttributes( { title: value } ) } placeholder={ __( 'Headline…', 'suburbancm' ) } />
						<RichText tagName="p" className="scm-lede" value={ description } onChange={ ( value ) => setAttributes( { description: value } ) } placeholder={ __( 'Paragraph…', 'suburbancm' ) } />
						<RichText tagName="p" className="scm-callout__after" value={ afterText } onChange={ ( value ) => setAttributes( { afterText: value } ) } placeholder={ __( 'Bold closing line…', 'suburbancm' ) } />
						<RichText tagName="span" className="scm-btn scm-btn--ink" value={ buttonText } onChange={ ( value ) => setAttributes( { buttonText: value } ) } placeholder={ __( 'Optional button', 'suburbancm' ) } allowedFormats={ [] } />
					</div>
					<ul className="scm-rules scm-callout__list">
						{ list.map( ( item, i ) => (
							<li key={ i } style={ { display: 'flex', alignItems: 'center', gap: 6 } }>
								<RichText tagName="span" value={ item } onChange={ ( value ) => setAttributes( { list: updateItem( list, i, value ) } ) } placeholder={ __( 'List item…', 'suburbancm' ) } />
								<Button size="small" icon="no-alt" label={ __( 'Remove', 'suburbancm' ) } onClick={ () => setAttributes( { list: list.filter( ( _, j ) => j !== i ) } ) } />
							</li>
						) ) }
						<li>
							<Button variant="secondary" size="small" onClick={ () => setAttributes( { list: [ ...list, '' ] } ) }>
								{ __( 'Add item', 'suburbancm' ) }
							</Button>
						</li>
					</ul>
				</div>
			</section>
		</>
	);
};

export default Edit;
