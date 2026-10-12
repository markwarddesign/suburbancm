import { __ } from '@wordpress/i18n';
import { RichText, MediaUpload, useBlockProps } from '@wordpress/block-editor';
import { Button } from '@wordpress/components';

const Edit = ({ attributes, setAttributes }) => {
    const { title, testimonials } = attributes;

    const blockProps = useBlockProps({
        className: 'suburbancm-testimonials relative z-1 w-full flex flex-col items-center justify-center text-center py-20 px-4 sm:px-6 lg:px-8 z-10 bg-[#f6f5ec] text-[#000000] dark:bg-[#1f1f1f] dark:text-[#e4d198] antialiased',
    });

    const updateTestimonial = (index, key, value) => {
        const updatedTestimonials = [...testimonials];
        updatedTestimonials[index][key] = value;
        setAttributes({ testimonials: updatedTestimonials });
    };

    const addTestimonial = () => {
        setAttributes({
            testimonials: [
                ...testimonials,
                {
                    image: '',
                    alt: '',
                    quote: '',
                    name: '',
                    role: '',
                },
            ],
        });
    };

    const removeTestimonial = (index) => {
        const updatedTestimonials = [...testimonials];
        updatedTestimonials.splice(index, 1);
        setAttributes({ testimonials: updatedTestimonials });
    };

    return (
        <section {...blockProps}>
            <div className="w-full max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
                <h2 className='text-3xl font-bold text-center text-white'>
                    <RichText
                        tagName="span"
                        className=""
                        placeholder={__('Enter title…', 'suburbancm')}
                        value={title}
                        onChange={(newTitle) => setAttributes({ title: newTitle })}
                    />
                </h2>
                
                <div className="space-y-8 mt-12">
                    {testimonials.map((testimonial, index) => (
                        <div
                            key={index}
                            className="testimony relative group bg-[#ffffff] dark:bg-[#2a2a2a] p-6 rounded-lg shadow-md text-center"
                        >
                            {/* Hover Controls */}
                            <div className="absolute top-2 right-2 flex space-x-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                <MediaUpload
                                    onSelect={(media) =>
                                        updateTestimonial(index, 'image', media.url)
                                    }
                                    allowedTypes={['image']}
                                    render={({ open }) => (
                                        <Button
                                            icon="format-image"
                                            label={__('Select Image', 'suburbancm')}
                                            onClick={open}
                                            className="text-white bg-[#a38f50] hover:bg-[#80703a] dark:bg-[#e4d198] dark:hover:bg-[#a38f50] rounded-full p-2"
                                        />
                                    )}
                                />
                                <Button
                                    icon="trash"
                                    label={__('Remove Testimonial', 'suburbancm')}
                                    onClick={() => removeTestimonial(index)}
                                    className="text-white bg-red-500 hover:bg-red-600 rounded-full p-2"
                                />
                            </div>

                            {/* Testimonial Content */}
                            {testimonial.image && (
                                <img
                                    src={testimonial.image}
                                    alt={testimonial.alt}
                                    className="w-20 h-20 rounded-full mx-auto mb-4 border-2 border-[#a38f50] dark:border-[#e4d198] overflow-hidden"
									style={ {
										aspectRatio: '1 / 1',
										borderRadius: '50%',
										border: '2px solid #a38f50',
										overflow: 'hidden',
										objectFit: 'cover',
									}
									}
                                />
                            )}
                            <RichText
                                tagName="blockquote"
                                className="text-[#80703a] dark:text-[#e4d198]/80 italic mb-4"
                                placeholder={__('Enter quote…', 'suburbancm')}
                                value={testimonial.quote}
                                onChange={(newQuote) =>
                                    updateTestimonial(index, 'quote', newQuote)
                                }
                            />
                            <RichText
                                tagName="p"
                                className="font-semibold text-[#000000] dark:text-[#ffffff]"
                                placeholder={__('Enter name…', 'suburbancm')}
                                value={testimonial.name}
                                onChange={(newName) =>
                                    updateTestimonial(index, 'name', newName)
                                }
                            />
                            <RichText
                                tagName="p"
                                className="text-sm text-[#80703a] dark:text-[#e4d198]/70"
                                placeholder={__('Enter role…', 'suburbancm')}
                                value={testimonial.role}
                                onChange={(newRole) =>
                                    updateTestimonial(index, 'role', newRole)
                                }
                            />
                        </div>
                    ))}
                    <Button isPrimary onClick={addTestimonial} className="mt-4">
                        {__('Add Testimonial', 'suburbancm')}
                    </Button>
                </div>
            </div>
        </section>
    );
};

export default Edit;