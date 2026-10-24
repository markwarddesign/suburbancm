import { __ } from '@wordpress/i18n';
import { useBlockProps, RichText, MediaUpload, MediaUploadCheck, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, Button, SelectControl } from '@wordpress/components';

const emptyService = () => ( { image: '', alt: '', title: '', description: '', features: [ '' ] } );

export default function Edit( { attributes, setAttributes } ) {
	const { title, description, services = [], layout = 'rows' } = attributes;

	// Copy-on-write so undo/redo and re-renders see new objects.
	const setService = ( index, patch ) =>
		setAttributes( { services: services.map( ( s, i ) => ( i === index ? { ...s, ...patch } : s ) ) } );
	const setFeature = ( index, fIndex, value ) =>
		setService( index, { features: services[ index ].features.map( ( f, i ) => ( i === fIndex ? value : f ) ) } );
	const removeFeature = ( index, fIndex ) =>
		setService( index, { features: services[ index ].features.filter( ( _, i ) => i !== fIndex ) } );
	const addFeature = ( index ) => setService( index, { features: [ ...( services[ index ].features || [] ), '' ] } );
	const removeService = ( index ) => setAttributes( { services: services.filter( ( _, i ) => i !== index ) } );
	const moveService = ( index, dir ) => {
		const next = [ ...services ];
		const [ item ] = next.splice( index, 1 );
		next.splice( index + dir, 0, item );
		setAttributes( { services: next } );
	};

	const blockProps = useBlockProps( { className: `scm-services scm-bg-bone scm-services--${ layout }` } );
	const isGroups = layout === 'groups';

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Layout', 'suburbancm' ) }>
					<SelectControl
						label={ __( 'Layout', 'suburbancm' ) }
						value={ layout }
						options={ [
							{ label: __( 'Rows — number, text, feature list (Home)', 'suburbancm' ), value: 'rows' },
							{ label: __( 'Groups — with photo and sub-items (Services page)', 'suburbancm' ), value: 'groups' },
						] }
						onChange={ ( value ) => setAttributes( { layout: value } ) }
						help={ isGroups ? __( 'Write each feature as "Title: description".', 'suburbancm' ) : undefined }
					/>
				</PanelBody>
			</InspectorControls>

			<section { ...blockProps }>
				<div className="scm-wrap scm-section">
					<header className="scm-services__head">
						<RichText
							tagName="h2"
							className="scm-d scm-h-l"
							value={ title }
							onChange={ ( value ) => setAttributes( { title: value } ) }
							placeholder={ __( 'Section title…', 'suburbancm' ) }
						/>
						<RichText
							tagName="p"
							className="scm-lede"
							value={ description }
							onChange={ ( value ) => setAttributes( { description: value } ) }
							placeholder={ __( 'Intro text…', 'suburbancm' ) }
						/>
					</header>

					{ services.map( ( service, index ) => (
						<article key={ index } className="scm-services__row">
							<div className={ isGroups ? 'scm-services__lead' : 'scm-services__body' }>
								<div className="scm-services__title">
									<span className="scm-d scm-services__num">{ String( index + 1 ).padStart( 2, '0' ) }</span>
									<RichText
										tagName="h3"
										className="scm-d scm-h-s"
										value={ service.title }
										onChange={ ( value ) => setService( index, { title: value } ) }
										placeholder={ __( 'Service title…', 'suburbancm' ) }
									/>
								</div>
								<RichText
									tagName="p"
									className="scm-services__desc"
									value={ service.description }
									onChange={ ( value ) => setService( index, { description: value } ) }
									placeholder={ __( 'Short description…', 'suburbancm' ) }
								/>
								{ isGroups && (
									<MediaUploadCheck>
										<MediaUpload
											onSelect={ ( media ) => setService( index, { image: media.url, alt: media.alt || service.alt } ) }
											allowedTypes={ [ 'image' ] }
											render={ ( { open } ) => (
												<div className="scm-services__img scm-media">
													{ service.image ? (
														<>
															<img src={ service.image } alt={ service.alt } />
															<div className="scm-edit-overlay">
																<Button variant="secondary" onClick={ open }>{ __( 'Replace', 'suburbancm' ) }</Button>
															</div>
														</>
													) : (
														<div className="scm-edit-empty">
															<Button variant="primary" onClick={ open }>{ __( 'Add photo', 'suburbancm' ) }</Button>
														</div>
													) }
												</div>
											) }
										/>
									</MediaUploadCheck>
								) }
							</div>

							<ul className={ isGroups ? 'scm-services__items' : 'scm-services__features' }>
								{ ( service.features || [] ).map( ( feature, fIndex ) => (
									<li key={ fIndex } className={ isGroups ? 'scm-services__item' : undefined }>
										<RichText
											tagName="span"
											value={ feature }
											onChange={ ( value ) => setFeature( index, fIndex, value ) }
											placeholder={ isGroups ? __( 'Title: description', 'suburbancm' ) : __( 'Feature…', 'suburbancm' ) }
										/>
										<Button size="small" icon="no-alt" label={ __( 'Remove', 'suburbancm' ) } onClick={ () => removeFeature( index, fIndex ) } />
									</li>
								) ) }
								<li>
									<Button variant="secondary" size="small" onClick={ () => addFeature( index ) }>
										{ isGroups ? __( 'Add sub-item', 'suburbancm' ) : __( 'Add feature', 'suburbancm' ) }
									</Button>
								</li>
							</ul>

							<div className="scm-edit-row-tools">
								<Button size="small" icon="arrow-up-alt2" label={ __( 'Move up', 'suburbancm' ) } disabled={ index === 0 } onClick={ () => moveService( index, -1 ) } />
								<Button size="small" icon="arrow-down-alt2" label={ __( 'Move down', 'suburbancm' ) } disabled={ index === services.length - 1 } onClick={ () => moveService( index, 1 ) } />
								<Button size="small" icon="trash" isDestructive label={ __( 'Remove service', 'suburbancm' ) } onClick={ () => removeService( index ) } />
							</div>
						</article>
					) ) }

					<Button variant="primary" onClick={ () => setAttributes( { services: [ ...services, emptyService() ] } ) }>
						{ __( 'Add service', 'suburbancm' ) }
					</Button>
				</div>
			</section>
		</>
	);
}
