import { __ } from '@wordpress/i18n';
import { useBlockProps, RichText } from '@wordpress/block-editor';
import { Button, ToggleControl, TextareaControl } from '@wordpress/components';
import { updateItem } from '../_shared/media';

const newPhase = ( n ) => ( { title: `Phase ${ n }`, subtitle: '', description: '', image: '', imageAlt: '', steps: [] } );
const newStep = () => ( { heading: '', text: '', isList: false } );

export default function Edit( { attributes, setAttributes } ) {
	const { title, description, phases = [] } = attributes;
	const blockProps = useBlockProps( { className: 'scm-phases scm-bg-ink' } );

	const setPhase = ( i, patch ) => setAttributes( { phases: updateItem( phases, i, patch ) } );
	const setStep = ( i, s, patch ) => setPhase( i, { steps: updateItem( phases[ i ].steps || [], s, patch ) } );

	return (
		<section { ...blockProps }>
			<div className="scm-wrap scm-section">
				<RichText tagName="h2" className="scm-d scm-h-l" value={ title } onChange={ ( value ) => setAttributes( { title: value } ) } placeholder={ __( 'Section heading…', 'suburbancm' ) } />
				<RichText tagName="p" className="scm-lede scm-phases__intro" value={ description } onChange={ ( value ) => setAttributes( { description: value } ) } placeholder={ __( 'Optional intro…', 'suburbancm' ) } />

				{ phases.map( ( phase, i ) => (
					<article key={ i } className="scm-phase">
						<div className="scm-phase__lead">
							<RichText tagName="p" className="scm-d scm-phase__label" value={ phase.title } onChange={ ( value ) => setPhase( i, { title: value } ) } placeholder={ __( 'Phase 1', 'suburbancm' ) } allowedFormats={ [] } />
							<RichText tagName="h3" className="scm-d scm-h-s" value={ phase.subtitle } onChange={ ( value ) => setPhase( i, { subtitle: value } ) } placeholder={ __( 'Phase name…', 'suburbancm' ) } />
							<RichText tagName="p" className="scm-phase__summary" value={ phase.description } onChange={ ( value ) => setPhase( i, { description: value } ) } placeholder={ __( 'Summary…', 'suburbancm' ) } />
							<Button size="small" isDestructive variant="link" onClick={ () => setAttributes( { phases: phases.filter( ( _, j ) => j !== i ) } ) }>
								{ __( 'Remove phase', 'suburbancm' ) }
							</Button>
						</div>
						<div className="scm-phase__steps">
							{ ( phase.steps || [] ).map( ( step, s ) => (
								<div key={ s } className="scm-step">
									<RichText tagName="h4" value={ step.heading } onChange={ ( value ) => setStep( i, s, { heading: value } ) } placeholder={ __( 'Step heading…', 'suburbancm' ) } />
									{ step.isList ? (
										<TextareaControl
											label={ __( 'One bullet per line', 'suburbancm' ) }
											value={ Array.isArray( step.text ) ? step.text.join( '\n' ) : step.text || '' }
											onChange={ ( value ) => setStep( i, s, { text: value.split( '\n' ) } ) }
										/>
									) : (
										<RichText tagName="p" value={ Array.isArray( step.text ) ? step.text.join( ' ' ) : step.text } onChange={ ( value ) => setStep( i, s, { text: value } ) } placeholder={ __( 'Step text…', 'suburbancm' ) } />
									) }
									<ToggleControl
										label={ __( 'Bulleted list', 'suburbancm' ) }
										checked={ !! step.isList }
										onChange={ ( isList ) =>
											setStep( i, s, {
												isList,
												text: isList ? [ ].concat( step.text || '' ) : ( Array.isArray( step.text ) ? step.text.join( ' ' ) : step.text ),
											} )
										}
									/>
									<Button size="small" isDestructive icon="trash" label={ __( 'Remove step', 'suburbancm' ) } onClick={ () => setPhase( i, { steps: phase.steps.filter( ( _, k ) => k !== s ) } ) } />
								</div>
							) ) }
							<div>
								<Button variant="secondary" size="small" onClick={ () => setPhase( i, { steps: [ ...( phase.steps || [] ), newStep() ] } ) }>
									{ __( 'Add step', 'suburbancm' ) }
								</Button>
							</div>
						</div>
					</article>
				) ) }
				<Button variant="primary" style={ { marginTop: 24 } } onClick={ () => setAttributes( { phases: [ ...phases, newPhase( phases.length + 1 ) ] } ) }>
					{ __( 'Add phase', 'suburbancm' ) }
				</Button>
			</div>
		</section>
	);
}
