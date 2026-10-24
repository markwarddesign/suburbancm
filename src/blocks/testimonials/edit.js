import { __ } from '@wordpress/i18n';
import { RichText, MediaUpload, useBlockProps } from '@wordpress/block-editor';
import { Button } from '@wordpress/components';

const Edit = ( { attributes, setAttributes } ) => {
	const { title, testimonials = [] } = attributes;

	const blockProps = useBlockProps( { className: 'scm-quotes scm-bg-ink-2' } );

	const update = ( index, key, value ) =>
		setAttributes( { testimonials: testimonials.map( ( t, i ) => ( i === index ? { ...t, [ key ]: value } : t ) ) } );
	const add = () =>
		setAttributes( { testimonials: [ ...testimonials, { image: '', alt: '', quote: '', name: '', role: '' } ] } );
	const remove = ( index ) => setAttributes( { testimonials: testimonials.filter( ( _, i ) => i !== index ) } );

	return (
		<section { ...blockProps }>
			<div className="scm-wrap scm-section">
				<RichText
					tagName="h2"
					className="scm-eyebrow scm-gold scm-quotes__title"
					placeholder={ __( 'Optional small label, e.g. Client testimonials', 'suburbancm' ) }
					value={ title }
					onChange={ ( value ) => setAttributes( { title: value } ) }
				/>
				{ testimonials.map( ( testimonial, index ) => (
					<figure key={ index } className="scm-quote">
						<div className="scm-d scm-quote__mark">“</div>
						<div className="scm-quote__body">
							<RichText
								tagName="blockquote"
								placeholder={ __( 'Quote…', 'suburbancm' ) }
								value={ testimonial.quote }
								onChange={ ( value ) => update( index, 'quote', value ) }
							/>
							<figcaption>
								{ testimonial.image && <img src={ testimonial.image } alt={ testimonial.alt } /> }
								<RichText
									tagName="span"
									className="scm-quote__name"
									placeholder={ __( 'Name', 'suburbancm' ) }
									value={ testimonial.name }
									onChange={ ( value ) => update( index, 'name', value ) }
								/>
								<RichText
									tagName="span"
									className="scm-quote__role"
									placeholder={ __( 'Role, company', 'suburbancm' ) }
									value={ testimonial.role }
									onChange={ ( value ) => update( index, 'role', value ) }
								/>
								<MediaUpload
									onSelect={ ( media ) => update( index, 'image', media.url ) }
									allowedTypes={ [ 'image' ] }
									render={ ( { open } ) => (
										<Button size="small" variant="secondary" onClick={ open }>
											{ testimonial.image ? __( 'Change photo', 'suburbancm' ) : __( 'Add photo (optional)', 'suburbancm' ) }
										</Button>
									) }
								/>
								<Button size="small" isDestructive icon="trash" label={ __( 'Remove testimonial', 'suburbancm' ) } onClick={ () => remove( index ) } />
							</figcaption>
						</div>
					</figure>
				) ) }
				<Button variant="primary" onClick={ add } style={ { marginTop: 24 } }>
					{ __( 'Add testimonial', 'suburbancm' ) }
				</Button>
			</div>
		</section>
	);
};

export default Edit;
