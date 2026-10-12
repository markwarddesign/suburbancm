import { __ } from '@wordpress/i18n';
import { RichText, useBlockProps } from '@wordpress/block-editor';

/**
 * suburbancm/page-title Gutenberg block
 *
 * @param {Object} props props
 * @return {Object} JSX
 */
const Edit = (props) => {
    const { attributes, setAttributes } = props;
    const { title, subtitle } = attributes;

    const blockProps = useBlockProps({
        className: 'suburbancm-page-title bg-gradient-to-br from-brand-bg-light to-brand-border-light dark:from-brand-bg-alt-dark dark:bg-[#1f1f1f] flex items-center justify-center text-center py-24 px-4 sm:px-6 lg:px-8 min-h-[50vh]',
    });

    return (
        <>
            <section {...blockProps}>
                <div
                    className="flex items-center justify-center text-center py-24 px-4 sm:px-6 lg:px-8 min-h-[50vh]"
                >
                    <div className="max-w-3xl">
                        <RichText
                            tagName="h1"
                            className="text-4xl sm:text-5xl font-extrabold text-brand-text-light dark:text-white leading-tight"
                            placeholder={__('Title here…', 'suburbancm')}
                            value={title}
                            onChange={(newTitle) => setAttributes({ title: newTitle })}
                        />
                        <div className="mt-4">
                        <RichText
                            tagName="span"
                            placeholder={__('Subtitle here…', 'suburbancm')}
                            value={subtitle}
                            onChange={(newSubtitle) => setAttributes({ subtitle: newSubtitle })}
                            className="text-lg sm:text-xl text-gold max-w-2xl mx-auto "
                        />
                        </div>

                    </div>
                </div>
            </section>
        </>
    );
};

export default Edit;