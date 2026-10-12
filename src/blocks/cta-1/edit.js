import { __ } from '@wordpress/i18n';
import { RichText, useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, TextControl } from '@wordpress/components';

/**
 * suburbancm/cta-1 Gutenberg block
 *
 * @param {Object} props props
 * @return {Object} JSX
 */
const Edit = (props) => {
    const { attributes, setAttributes } = props;
    const { title, description, buttonText, buttonUrl } = attributes;

    const blockProps = useBlockProps({
        className: 'suburbancm-cta-1',
    });

    return (
        <>
            <InspectorControls>
                <PanelBody title={__('Button Settings', 'suburbancm')} initialOpen={true}>
                    <TextControl
                        label={__('Button URL', 'suburbancm')}
                        value={buttonUrl}
                        onChange={(newUrl) => setAttributes({ buttonUrl: newUrl })}
                        placeholder={__('Enter button URL…', 'suburbancm')}
                    />
                </PanelBody>
            </InspectorControls>
            <section {...blockProps}>
                <div className="suburbancm-cta-1__content bg-[#a38f50] text-[#ffffff] dark:bg-[#80703a]">
					<div class="max-w-4xl mx-auto py-16 px-4 sm:px-6 lg:py-20 lg:px-8 text-center">
						
						<RichText
							tagName="h2"
							className="text-3xl font-extrabold tracking-tight sm:text-4xl"
							placeholder={__('Title here…', 'suburbancm')}
							value={title}
							onChange={(newTitle) => setAttributes({ title: newTitle })}
						/>
						<RichText
							tagName="p"
							className="mt-4 text-lg leading-6 text-[#f6f5ec] dark:text-[#e4d198]"
							placeholder={__('Description here…', 'suburbancm')}
							value={description}
							onChange={(newDescription) => setAttributes({ description: newDescription })}
						/>
						<div className="mt-8">
							<RichText
								tagName="a"
								className="inline-block bg-[#ffffff] text-[#a38f50] hover:bg-[#e4d198] dark:bg-[#f6f5ec] dark:text-[#80703a] dark:hover:bg-[#e4d198] font-semibold px-8 py-3 border border-transparent rounded-md shadow transition duration-200 hover:scale-105 transform"
								placeholder={__('Button text here…', 'suburbancm')}
								value={buttonText}
								onChange={(newButtonText) => setAttributes({ buttonText: newButtonText })}
								href={buttonUrl}
							/>
						</div>

					</div>
                </div>
            </section>
		</>
    );
};

export default Edit;