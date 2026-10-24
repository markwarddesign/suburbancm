import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, CheckboxControl, Spinner, ToggleControl, TextControl } from '@wordpress/components';
import { useEffect, useState } from '@wordpress/element';
import apiFetch from '@wordpress/api-fetch';
import ServerSideRender from '@wordpress/server-side-render';

const Edit = ( { attributes, setAttributes } ) => {
	const { title, showAll = true, selectedTeamMembers = [], hideTitle = false, ctaText, ctaUrl } = attributes;
	const [ teamPosts, setTeamPosts ] = useState( null );

	useEffect( () => {
		apiFetch( { path: '/wp/v2/team?per_page=100&_fields=id,title' } )
			.then( setTeamPosts )
			.catch( () => setTeamPosts( [] ) );
	}, [] );

	const toggleMember = ( id, checked ) =>
		setAttributes( {
			selectedTeamMembers: checked ? [ ...selectedTeamMembers, id ] : selectedTeamMembers.filter( ( m ) => m !== id ),
		} );

	return (
		<div { ...useBlockProps() }>
			<InspectorControls>
				<PanelBody title={ __( 'Team members', 'suburbancm' ) } initialOpen={ true }>
					<TextControl label={ __( 'Small label above (optional)', 'suburbancm' ) } value={ title } onChange={ ( value ) => setAttributes( { title: value } ) } />
					<ToggleControl label={ __( 'Hide label', 'suburbancm' ) } checked={ !! hideTitle } onChange={ ( value ) => setAttributes( { hideTitle: value } ) } />
					<CheckboxControl label={ __( 'Show all team members', 'suburbancm' ) } checked={ !! showAll } onChange={ ( value ) => setAttributes( { showAll: value } ) } />
					{ ! showAll && ( teamPosts === null ? <Spinner /> : teamPosts.map( ( member ) => (
						<CheckboxControl
							key={ member.id }
							label={ member.title.rendered }
							checked={ selectedTeamMembers.includes( member.id ) }
							onChange={ ( checked ) => toggleMember( member.id, checked ) }
						/>
					) ) ) }
				</PanelBody>
				<PanelBody title={ __( 'Second button', 'suburbancm' ) } initialOpen={ false }>
					<TextControl label={ __( 'Text', 'suburbancm' ) } value={ ctaText } onChange={ ( value ) => setAttributes( { ctaText: value } ) } />
					<TextControl label={ __( 'Link', 'suburbancm' ) } value={ ctaUrl } onChange={ ( value ) => setAttributes( { ctaUrl: value } ) } />
				</PanelBody>
			</InspectorControls>
			<ServerSideRender block="suburbancm/team" attributes={ attributes } />
		</div>
	);
};

export default Edit;
