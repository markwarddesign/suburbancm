import { __ } from '@wordpress/i18n';
import { useBlockProps, RichText, MediaUpload, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, Button, TextareaControl, IconButton, SelectControl } from '@wordpress/components';
import { Fragment } from '@wordpress/element';

const ICON_OPTIONS = [
    { label: __('Circle Check', 'suburbancm'), value: 'fa-circle-check' },
    { label: __('Square Check', 'suburbancm'), value: 'fa-square-check' },
    { label: __('Circle', 'suburbancm'), value: 'fa-circle' },
    { label: __('Star', 'suburbancm'), value: 'fa-star' },
    { label: __('Arrow Right', 'suburbancm'), value: 'fa-circle-right' },
    { label: __('Clipboard', 'suburbancm'), value: 'fa-clipboard' },
    { label: __('Calendar Check', 'suburbancm'), value: 'fa-calendar-check' },
    { label: __('Clock', 'suburbancm'), value: 'fa-clock' },
    { label: __('Hand Point Right', 'suburbancm'), value: 'fa-hand-point-right' },
    { label: __('Gem', 'suburbancm'), value: 'fa-gem' },

];

export default function Edit({ attributes, setAttributes }) {
    const { title, description, services = [], bulletIcon = 'fa-circle-check' } = attributes;

    const updateservice = (index, key, value) => {
        const newservices = [...services];
        newservices[index][key] = value;
        setAttributes({ services: newservices });
    };

    const removeservice = (index) => {
        const newservices = [...services];
        newservices.splice(index, 1);
        setAttributes({ services: newservices });
    };

    const addservice = () => {
        const newservices = [
            ...(services || []),
            {
                image: '', // <-- empty so MediaUpload button shows
                alt: '',
                title: '',
                description: '',
                features: [''],
            },
        ];
        setAttributes({ services: newservices });
    };

    const updateFeature = (serviceIndex, featureIndex, value) => {
        const newservices = [...services];
        newservices[serviceIndex].features[featureIndex] = value;
        setAttributes({ services: newservices });
    };

    const removeFeature = (serviceIndex, featureIndex) => {
        const newservices = [...services];
        newservices[serviceIndex].features.splice(featureIndex, 1);
        setAttributes({ services: newservices });
    };

    const addFeature = (serviceIndex) => {
        const newservices = [...services];
        newservices[serviceIndex].features.push('');
        setAttributes({ services: newservices });
    };

    const blockProps = useBlockProps({
        className: 'py-12 dark:bg-[#1f1f1f] sm:py-16 lg:py-20 overflow-hidden',
    });

    return (
        <Fragment>
            <InspectorControls>
                <PanelBody title={__('Section Settings', 'suburbancm')}>
                    <TextareaControl
                        label={__('Section Description', 'suburbancm')}
                        value={description}
                        onChange={(value) => setAttributes({ description: value })}
                    />
                    <SelectControl
                        label={__('Bullet Icon', 'suburbancm')}
                        value={bulletIcon}
                        options={ICON_OPTIONS}
                        onChange={(value) => setAttributes({ bulletIcon: value })}
                        help={__('Select the Font Awesome icon for all service features.', 'suburbancm')}
                    />
                </PanelBody>
            </InspectorControls>
            <section {...blockProps}>
                <div className="container mx-auto px-4 sm:px-6 lg:px-8 text-white py-20">
                    <div className="text-center mb-12">
                        <RichText
                            tagName="h2"
                            value={title}
                            onChange={(value) => setAttributes({ title: value })}
                            placeholder={__('Enter section title...', 'suburbancm')}
                            className="text-3xl font-bold tracking-tight text-white sm:text-4xl"
                        />
                        <RichText
                            tagName="p"
                            value={description}
                            onChange={(value) => setAttributes({ description: value })}
                            placeholder={__('Enter section description...', 'suburbancm')}
                            className="mt-4 text-lg text-[#80703a] dark:text-[#e4d198]/80"
                        />
                    </div>
                    {services.map((service, index) => (
                        <div key={index} className="flex flex-col md:flex-row items-center bg-[#2a2a2a] rounded-lg shadow-xl overflow-hidden mb-12 relative group">
                            <div className="absolute top-6 right-5 z-10 opacity-80 group-hover:opacity-100">
                                <IconButton
                                    icon="trash"
                                    label={__('Remove Service', 'suburbancm')}
                                    onClick={() => removeservice(index)}
                                    className="!text-white !rounded-full"
                                />
                            </div>
                            <div className="w-full md:w-1/3 flex-shrink-0 overflow-hidden relative">
                                <MediaUpload
                                    onSelect={(media) => updateservice(index, 'image', media.url)}
                                    value={service.image}
                                    allowedTypes={['image']}
                                    render={({ open }) => (
                                        <Button onClick={open} className="button">
                                            {__('Select Image', 'suburbancm')}
                                        </Button>
                                    )}
                                    className="ainset-0 w-full h-full bg-gray-200 flex items-center justify-center"
                                />
                                <img
                                    src={service.image || 'https://dummyimage.com/600x400/a38f50/ffffff?text=Planning'}
                                    alt={service.alt}
                                    className="w-full h-64 md:h-full object-cover"
                                />
                            </div>
                            <div className="w-full md:w-2/3 p-6 md:p-8">
                                <RichText
                                    tagName="h3"
                                    value={service.title}
                                    onChange={(value) => updateservice(index, 'title', value)}
                                    placeholder={__('Enter service title...', 'suburbancm')}
                                    className="text-2xl font-semibold text-white mb-3"
                                />
                                <RichText
                                    tagName="p"
                                    value={service.description}
                                    onChange={(value) => updateservice(index, 'description', value)}
                                    placeholder={__('Enter service description...', 'suburbancm')}
                                    className="text-gray-300 mb-5"
                                />
                                <div className="space-y-3">
                                    {service.features.map((feature, featureIndex) => (
                                        <div key={featureIndex} className="flex items-start gap-2 relative">
                                            <span>
                                                <i className={`far ${bulletIcon} text-[#a38f50] mr-2`} aria-hidden="true"></i>
                                            </span>
                                            <RichText
                                                tagName="span"
                                                value={feature}
                                                onChange={(value) => updateFeature(index, featureIndex, value)}
                                                placeholder={__('Enter feature...', 'suburbancm')}
                                                className="text-gray-300"
                                            />
                                            <IconButton
                                                icon="no-alt"
                                                label={__('Remove Feature', 'suburbancm')}
                                                onClick={() => removeFeature(index, featureIndex)}
                                                className="!text-white !rounded-full !h-6 !w-6 !p-0"
                                                style={{ marginLeft: 4, padding: 5 }}
                                            />
                                        </div>
                                    ))}
                                    <Button
                                        isSecondary
                                        onClick={() => addFeature(index)}
                                        className="mt-2"
                                        style={{ position: 'relative', top: '1em', left: '0', transform: 'none' }}
                                    >
                                        {__('Add Feature', 'suburbancm')}
                                    </Button>
                                </div>
                            </div>
                        </div>
                    ))}
                    <div className="text-center mt-8">
                        <Button
                            isPrimary
                            onClick={addservice}
                            className="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded"
                            style={{ position: 'relative', top: '1em', left: '0', transform: 'none' }}
                        >
                            {__('Add Service', 'suburbancm')}
                        </Button>
                    </div>
                </div>
            </section>
        </Fragment>
    );
}