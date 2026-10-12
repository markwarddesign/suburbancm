import { __ } from '@wordpress/i18n';
import { RichText, useBlockProps, BlockControls, AlignmentToolbar } from '@wordpress/block-editor';
import { ToolbarGroup, DropdownMenu } from '@wordpress/components';

const headingLevels = [
    { level: 2, label: 'H2' },
    { level: 3, label: 'H3' },
    { level: 4, label: 'H4' },
    { level: 5, label: 'H5' },
];

const Edit = (props) => {
    const { attributes, setAttributes } = props;
    const { title, description, level = 2, align = 'center' } = attributes;

    const blockProps = useBlockProps({
        className: `suburbancm-section-title max-w-3xl mx-auto mb-10`,
    });

    const HeadingTag = `h${level}`;
    const alignClass = `text-${align}`;

    return (
        <>
            <BlockControls>
                <ToolbarGroup>
                    <DropdownMenu
                        icon="heading"
                        label={__('Change heading level', 'suburbancm')}
                        controls={headingLevels.map(({ level: lvl, label }) => ({
                            title: label,
                            icon: 'heading',
                            isActive: level === lvl,
                            onClick: () => setAttributes({ ...attributes, level: lvl }),
                        }))}
                    />
                </ToolbarGroup>
                <AlignmentToolbar
                    value={align}
                    onChange={(newAlign) => setAttributes({ align: newAlign || 'center' })}
                />
            </BlockControls>
            <div {...blockProps}>
                <div className="suburbancm-section-title__content flex flex-col items-center text-center">
                    <RichText
                        tagName={HeadingTag}
                        className={`suburbancm-section-title__title mb-4 ${alignClass}`}
                        placeholder={__('Title here…', 'suburbancm')}
                        value={title}
                        onChange={(newTitle) => setAttributes({ title: newTitle })}
                        allowedFormats={[]}
                    />
                    <RichText
                        tagName="p"
                        className={`suburbancm-section-title__description heading-description ${alignClass}`}
                        placeholder={__('Description here…', 'suburbancm')}
                        value={description}
                        onChange={(newDesc) => setAttributes({ description: newDesc })}
                    />
                </div>
            </div>
        </>
    );
};

export default Edit;