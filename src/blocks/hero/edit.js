import { __ } from '@wordpress/i18n';
import {
    useBlockProps,
    RichText,
    InspectorControls,
    MediaUpload,
    MediaUploadCheck,
    URLInput,
} from '@wordpress/block-editor';
import {
    PanelBody,
    Button,
    TextControl,
    ResponsiveWrapper,
} from '@wordpress/components';
import { Fragment } from '@wordpress/element';

export default function Edit({ attributes, setAttributes }) {
    const {
        headingLine1,
        headingHighlight,
        paragraph,
        button1Text,
        button1Link,
        button2Text,
        button2Link,
        backgroundImageId,
        backgroundImageUrl,
    } = attributes;

    const blockProps = useBlockProps({
        className: 'relative bg-cover bg-center text-white bg-[#1f1f1f]', // Tailwind classes for background and text
        style: backgroundImageUrl ? { backgroundImage: `url(${backgroundImageUrl})` } : {},
    });

    const onSelectImage = (media) => {
        setAttributes({
            backgroundImageId: media.id,
            backgroundImageUrl: media.url,
        });
    };

    const onRemoveImage = () => {
        setAttributes({
            backgroundImageId: undefined,
            backgroundImageUrl: '',
        });
    };

    return (
        <Fragment>
            <InspectorControls>
                <PanelBody title={__('Background Settings', 'suburbancm-hero-block')}>
                    <MediaUploadCheck>
                        <MediaUpload
                            onSelect={onSelectImage}
                            allowedTypes={['image']}
                            value={backgroundImageId}
                            render={({ open }) => (
                                <Button
                                    variant={backgroundImageId ? 'secondary' : 'primary'}
                                    onClick={open}
                                >
                                    {backgroundImageId ? __('Replace Image', 'suburbancm-hero-block') : __('Upload Image', 'suburbancm-hero-block')}
                                </Button>
                            )}
                        />
                    </MediaUploadCheck>
                    {backgroundImageId && (
                        <Button
                            variant="link"
                            isDestructive
                            onClick={onRemoveImage}
                            style={{ marginTop: '10px' }}
                        >
                            {__('Remove Image', 'suburbancm-hero-block')}
                        </Button>
                    )}
                    {backgroundImageUrl && (
                        <ResponsiveWrapper
                            naturalWidth={200}
                            naturalHeight={100}
                            isInline={false}
                        >
                            <img
                                src={backgroundImageUrl}
                                alt={__('Background Preview', 'suburbancm-hero-block')}
                                style={{ marginTop: '10px', maxWidth: '100%', height: 'auto' }}
                            />
                        </ResponsiveWrapper>
                    )}
                </PanelBody>
                <PanelBody title={__('Button 1 Settings', 'suburbancm-hero-block')}>
                    <TextControl
                        label={__('Button 1 Text', 'suburbancm-hero-block')}
                        value={button1Text}
                        onChange={(val) => setAttributes({ button1Text: val })}
                    />
                    <label className="components-base-control__label" htmlFor="button-1-url-input">
                        {__('Button 1 Link', 'suburbancm-hero-block')}
                    </label>
                    <URLInput
                        value={button1Link}
                        onChange={(url) => setAttributes({ button1Link: url })}
                        id="button-1-url-input"
                    />
                </PanelBody>
                <PanelBody title={__('Button 2 Settings', 'suburbancm-hero-block')}>
                    <TextControl
                        label={__('Button 2 Text', 'suburbancm-hero-block')}
                        value={button2Text}
                        onChange={(val) => setAttributes({ button2Text: val })}
                    />
                    <label className="components-base-control__label" htmlFor="button-2-url-input">
                        {__('Button 2 Link', 'suburbancm-hero-block')}
                    </label>
                    <URLInput
                        value={button2Link}
                        onChange={(url) => setAttributes({ button2Link: url })}
                        id="button-2-url-input"
                    />
                </PanelBody>
            </InspectorControls>

            <section {...blockProps}>
                <div className="max-w-4xl mx-auto text-center py-20 px-4 flex flex-col justify-center">
                    <RichText
                        tagName="h1"
                        value={headingLine1 + headingHighlight}
                        onChange={(newVal) => {
                            const highlightIndex = newVal.lastIndexOf(headingHighlight);
                            if (highlightIndex > -1 && newVal.endsWith(headingHighlight)) {
                                setAttributes({
                                    headingLine1: newVal.substring(0, highlightIndex),
                                    headingHighlight: headingHighlight,
                                });
                            } else {
                                const lastSpace = newVal.lastIndexOf(' ');
                                if (lastSpace > -1) {
                                    setAttributes({
                                        headingLine1: newVal.substring(0, lastSpace + 1),
                                        headingHighlight: newVal.substring(lastSpace + 1),
                                    });
                                } else {
                                    setAttributes({ headingLine1: newVal, headingHighlight: '' });
                                }
                            }
                        }}
                        placeholder={__('Enter heading...', 'suburbancm-hero-block')}
                        className="text-4xl sm:text-5xl md:text-6xl font-extrabold text-white leading-tight"
                    />
                    <div className='flex flex-col items-center'>
                    <RichText
                        tagName="p"
                        value={paragraph}
                        onChange={(val) => setAttributes({ paragraph: val })}
                        placeholder={__('Enter paragraph text...', 'suburbancm-hero-block')}
                        className="mt-4 text-lg sm:text-xl text-[#80703a] dark:text-[#e4d198]/80 max-w-2xl mx-auto text-center"
                    />
                    </div>
                    <div className="mt-8 flex justify-center gap-4 flex-wrap">
                        <Button
                            href={button1Link}
                            className="btn primary"
                        >
                            {button1Text || __('Button 1', 'suburbancm-hero-block')}
                        </Button>
                        <Button
                            href={button2Link}
                            className="btn secondary"
                        >
                            {button2Text || __('Button 2', 'suburbancm-hero-block')}
                        </Button>
                    </div>
                </div>
            </section>
        </Fragment>
    );
}