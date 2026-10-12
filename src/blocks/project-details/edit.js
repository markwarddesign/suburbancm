import { __ } from '@wordpress/i18n';
import { useBlockProps, RichText } from '@wordpress/block-editor';
import { TextControl } from '@wordpress/components';
import { useEntityProp } from '@wordpress/core-data';

export default function Edit( { attributes, setAttributes, context } ) {
    const { postType, postId } = context;
    const blockProps = useBlockProps( {
        className: 'wp-block-suburbancm-project-details',
    } );

    const [ meta, setMeta ] = useEntityProp( 'postType', postType, 'meta', postId );

    // A single handler to update any meta field.
    const updateMeta = ( key, value ) => {
        setMeta( { ...( meta || {} ), [ key ]: value } );
    };

    if ( postType && postType !== 'projects' ) {
        return (
            <p { ...blockProps }>
                { __(
                    'This block is only for the "Projects" post type.',
                    'suburbancm'
                ) }
            </p>
        );
    }

    const DetailItem = ( { label, children } ) => (
        <div className="project-detail-item mb-6">
            <h3 className="project-detail-label">{ label }</h3>
            <div className="project-detail-value">{ children }</div>
        </div>
    );

    return (
        <div { ...blockProps }>
            <h2 className="project-details-title">Project Details</h2>

            <DetailItem label={ __( 'Client', 'suburbancm' ) }>
                <RichText
                    tagName="p"
                    value={ meta?._wp_projects_client || '' }
                    onChange={ ( val ) => updateMeta( '_wp_projects_client', val ) }
                    placeholder={ __( 'Enter client name...', 'suburbancm' ) }
                    allowedFormats={ [] }
                />
            </DetailItem>

            <DetailItem label={ __( 'Location', 'suburbancm' ) }>
                <RichText
                    tagName="p"
                    value={ meta?._wp_projects_location || '' }
                    onChange={ ( val ) =>
                        updateMeta( '_wp_projects_location', val )
                    }
                    placeholder={ __( 'Enter location...', 'suburbancm' ) }
                    allowedFormats={ [] }
                />
            </DetailItem>

            <DetailItem label={ __( 'Size', 'suburbancm' ) }>
                <RichText
                    tagName="p"
                    value={ meta?._wp_projects_size || '' }
                    onChange={ ( val ) => updateMeta( '_wp_projects_size', val ) }
                    placeholder={ __( 'Enter project size...', 'suburbancm' ) }
                    allowedFormats={ [] }
                />
            </DetailItem>

            <DetailItem label={ __( 'Start Date', 'suburbancm' ) }>
                <TextControl
                    type="date"
                    value={ meta?._wp_projects_start_date || '' }
                    onChange={ ( val ) =>
                        updateMeta( '_wp_projects_start_date', val )
                    }
                />
            </DetailItem>

            <DetailItem label={ __( 'Completion Date', 'suburbancm' ) }>
                <TextControl
                    type="date"
                    value={ meta?._wp_projects_completion_date || '' }
                    onChange={ ( val ) =>
                        updateMeta( '_wp_projects_completion_date', val )
                    }
                />
            </DetailItem>

            {/* Hidden fields that are still needed but not displayed here */}
            <div style={ { display: 'none' } }>
                <RichText
                    tagName="p"
                    value={ meta?._wp_projects_subtitle || '' }
                    onChange={ ( val ) =>
                        updateMeta( '_wp_projects_subtitle', val )
                    }
                />
                <RichText
                    tagName="div"
                    value={ meta?._wp_projects_short_description || '' }
                    onChange={ ( val ) =>
                        updateMeta( '_wp_projects_short_description', val )
                    }
                />
            </div>
        </div>
    );
}