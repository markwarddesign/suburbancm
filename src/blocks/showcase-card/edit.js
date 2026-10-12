import { __ } from '@wordpress/i18n';
import { useBlockProps, MediaUpload, MediaUploadCheck, RichText } from '@wordpress/block-editor';
import { Button, TextControl, Icon } from '@wordpress/components';
import { image, trash } from '@wordpress/icons';

export default function Edit({ attributes, setAttributes }) {
    const { image: imgUrl, imageAlt, title, text } = attributes;

    const blockProps = useBlockProps({
        className: 'py-16 lg:py-24 bg-[#f6f5ec] dark:bg-[#1f1f1f]'
    });

    return (
        <section id="showcase-card" {...blockProps}>
            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div className="max-w-4xl mx-auto bg-[#ffffff] dark:bg-[#2a2a2a] p-8 md:p-12 rounded-xl shadow-xl animate-on-scroll delay-100">
                    <div className="flex flex-col lg:flex-row items-center text-center lg:text-left">
                        <div className="flex-shrink-0 mb-6 lg:mb-0 lg:mr-10 self-center" style={{ position: 'relative', width: '8rem', height: '8rem', minWidth: '8rem' }}>
                            <MediaUploadCheck>
                                <MediaUpload
                                    onSelect={(media) => setAttributes({ image: media.url, imageAlt: media.alt || '' })}
                                    allowedTypes={['image']}
                                    value={imgUrl}
                                    render={({ open }) => (
                                        <div style={{ position: 'relative', width: '100%', height: '100%' }}>
                                            {imgUrl ? (
                                                <div style={{ position: 'relative', width: '100%', height: '100%' }}>
                                                    <img
                                                        src={imgUrl}
                                                        alt={imageAlt}
                                                        className="rounded-full object-cover shadow-md"
                                                        style={{
                                                            width: '100%',
                                                            height: '100%',
                                                            minWidth: '6rem',
                                                            minHeight: '6rem',
                                                            maxWidth: '8rem',
                                                            maxHeight: '8rem',
                                                            aspectRatio: '1/1',
                                                            objectFit: 'cover',
                                                            borderRadius: '9999px',
                                                            boxShadow: '0 2px 8px 0 rgba(0,0,0,0.18)',
                                                            margin: '0 auto',
                                                            display: 'block',
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
                                                                <Icon icon={image} style={{ fill: '#fff', width: 18, height: 18 }} />
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
                                                                <Icon icon={trash} style={{ fill: '#fff', width: 18, height: 18 }} />
                                                                {__('Remove', 'suburbancm')}
                                                            </Button>
                                                        </div>
                                                    </div>
                                                </div>
                                            ) : (
                                                <div style={{
                                                    position: 'relative',
                                                    width: '8rem',
                                                    height: '8rem',
                                                    background: '#232323',
                                                    borderRadius: '9999px',
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
                        <div className="flex-1">
                            <RichText
                                tagName="h2"
                                className="text-3xl md:text-4xl font-semibold text-[#a38f50] dark:text-[#e4d198] mb-4"
                                placeholder={__('Title here…', 'suburbancm')}
                                value={title}
                                onChange={(newTitle) => setAttributes({ title: newTitle })}
                            />
                            <RichText
                                tagName="p"
                                className="text-lg md:text-xl text-[#000000] dark:text-[#e4d198]/90 leading-relaxed"
                                placeholder={__('Enter showcase text…', 'suburbancm')}
                                value={text}
                                onChange={(val) => setAttributes({ text: val })}
                            />
                        </div>
                    </div>
                </div>
            </div>
        </section>
    );
}