import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls, RichText } from '@wordpress/block-editor';
import { PanelBody, TextControl, Button, Dropdown } from '@wordpress/components';

const Edit = ({ attributes, setAttributes }) => {
    const { title, title1, description1, link1, linkText1, icon1, title2, description2, link2, linkText2, icon2 } = attributes;

    const fontAwesomeIcons = [
        { label: __('Select Icon', 'suburbancm'), value: '' },
        { label: __('Star', 'suburbancm'), value: 'fa-star' },
        { label: __('Shield', 'suburbancm'), value: 'fa-shield-alt' },
        { label: __('Thumbs Up', 'suburbancm'), value: 'fa-thumbs-up' },
        { label: __('Check Circle', 'suburbancm'), value: 'fa-check-circle' },
        { label: __('Heart', 'suburbancm'), value: 'fa-heart' },
        { label: __('Lightbulb', 'suburbancm'), value: 'fa-lightbulb' },
        { label: __('Rocket', 'suburbancm'), value: 'fa-rocket' },
        { label: __('Users', 'suburbancm'), value: 'fa-users' },
        { label: __('Cog', 'suburbancm'), value: 'fa-cog' },
        { label: __('Globe', 'suburbancm'), value: 'fa-globe' },
        { label: __('Calendar', 'suburbancm'), value: 'fa-calendar' },
        { label: __('Clock', 'suburbancm'), value: 'fa-clock' },
        { label: __('Map', 'suburbancm'), value: 'fa-map' },
        { label: __('Phone', 'suburbancm'), value: 'fa-phone' },
        { label: __('Envelope', 'suburbancm'), value: 'fa-envelope' },
    ];

    const blockProps = useBlockProps({
        className: 'suburbancm-additional-actions',
    });

    const updateIcon = (action, value) => {
        if (action === 'first') {
            setAttributes({ icon1: value });
        } else if (action === 'second') {
            setAttributes({ icon2: value });
        }
    };

    return (
        <>
            <InspectorControls>
                <PanelBody title={__('First Action Settings', 'suburbancm')} initialOpen={true}>
                    <TextControl
                        label={__('Button Text', 'suburbancm')}
                        value={linkText1}
                        onChange={(value) => setAttributes({ linkText1: value })}
                        placeholder={__('Enter button text…', 'suburbancm')}
                    />
                    <TextControl
                        label={__('Button URL', 'suburbancm')}
                        value={link1}
                        onChange={(value) => setAttributes({ link1: value })}
                        placeholder={__('Enter button URL…', 'suburbancm')}
                    />
                </PanelBody>
                <PanelBody title={__('Second Action Settings', 'suburbancm')} initialOpen={false}>
                    <TextControl
                        label={__('Button Text', 'suburbancm')}
                        value={linkText2}
                        onChange={(value) => setAttributes({ linkText2: value })}
                        placeholder={__('Enter button text…', 'suburbancm')}
                    />
                    <TextControl
                        label={__('Button URL', 'suburbancm')}
                        value={link2}
                        onChange={(value) => setAttributes({ link2: value })}
                        placeholder={__('Enter button URL…', 'suburbancm')}
                    />
                </PanelBody>
            </InspectorControls>
            <div {...blockProps}>
                <section
                    aria-labelledby="additional-actions-heading"
                    className="pt-12 pb-16 bg-[#1f1f1f] overflow-hidden"
                >
                    <div className="container mx-auto px-4 sm:px-6 lg:px-8">
						<div className="text-center mb-12">
							<RichText
								tagName="h2"
								id="additional-actions-heading"
								className="text-3xl font-bold text-center text-white sm:text-4xl"
								value={title}
								onChange={(value) => setAttributes({ title: value })}
								placeholder={__('Enter section title…', 'suburbancm')}
							/>
						</div>
                        <div className="actions flex flex-col md:flex-row md:space-x-8 space-y-8 md:space-y-0">
                            {/* First Action */}
                            <div className="action-item md:w-1/2 bg-[#a38f50] rounded-lg shadow-xl p-6 text-center flex flex-col items-center relative">
                                {/* Inline Icon Editing */}
                                <div className="absolute top-2 right-2 flex space-x-2 text-white">
                                    <Dropdown
                                        contentClassName="icon-dropdown wide-dropdown"
                                        renderToggle={({ isOpen, onToggle }) => (
                                            <Button
                                                icon="admin-generic"
                                                label={__('Select Icon', 'suburbancm')}
                                                onClick={onToggle}
                                                aria-expanded={isOpen}
                                                className="text-white"
                                            />
                                        )}
                                        renderContent={() => (
                                            <div>
                                                {fontAwesomeIcons.map((icon) => (
                                                    <Button
                                                        key={icon.value}
                                                        icon={<i className={`fas ${icon.value}`}></i>}
                                                        label={icon.label}
                                                        onClick={() => updateIcon('first', icon.value)}
                                                        className="icon-button"
                                                    />
                                                ))}
                                            </div>
                                        )}
                                    />
                                </div>
                                <i className={`fas ${icon1} w-12 h-12 text-[#2a2a2a] mb-4 text-4xl`}></i>
								<RichText
									tagName="span"
									className="text-xl font-semibold text-white mb-2"
									value={title1}
									onChange={(value) => setAttributes({ title1: value })}
									placeholder={__('Enter title…', 'suburbancm')}
								/>
								<RichText
									tagName="span"
									className="text-white mb-5 flex-grow"
									value={description1}
									onChange={(value) => setAttributes({ description1: value })}
									placeholder={__('Enter description…', 'suburbancm')}
								/>
								<Button
									href={link1}
									className="btn secondary"
									target="_blank"
									rel="noopener noreferrer"
								>
									{linkText1 || __('Learn More', 'suburbancm')}
								</Button>
                            </div>

                            {/* Second Action */}
                            <div className="action-item md:w-1/2 bg-[#2a2a2a] rounded-lg shadow-xl p-6 text-center flex flex-col items-center relative">
                                {/* Inline Icon Editing */}
                                <div className="absolute top-2 right-2 flex space-x-2 text-white">
                                    <Dropdown
                                        contentClassName="icon-dropdown wide-dropdown"
                                        renderToggle={({ isOpen, onToggle }) => (
                                            <Button
                                                icon="admin-generic"
                                                label={__('Select Icon', 'suburbancm')}
                                                onClick={onToggle}
                                                aria-expanded={isOpen}
                                                className="text-white"
                                            />
                                        )}
                                        renderContent={() => (
                                            <div>
                                                {fontAwesomeIcons.map((icon) => (
                                                    <Button
                                                        key={icon.value}
                                                        icon={<i className={`fas ${icon.value}`}></i>}
                                                        label={icon.label}
                                                        onClick={() => updateIcon('second', icon.value)}
                                                        className="icon-button"
                                                    />
                                                ))}
                                            </div>
                                        )}
                                    />
                                </div>
                                <i className={`fas ${icon2} w-12 h-12 text-[#a38f50] mb-4 text-4xl`}></i>
								<RichText
									tagName="span"
									className="text-xl font-semibold text-white mb-2"
									value={title2}
									onChange={(value) => setAttributes({ title2: value })}
									placeholder={__('Enter title…', 'suburbancm')}
								/>
								<RichText
									tagName="span"
									className="text-white mb-5 flex-grow"
									value={description2}
									onChange={(value) => setAttributes({ description2: value })}
									placeholder={__('Enter description…', 'suburbancm')}
								/>
								<Button
									href={link2}
									className="btn secondary"
									target="_blank"
									rel="noopener noreferrer"
								>
									{linkText2 || __('Learn More', 'suburbancm')}
								</Button>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </>
    );
};

export default Edit;