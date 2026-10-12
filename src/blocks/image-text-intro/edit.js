import { __ } from '@wordpress/i18n';
import { useBlockProps, MediaUpload, MediaUploadCheck, RichText } from '@wordpress/block-editor';
import { Button, Icon } from '@wordpress/components';
import { image, trash } from '@wordpress/icons';

export default function Edit({ attributes, setAttributes }) {
    const { image: imgUrl, imageAlt, text } = attributes;

    const blockProps = useBlockProps({
        className: 'py-16 lg:py-20 bg-[#ffffff] dark:bg-[#2a2a2a]'
    });

    return (
        <section id="image-text-intro" {...blockProps}>
            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 animate-on-scroll">
                <div className="flex flex-col md:flex-row items-center gap-8 md:gap-12">
                    <div
                        className="md:w-2/5 flex-shrink-0"
                    >
                        <MediaUploadCheck>
                            <MediaUpload
                                onSelect={(media) => setAttributes({ image: media.url, imageAlt: media.alt || '' })}
                                allowedTypes={['image']}
                                value={imgUrl}
                                render={({ open }) => (
                                    <div style={{ position: 'relative' }}>
                                        {imgUrl ? (
                                            <div style={{ marginBottom: 0, position: 'relative' }}>
                                                <img
                                                    src={imgUrl}
                                                    alt={imageAlt}
                                                    className="w-full h-auto rounded-xl shadow-lg object-cover"
                                                    style={{
                                                        width: '100%',
                                                        height: 220,
                                                        objectFit: 'cover',
                                                        borderRadius: 12,
                                                        boxShadow: '0 2px 8px 0 rgba(0,0,0,0.18)',
                                                        margin: '0 auto',
                                                        display: 'block'
                                                    }}
                                                />
                                                {/* Overlayed image controls */}
                                                <div style={{
                                                    position: 'absolute',
                                                    top: 0,
                                                    left: 0,
                                                    width: '100%',
                                                    height: '100%',
                                                    display: 'flex',
                                                    alignItems: 'center',
                                                    justifyContent: 'center',
                                                    gap: 8,
                                                    pointerEvents: 'none',
                                                }}>
                                                    <div style={{ display: 'flex', gap: 8 }}>
                                                        <Button
                                                            onClick={open}
                                                            isSecondary
                                                            size="small"
                                                            style={{
                                                                background: '#000',
                                                                color: '#fff',
                                                                border: 'none',
                                                                pointerEvents: 'auto',
                                                                opacity: 0.85,
                                                                display: 'flex',
                                                                alignItems: 'center',
                                                                gap: 6,
                                                            }}
                                                        >
                                                            <Icon icon={image} style={{ fill: '#fff', width: 20, height: 20 }} />
                                                            {__('Replace', 'suburbancm')}
                                                        </Button>
                                                        <Button
                                                            onClick={() => setAttributes({ image: '', imageAlt: '' })}
                                                            isDestructive
                                                            size="small"
                                                            style={{
                                                                background: '#000',
                                                                color: '#fff',
                                                                border: 'none',
                                                                pointerEvents: 'auto',
                                                                opacity: 0.85,
                                                                display: 'flex',
                                                                alignItems: 'center',
                                                                gap: 6,
                                                            }}
                                                        >
                                                            <Icon icon={trash} style={{ fill: '#fff', width: 20, height: 20 }} />
                                                            {__('Remove', 'suburbancm')}
                                                        </Button>
                                                    </div>
                                                </div>
                                            </div>
                                        ) : (
                                            <div style={{
                                                position: 'relative',
                                                width: '100%',
                                                height: 220,
                                                background: '#232323',
                                                borderRadius: 12,
                                                display: 'flex',
                                                alignItems: 'center',
                                                justifyContent: 'center',
                                            }}>
                                                <Button
                                                    onClick={open}
                                                    isSecondary
                                                    style={{
                                                        background: '#000',
                                                        color: '#fff',
                                                        border: 'none',
                                                        pointerEvents: 'auto',
                                                        opacity: 0.85,
                                                        display: 'flex',
                                                        alignItems: 'center',
                                                        gap: 6,
                                                    }}
                                                >
                                                    <Icon icon={image} style={{ fill: '#fff', width: 22, height: 22 }} />
                                                    {__('Add Image', 'suburbancm')}
                                                </Button>
                                            </div>
                                        )}
                                    </div>
                                )}
                            />
                        </MediaUploadCheck>
                    </div>
                    <div className="md:w-3/5 text-center md:text-left">
                        <RichText
                            tagName="p"
                            className="text-xl md:text-2xl text-[#000000] dark:text-[#e4d198] leading-relaxed font-normal"
                            placeholder={__('Enter intro text…', 'suburbancm')}
                            value={text}
                            onChange={(val) => setAttributes({ text: val })}
                        />
                        <hr className="mt-8 border-t border-[#a38f50]/30 dark:border-[#e4d198]/30 w-24 mx-auto md:mx-0" />
                    </div>
                </div>
            </div>
        </section>
    );
}