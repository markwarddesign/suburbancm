import { __ } from '@wordpress/i18n';
import { RichText, useBlockProps, InspectorControls, MediaUpload, MediaUploadCheck, URLInput, LinkControl } from '@wordpress/block-editor';
import { Button, TextControl, ToggleControl, PanelBody, Popover } from '@wordpress/components';
import { useState } from '@wordpress/element';

/**
 * suburbancm/mission Gutenberg block
 *
 * @param {Object} props props
 * @return {Object} JSX
 */
const Edit = (props) => {
    const { attributes, setAttributes } = props;
    const { title, description, buttonText, buttonUrl, imageUrl, imageAlt, rowReverse } = attributes;

    const [isLinkPopoverOpen, setIsLinkPopoverOpen] = useState(false);

    const blockProps = useBlockProps({
        className: 'suburbancm-mission py-16 lg:py-24',
    });

    return (
        <>
            <InspectorControls>
                <PanelBody title={__('Mission Block Settings', 'suburbancm')} initialOpen={true}>
                    <div style={{ display: 'flex', flexDirection: 'column', gap: 16 }}>

                        <MediaUpload
                            onSelect={(media) => setAttributes({ imageUrl: media.url, imageAlt: media.alt })}
                            allowedTypes={['image']}
                            value={imageUrl}
                            render={({ open }) => (
                                <div>
                                    <Button onClick={open} variant="primary">
                                        {imageUrl ? __('Replace Image', 'suburbancm') : __('Select Image', 'suburbancm')}
                                    </Button>
                                    {imageUrl && (
                                        <img
                                            src={imageUrl}
                                            alt={imageAlt || __('Selected image', 'suburbancm')}
                                            className="rounded-lg shadow-md w-full object-cover mt-4"
                                            style={{ marginTop: 12 }}
                                        />
                                    )}
                                </div>
                            )}
                        />
                        <TextControl
                            label={__('Image Alt Text', 'suburbancm')}
                            value={imageAlt}
                            onChange={(newAlt) => setAttributes({ imageAlt: newAlt })}
                            placeholder={__('Enter image alt text…', 'suburbancm')}
                        />
                        <ToggleControl
                            label={__('Reverse Row on Desktop', 'suburbancm')}
                            checked={!!rowReverse}
                            onChange={(val) => setAttributes({ rowReverse: val })}
                            help={__('Reverse the order of text and image on desktop (mobile order stays the same).', 'suburbancm')}
                        />
                    </div>
                </PanelBody>
            </InspectorControls>
            <section {...blockProps}>
                <div className={
                    `max-w-7xl mx-auto px-6 lg:px-8 flex flex-col md:flex-row gap-12 items-center` +
                    (rowReverse ? ' md:flex-row-reverse' : '')
                }>
                    <div className="relative w-full">
                        <RichText
                            tagName="h2"
                            className="text-3xl font-extrabold text-brand-text-light dark:text-white sm:text-4xl mb-4"
                            placeholder={__('Title here…', 'suburbancm')}
                            value={title}
                            onChange={(newTitle) => setAttributes({ title: newTitle })}
                        />
                        <RichText
                            tagName="p"
                            className="text-light-gold text-lg mb-6"
                            placeholder={__('Description here…', 'suburbancm')}
                            value={description}
                            onChange={(newDescription) => setAttributes({ description: newDescription })}
                        />
                        <div style={{ display: 'inline-block', position: 'relative' }}>
                            <Button
                                className="btn primary"
                                href={buttonUrl}
                                target="_blank"
                                rel="noopener noreferrer"
                                onClick={(e) => {
                                    e.preventDefault();
                                    setIsLinkPopoverOpen((open) => !open);
                                }}
                            >
                                {buttonText || __('Learn More', 'suburbancm')}
                            </Button>
                            {isLinkPopoverOpen && (
                                <div style={{ position: 'absolute', left: 0, top: '100%', zIndex: 1000, minWidth: 320 }}>
                                    <Popover
                                        placement="bottom-start"
                                        onClose={() => setIsLinkPopoverOpen(false)}
                                        focusOnMount={false}
                                        anchorRef={null}
                                        // The anchorRef is null so Popover will use the parent div as anchor
                                    >
                                        <div style={{ minWidth: 280, padding: 16, display: 'flex', flexDirection: 'column', gap: 12 }}>
                                            <TextControl
                                                label={__('Button Text', 'suburbancm')}
                                                value={buttonText}
                                                onChange={(newText) => setAttributes({ buttonText: newText })}
                                                placeholder={__('Enter button text…', 'suburbancm')}
                                                autoFocus
                                            />
                                            <LinkControl
                                                value={{
                                                    url: buttonUrl || '',
                                                    title: buttonText || '',
                                                }}
                                                onChange={({ url }) => setAttributes({ buttonUrl: url })}
                                                showSuggestions
                                                withCreateSuggestion
                                                forceIsEditingLink
                                            />
                                            <Button
                                                variant="primary"
                                                onClick={() => setIsLinkPopoverOpen(false)}
                                                style={{ marginTop: 8 }}
                                            >
                                                {__('Done', 'suburbancm')}
                                            </Button>
                                        </div>
                                    </Popover>
                                </div>
                            )}
                        </div>
                    </div>
                    <div className="relative w-full">
                        <div className="absolute inset-0 bg-gradient-to-r from-[#a38f50] to-[#80703a] opacity-50 rounded-lg">
                            <MediaUploadCheck>
                                <MediaUpload
                                    onSelect={(media) => setAttributes({ imageUrl: media.url })}
                                    allowedTypes={['image']}
                                    render={({ open }) => (
                                        <Button
                                            className="absolute inset-0 w-full h-full bg-gray-200 flex items-center justify-center"
                                            onClick={open}
                                        >
                                            {__('Select Image', 'suburbancm')}
                                        </Button>
                                    )}
                                />
                            </MediaUploadCheck>
                        </div>
                        <img
                            src={imageUrl || 'https://fakeimg.pl/600x400/cccccc/909090?text=Team+Working'}
                            alt={imageAlt || __('Team collaborating on blueprints', 'suburbancm')}
                            className="rounded-lg shadow-md w-full object-cover"
                        />
                    </div>
                </div>
            </section>
        </>
    );
};

export default Edit;