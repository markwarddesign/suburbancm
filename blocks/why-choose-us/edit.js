import { __ } from '@wordpress/i18n';
import {
    useBlockProps,
    RichText,
    InspectorControls,
    URLInput,
} from '@wordpress/block-editor';
import {
    PanelBody,
    TextControl,
    TextareaControl,
    SelectControl,
} from '@wordpress/components';
import { Fragment } from '@wordpress/element';

import './editor.css';

const icons = {
    info: (
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth="1.5" stroke="currentColor">
            <path strokeLinecap="round" strokeLinejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
        </svg>
    ),
    checkmark: (
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth="1.5" stroke="currentColor">
            <path strokeLinecap="round" strokeLinejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
        </svg>
    ),
    clipboard: (
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth="1.5" stroke="currentColor">
            <path strokeLinecap="round" strokeLinejoin="round" d="M12 20.25c4.97 0 9-3.694 9-8.25s-4.03-8.25-9-8.25S3 7.056 3 11.75c0 4.556 4.03 8.25 9 8.25Z" />
            <path strokeLinecap="round" strokeLinejoin="round" d="M7.5 8.25h9m-9 3H12m-5.25 3h9" />
        </svg>
    ),
};

export default function Edit({ attributes, setAttributes }) {
    const blockProps = useBlockProps();
    const { heading, subheading, features, buttonText, buttonLink } = attributes;

    const updateFeature = (index, key, value) => {
        const newFeatures = [...features];
        newFeatures[index] = {
            ...newFeatures[index],
            [key]: value,
        };
        setAttributes({ features: newFeatures });
    };

    return (
        <Fragment>
            <InspectorControls>
                <PanelBody title={__('Button Settings', 'suburbancm')}>
                    <label
                        className="components-base-control__label"
                        htmlFor="why-choose-us-button-url-input"
                    >
                        {__('Button Link', 'suburbancm')}
                    </label>
                    <URLInput
                        value={buttonLink}
                        onChange={(value) => setAttributes({ buttonLink: value })}
                        id="why-choose-us-button-url-input"
                    />
                </PanelBody>
                <PanelBody
                    title={__('Feature Content', 'suburbancm')}
                    initialOpen={false}
                >
                    {features.map((feature, index) => (
                        <div
                            key={index}
                            style={{
                                marginBottom: '1em',
                                paddingBottom: '1em',
                                borderBottom: '1px solid #ccc',
                            }}
                        >
                            <TextControl
                                label={`${__('Feature', 'suburbancm')} ${index + 1} ${__('Title', 'suburbancm')}`}
                                value={feature.title}
                                onChange={(value) => updateFeature(index, 'title', value)}
                            />
                            <TextareaControl
                                label={`${__('Feature', 'suburbancm')} ${index + 1} ${__('Description', 'suburbancm')}`}
                                value={feature.description}
                                onChange={(value) => updateFeature(index, 'description', value)}
                            />
                            <SelectControl
                                label={`${__('Feature', 'suburbancm')} ${index + 1} ${__('Icon', 'suburbancm')}`}
                                value={feature.icon}
                                options={[
                                    { label: __('Info', 'suburbancm'), value: 'info' },
                                    { label: __('Checkmark', 'suburbancm'), value: 'checkmark' },
                                    { label: __('Clipboard', 'suburbancm'), value: 'clipboard' },
                                ]}
                                onChange={(value) => updateFeature(index, 'icon', value)}
                            />
                        </div>
                    ))}
                </PanelBody>
            </InspectorControls>

            <section {...blockProps}>
                <div className="why-choose-us-editor-container">
                    <div className="why-choose-us-header">
                        <RichText
                            tagName="h2"
                            value={heading}
                            onChange={(value) => setAttributes({ heading: value })}
                            placeholder={__('Enter heading…', 'suburbancm')}
                            className="why-choose-us-heading"
                        />
                        <RichText
                            tagName="p"
                            value={subheading}
                            onChange={(value) => setAttributes({ subheading: value })}
                            placeholder={__('Enter subheading…', 'suburbancm')}
                            className="why-choose-us-subheading"
                        />
                    </div>

                    <div className="why-choose-us-features-grid">
                        {features.map((feature, index) => (
                            <div
                                key={index}
                                className="why-choose-us-feature-item"
                            >
                                <div className="why-choose-us-icon-wrapper">
                                    <div className="why-choose-us-icon">
                                        {icons[feature.icon] || icons.info}
                                    </div>
                                </div>
                                <RichText
                                    tagName="h4"
                                    value={feature.title}
                                    onChange={(value) => updateFeature(index, 'title', value)}
                                    placeholder={__('Feature title…', 'suburbancm')}
                                    className="why-choose-us-feature-title"
                                />
                                <RichText
                                    tagName="p"
                                    value={feature.description}
                                    onChange={(value) => updateFeature(index, 'description', value)}
                                    placeholder={__('Feature description…', 'suburbancm')}
                                    className="why-choose-us-feature-description"
                                />
                            </div>
                        ))}
                    </div>

                    <div className="why-choose-us-cta">
                        <RichText
                            tagName="a"
                            value={buttonText}
                            onChange={(value) => setAttributes({ buttonText: value })}
                            placeholder={__('Button text…', 'suburbancm')}
                            className="why-choose-us-button"
                            onClick={(event) => event.preventDefault()}
                            href={buttonLink}
                        />
                    </div>
                </div>
            </section>
        </Fragment>
    );
}