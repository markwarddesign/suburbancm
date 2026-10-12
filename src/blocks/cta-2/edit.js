import { __ } from '@wordpress/i18n';
import { RichText, useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, TextControl, Button } from '@wordpress/components';

/**
 * suburbancm/cta-2 Gutenberg block
 *
 * @param {Object} props props
 * @return {Object} JSX
 */
const Edit = (props) => {
    const { attributes, setAttributes } = props;
    const { title, subtitle, primaryButtonText, primaryButtonUrl, secondaryButtonText, secondaryButtonUrl } = attributes;

    const blockProps = useBlockProps({
        className: 'suburbancm-cta-2 bg-[#f6f5ec] dark:bg-[#1f1f1f]',
    });

    return (
        <>
            <InspectorControls>
                <PanelBody title={__('Button Settings', 'suburbancm')} initialOpen={true}>
                    <TextControl
                        label={__('Primary Button URL', 'suburbancm')}
                        value={primaryButtonUrl}
                        onChange={(newUrl) => setAttributes({ primaryButtonUrl: newUrl })}
                        placeholder={__('Enter primary button URL…', 'suburbancm')}
                    />
                    <TextControl
                        label={__('Secondary Button URL', 'suburbancm')}
                        value={secondaryButtonUrl}
                        onChange={(newUrl) => setAttributes({ secondaryButtonUrl: newUrl })}
                        placeholder={__('Enter secondary button URL…', 'suburbancm')}
                    />
                </PanelBody>
            </InspectorControls>
            <section {...blockProps}>
                <div className="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8 lg:flex lg:items-center lg:justify-between">
                    <div>
                        <RichText
                            tagName="h2"
                            className="text-3xl font-extrabold tracking-tight text-[#000000] dark:text-[#ffffff] sm:text-4xl"
                            placeholder={__('Title here…', 'suburbancm')}
                            value={title}
                            onChange={(newTitle) => setAttributes({ title: newTitle })}
                        />
                        <RichText
                            tagName="span"
                            className="text-3xl font-extrabold tracking-tight block text-[#a38f50] dark:text-[#e4d198]"
                            placeholder={__('Subtitle here…', 'suburbancm')}
                            value={subtitle}
                            onChange={(newSubtitle) => setAttributes({ subtitle: newSubtitle })}
                        />
                    </div>
                    <div className="mt-8 flex lg:mt-0 lg:flex-shrink-0">
                        <div className="inline-flex rounded-md shadow">
							<Button 
								className="btn primary-inverse"
								target="_blank"
								rel="noopener noreferrer"
							>
								<RichText
									tagName="span"
									placeholder={__('Primary button text…', 'suburbancm')}
									value={primaryButtonText}
									onChange={(newText) => setAttributes({ primaryButtonText: newText })}
									href={primaryButtonUrl}
								/>
							</Button>
                        </div>
                        <div className="ml-3 inline-flex rounded-md shadow">
							<Button 
								className="btn secondary"
								target="_blank"
								rel="noopener noreferrer"
							>
								<RichText
									tagName="span"
									placeholder={__('Secondary button text…', 'suburbancm')}
									value={secondaryButtonText}
									onChange={(newText) => setAttributes({ secondaryButtonText: newText })}
									href={secondaryButtonUrl}
								/>
							</Button>
                        </div>
                    </div>
                </div>
            </section>
        </>
    );
};

export default Edit;