import { __ } from '@wordpress/i18n';
import {
    useBlockProps,
    InspectorControls,
    RichText,
} from '@wordpress/block-editor';
import { PanelBody, Button, TextControl, Dropdown } from '@wordpress/components';
import { Fragment } from '@wordpress/element';

export default function Edit({ attributes, setAttributes }) {
    const { title, description, items, buttonText, buttonLink } = attributes;

    const blockProps = useBlockProps({
        className: 'why-choose-us-editor relative z-1 w-full flex flex-col items-center justify-center text-center py-20 px-4 sm:px-6 lg:px-8 z-10 bg-[#f6f5ec] text-[#000000] dark:bg-[#1f1f1f] dark:text-[#e4d198] antialiased',
    });

    const fontAwesomeIcons = [
        { label: __('Select Icon', 'suburbancm'), value: '' },
        { label: __('Helmet', 'suburbancm'), value: 'fa-solid fa-helmet-safety' },
        { label: 'Shield', value: 'fa-solid fa-shield-alt' },
        { label: 'Comments', value: 'fa-solid fa-comments' },
        { label: 'Coins', value: 'fa-solid fa-coins' },
        { label: 'Signature', value: 'fa-solid fa-file-signature' },
        { label: 'Chart', value: 'fa-solid fa-chart-line' },
        { label: 'Users', value: 'fa-solid fa-users' },
        { label: 'Calendar', value: 'fa-solid fa-calendar-check' },
        { label: 'Cubes', value: 'fa-solid fa-cubes' },
        { label: 'Building', value: 'fa-solid fa-building' },
        { label: 'Lightbulb', value: 'fa-solid fa-lightbulb' },
        { label: 'Star', value: 'fa-solid fa-star' },
        { label: 'Heart', value: 'fa-solid fa-heart' },
        { label: 'Check', value: 'fa-solid fa-check' },
        { label: 'Rocket', value: 'fa-solid fa-rocket' },
        { label: 'Bolt', value: 'fa-solid fa-bolt' },
        { label: 'Leaf', value: 'fa-solid fa-leaf' },
        { label: 'Globe', value: 'fa-solid fa-globe' },
        { label: 'Phone', value: 'fa-solid fa-phone' },
        { label: 'Envelope', value: 'fa-solid fa-envelope' },
        { label: 'Map', value: 'fa-solid fa-map' },
        { label: 'Clock', value: 'fa-solid fa-clock' },
        { label: 'Bell', value: 'fa-solid fa-bell' },
        { label: 'Thumbs Up', value: 'fa-solid fa-thumbs-up' },
        { label: 'User', value: 'fa-solid fa-user' },
        { label: 'Lock', value: 'fa-solid fa-lock' },
        { label: 'Unlock', value: 'fa-solid fa-unlock' },
        { label: 'Camera', value: 'fa-solid fa-camera' },
        { label: 'Image', value: 'fa-solid fa-image' },
        { label: 'Music', value: 'fa-solid fa-music' },
        { label: 'Gift', value: 'fa-solid fa-gift' },
        { label: 'Trophy', value: 'fa-solid fa-trophy' },
        { label: 'Medal', value: 'fa-solid fa-medal' },
        { label: 'Flag', value: 'fa-solid fa-flag' },
        { label: 'Fire', value: 'fa-solid fa-fire' },
        { label: 'Gem', value: 'fa-solid fa-gem' },
        { label: 'Smile', value: 'fa-solid fa-smile' },
        { label: 'Sun', value: 'fa-solid fa-sun' },
        { label: 'Moon', value: 'fa-solid fa-moon' },
        { label: 'Cloud', value: 'fa-solid fa-cloud' },
        { label: 'Snowflake', value: 'fa-solid fa-snowflake' },
        { label: 'Apple', value: 'fa-brands fa-apple' },
        { label: 'Android', value: 'fa-brands fa-android' },
    ];

    const addItem = () => {
        if (items.length < 6) {
            setAttributes({
                items: [
                    ...items,
                    {
                        icon: 'fa-star',
                        title: 'New Item Title',
                        description: 'New Item Description',
                    },
                ],
            });
        }
    };

    const updateItem = (index, key, value) => {
        const newItems = [...items];
        newItems[index][key] = value;
        setAttributes({ items: newItems });
    };

    const removeItem = (index) => {
        const newItems = [...items];
        newItems.splice(index, 1);
        setAttributes({ items: newItems });
    };

    /* Set Defaults */
    if (!items || items.length === 0) {
        setAttributes({
            items: [
                {
                    icon: 'fa-star',
                    title: 'Item Title',
                    description: 'Item Description',
                },
                {
                    icon: 'fa-shield-alt',
                    title: 'Item Title',
                    description: 'Item Description',
                },
                {
                    icon: 'fa-thumbs-up',
                    title: 'Item Title',
                    description: 'Item Description',
                },
            ],
        });
    }

    return (
        <Fragment>
            <InspectorControls>
                <PanelBody title={__('Repeater Items', 'suburbancm')}>
                    <Button
                        isPrimary
                        onClick={addItem}
                        disabled={items.length >= 6}
                    >
                        {__('Add Item', 'suburbancm')}
                    </Button>
                </PanelBody>
                <PanelBody title={__('Button Settings', 'suburbancm')} initialOpen={true}>
                    <TextControl
                        label={__('Button Text', 'suburbancm')}
                        value={buttonText}
                        onChange={(val) => setAttributes({ buttonText: val })}
                        placeholder={__('Enter button text...', 'suburbancm')}
                    />
                    <TextControl
                        label={__('Button Link', 'suburbancm')}
                        value={buttonLink}
                        onChange={(val) => setAttributes({ buttonLink: val })}
                        placeholder={__('Enter button link...', 'suburbancm')}
                    />
                </PanelBody>
            </InspectorControls>

            <section {...blockProps}>
                <div className="max-w-7xl mx-auto px-6 lg:px-8 py-20">
                    <div className="max-w-3xl mx-auto text-center mb-12 lg:mb-16">
                        <RichText
                            tagName="h2"
                            value={title}
                            onChange={(val) => setAttributes({ title: val })}
                            placeholder={__('Enter title...', 'suburbancm')}
                            className="text-3xl font-extrabold text-white sm:text-4xl"
                        />
                        <RichText
                            tagName="p"
                            value={description}
                            onChange={(val) => setAttributes({ description: val })}
                            placeholder={__('Enter description...', 'suburbancm')}
                            className="mt-4 text-lg text-[#80703a] dark:text-[#e4d198]/80"
                        />
                    </div>

                    <div className="features grid grid-cols-1 md:grid-cols-3 gap-8 lg:gap-12">
                        {(items || []).map((item, index) => (
                            <div key={index} className="relative feature-item text-center rounded-md shadow-sm bg-white dark:bg-[#1f1f1f] group">
                                {/* Top-right controls */}
                                <div className="absolute top-2 right-2 flex space-x-2 text-white border-1 border-dotted">
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
                                                        onClick={() => updateItem(index, 'icon', icon.value)}
                                                        className="icon-button"
                                                    />
                                                ))}
                                            </div>
                                        )}
                                    />
                                    <Button
                                        icon="trash"
                                        label={__('Remove Item', 'suburbancm')}
                                        onClick={() => removeItem(index)}
                                        className="delete-button text-white"
                                    />
                                </div>

                                {/* Icon Preview */}
                                <div className="icon-preview inline-flex items-center justify-center p-3 bg-[#e4d198]/50 dark:bg-[#a38f50]/30 rounded-full mb-4">
                                    {item.icon && <i className={`fas ${item.icon} text-3xl text-[#a38f50] dark:text-[#e4d198]`}></i>}
                                </div>

                                {/* Title */}
                                <RichText
                                    tagName="h4"
                                    value={item.title}
                                    onChange={(val) => updateItem(index, 'title', val)}
                                    placeholder={__('Enter item title...', 'suburbancm')}
                                    className="text-xl font-semibold text-[#000000] dark:text-white mb-2"
                                />

                                {/* Description */}
                                <RichText
                                    tagName="p"
                                    value={item.description}
                                    onChange={(val) => updateItem(index, 'description', val)}
                                    placeholder={__('Enter item description...', 'suburbancm')}
                                    className="text-sm text-[#80703a] dark:text-[#cccccc] leading-relaxed"
                                />
                            </div>
                        ))}
                    </div>

                    {/* CTA Button */}
                    {buttonText && (
                        <div className="mt-16 text-center">
                            <Button
                                href={buttonLink || '#'}
                                className="btn secondary-inverse"
                            >
                                {buttonText}
                            </Button>
                        </div>
                    )}
                </div>
            </section>
        </Fragment>
    );
}