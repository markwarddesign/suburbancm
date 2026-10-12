import { __ } from '@wordpress/i18n';
import { RichText, useBlockProps, InspectorControls, BlockControls, URLInputButton } from '@wordpress/block-editor';
import { PanelBody, ToggleControl, ToolbarGroup, ToolbarButton } from '@wordpress/components';
import { link as linkIcon } from '@wordpress/icons';

/**
 * suburbancm/bid-header Gutenberg block
 *
 * @param {Object} props props
 * @return {Object} JSX
 */
const Edit = (props) => {
    const { attributes, setAttributes } = props;
    const { title, buttonText, buttonUrl, hideBreadcrumb } = attributes;

    const blockProps = useBlockProps({
        className: 'suburbancm-bid-header',
    });

    return (
        <>
            <BlockControls>
                <ToolbarGroup>
                    <ToolbarButton
                        icon={linkIcon}
                        label={__('Edit Button Link', 'suburbancm')}
                        onClick={() => {
                            const url = prompt(__('Enter button URL:', 'suburbancm'), buttonUrl || '');
                            if (url !== null) setAttributes({ buttonUrl: url });
                        }}
                    />
                </ToolbarGroup>
            </BlockControls>
            <InspectorControls>
                <PanelBody title={__('Header Options', 'suburbancm')}>
                    <ToggleControl
                        label={__('Hide Breadcrumb', 'suburbancm')}
                        checked={!!hideBreadcrumb}
                        onChange={(val) => setAttributes({ hideBreadcrumb: val })}
                    />
                </PanelBody>
            </InspectorControls>
            <div {...blockProps}>
                <div className="suburbancm-bid-header__content">
                    {!hideBreadcrumb && (
                        <nav className="flex mb-2" aria-label="Breadcrumb">
                            <ol className="flex items-center space-x-2">
                                <li>
                                    <div>
                                        <span className="text-sm font-medium text-brand-text-muted-dark">Projects</span>
                                    </div>
                                </li>
                                <li>
                                    <div className="flex items-center">
                                        <svg className="flex-shrink-0 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path fillRule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clipRule="evenodd" />
                                        </svg>
                                        <span className="ml-2 text-sm font-medium text-brand-text-muted-dark">Project Type</span>
                                    </div>
                                </li>
                            </ol>
                        </nav>
                    )}
                    <RichText
                        tagName="h2"
                        className="suburbancm-bid-header__title"
                        placeholder={__('Title here…', 'suburbancm')}
                        value={title}
                        onChange={(newTitle) =>
                            setAttributes({ title: newTitle })
                        }
                    />
                    <div className="mt-4 flex gap-2 items-center">
                        <RichText
                            tagName="span"
                            className="btn primary inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-brand-accent hover:bg-brand-accent-hover focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-accent transition duration-150 ease-in-out"
                            placeholder={__('Button text…', 'suburbancm')}
                            value={buttonText}
                            onChange={(val) => setAttributes({ buttonText: val })}
                            allowedFormats={[]}
                        />
                        {buttonText && (
                            <a
                                href={buttonUrl || '#'}
                                className="text-xs text-brand-accent underline"
                                target="_blank"
                                rel="noopener noreferrer"
                                style={{ marginLeft: 8 }}
                            >
                                {__('Visit Link', 'suburbancm')}
                            </a>
                        )}
                    </div>
                </div>
            </div>
        </>
    );
};

export default Edit;