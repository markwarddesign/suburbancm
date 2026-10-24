import { __ } from '@wordpress/i18n';
import { useBlockProps, RichText, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, SelectControl, TextControl } from '@wordpress/components';
import { useEffect, useState } from '@wordpress/element';
import apiFetch from '@wordpress/api-fetch';

const Tile = ( { project, feature } ) => {
	const img = project._embedded?.[ 'wp:featuredmedia' ]?.[ 0 ]?.source_url;
	const type = project._embedded?.[ 'wp:term' ]?.flat().find( ( t ) => t.taxonomy === 'project_type' )?.name;
	return (
		<div className={ `scm-tile ${ feature ? 'scm-tile--feature' : 'scm-tile--side' }` }>
			{ img && <img src={ img } alt="" /> }
			<span className="scm-tile__label">
				{ type && <span className="scm-eyebrow scm-gold">{ type }</span> }
				<span
					className="scm-d scm-tile__title"
					dangerouslySetInnerHTML={ { __html: project.title.rendered } }
				/>
				{ feature && <span className="scm-tile__more">{ __( 'View project →', 'suburbancm' ) }</span> }
			</span>
		</div>
	);
};

const Edit = ( { attributes, setAttributes } ) => {
	const { selectedProjects = [], title, description, buttonText, buttonUrl } = attributes;
	const [ projects, setProjects ] = useState( [] );
	const [ preview, setPreview ] = useState( [] );

	useEffect( () => {
		apiFetch( { path: '/wp/v2/projects?per_page=100&_fields=id,title' } ).then( setProjects );
	}, [] );

	useEffect( () => {
		if ( ! selectedProjects.length ) {
			setPreview( [] );
			return;
		}
		apiFetch( { path: `/wp/v2/projects?include=${ selectedProjects.join( ',' ) }&orderby=include&_embed` } ).then( setPreview );
	}, [ selectedProjects ] );

	const blockProps = useBlockProps( { className: 'scm-projects scm-bg-ink' } );

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Projects', 'suburbancm' ) } initialOpen={ true }>
					<SelectControl
						multiple
						label={ __( 'Choose projects (the first is shown large)', 'suburbancm' ) }
						value={ selectedProjects.map( String ) }
						options={ projects.map( ( p ) => ( { label: p.title.rendered, value: String( p.id ) } ) ) }
						onChange={ ( ids ) => setAttributes( { selectedProjects: ids.map( Number ) } ) }
					/>
				</PanelBody>
				<PanelBody title={ __( 'Link', 'suburbancm' ) } initialOpen={ false }>
					<TextControl
						label={ __( 'Link text', 'suburbancm' ) }
						value={ buttonText || '' }
						onChange={ ( value ) => setAttributes( { buttonText: value } ) }
						help={ __( 'e.g. All projects →', 'suburbancm' ) }
					/>
					<TextControl
						label={ __( 'Link URL', 'suburbancm' ) }
						value={ buttonUrl || '' }
						onChange={ ( value ) => setAttributes( { buttonUrl: value } ) }
					/>
				</PanelBody>
			</InspectorControls>

			<section { ...blockProps }>
				<div className="scm-wrap scm-section">
					<header className="scm-projects__head">
						<div>
							<RichText
								tagName="h2"
								className="scm-d scm-h-l"
								value={ title }
								onChange={ ( value ) => setAttributes( { title: value } ) }
								placeholder={ __( 'Featured projects', 'suburbancm' ) }
							/>
							<RichText
								tagName="p"
								className="scm-lede"
								value={ description }
								onChange={ ( value ) => setAttributes( { description: value } ) }
								placeholder={ __( 'Optional intro…', 'suburbancm' ) }
							/>
						</div>
						{ buttonText && <span className="scm-link">{ buttonText }</span> }
					</header>

					{ preview.length === 0 ? (
						<p className="scm-lede">{ __( 'Choose projects in the sidebar.', 'suburbancm' ) }</p>
					) : (
						<div className="scm-projects__grid">
							<Tile project={ preview[ 0 ] } feature />
							{ preview.length > 1 && (
								<div className="scm-projects__side">
									{ preview.slice( 1, 3 ).map( ( p ) => <Tile key={ p.id } project={ p } /> ) }
								</div>
							) }
						</div>
					) }
				</div>
			</section>
		</>
	);
};

export default Edit;
