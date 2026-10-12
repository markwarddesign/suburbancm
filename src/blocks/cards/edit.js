import { __ } from '@wordpress/i18n';
import { RichText, useBlockProps } from '@wordpress/block-editor';
import { Button, Dropdown, PanelBody } from '@wordpress/components';
import { InspectorControls } from '@wordpress/block-editor';
import { Fragment } from '@wordpress/element';

const iconOptions = [
    { label: __('Helmet', 'suburbancm'), value: 'fa-solid fa-helmet-safety' },
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
    // ...add more as needed
];

const MAX_CARDS = 9;

const Edit = (props) => {
    const { attributes, setAttributes } = props;
    const { title = '', cards = [] } = attributes;

    const updateCard = (index, field, value) => {
        const newCards = [...cards];
        newCards[index] = { ...newCards[index], [field]: value };
        setAttributes({ cards: newCards });
    };

    const addCard = () => {
        if (cards.length < MAX_CARDS) {
            setAttributes({
                cards: [
                    ...cards,
                    { icon: '', cardTitle: '', description: '' }
                ]
            });
        }
    };

    const removeCard = (index) => {
        const newCards = [...cards];
        newCards.splice(index, 1);
        setAttributes({ cards: newCards });
    };

    const blockProps = useBlockProps({
        className: 'cards-cards space-y-12 lg:space-y-16 text-[#000000] dark:text-[#e4d198] py-12 px-4 sm:px-6 lg:px-8',
    });

    return (
        <Fragment>
            <InspectorControls>
                <PanelBody title={__('Cards', 'suburbancm')} initialOpen={true}>
                    <Button
                        isPrimary
                        onClick={addCard}
                        disabled={cards.length >= MAX_CARDS}
                        style={{ marginBottom: 12 }}
                    >
                        {__('Add Card', 'suburbancm')}
                    </Button>
                </PanelBody>
            </InspectorControls>
            <div {...blockProps}>
                <div className="cards-cards__content">
                    <RichText
                        tagName="h3"
                        className="text-2xl font-semibold text-[#a38f50] dark:text-[#e4d198] mb-6 text-center md:text-left"
                        placeholder={__('Section Title…', 'suburbancm')}
                        value={title}
                        onChange={(val) => setAttributes({ title: val })}
                    />
                    <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        {cards.map((card, i) => (
                            <div key={i} className="bg-[#f6f5ec] dark:bg-[#1f1f1f] p-6 rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300 relative">
                                {/* Top-right controls */}
                                <div className="absolute top-2 right-2 flex space-x-2 z-20">
                                    <Dropdown
                                        renderToggle={({ isOpen, onToggle }) => (
                                            <Button
                                                icon="admin-generic"
                                                label={__('Select Icon', 'suburbancm')}
                                                onClick={onToggle}
                                                aria-expanded={isOpen}
                                                className="!text-white !bg-transparent !border-none"
                                                style={{ color: '#fff' }}
                                            />
                                        )}
                                        renderContent={() => (
                                            <div
                                                className="bg-white rounded shadow p-2 flex flex-wrap gap-2"
                                                style={{
                                                    minWidth: 220,
                                                    maxHeight: 260,
                                                    overflowY: 'auto'
                                                }}
                                            >
                                                {iconOptions.map((icon) => (
                                                    <Button
                                                        key={icon.value}
                                                        icon={<i className={`${icon.value} text-[#a38f50]`} />}
                                                        label={icon.label}
                                                        onClick={() => updateCard(i, 'icon', icon.value)}
                                                        className={`icon-button ${card.icon === icon.value ? 'ring-2 ring-[#a38f50]' : ''}`}
                                                        style={{ color: '#a38f50', background: '#fff', border: 'none' }}
                                                    />
                                                ))}
                                            </div>
                                        )}
                                    />
                                    <Button
                                        isDestructive
                                        onClick={() => removeCard(i)}
                                        icon="no-alt"
                                        label={__('Remove', 'suburbancm')}
                                        className="!text-white !bg-transparent !border-none"
                                        style={{ zIndex: 10, color: '#fff' }}
                                    />
                                </div>
                                <div className="flex items-center justify-center w-12 h-12 rounded-full bg-[#a38f50]/20 dark:bg-[#e4d198]/20 mb-4">
                                    {card.icon && (
                                        <i className={`${card.icon} text-[#a38f50] dark:text-[#e4d198]`} aria-hidden="true"></i>
                                    )}
                                </div>
                                <RichText
                                    tagName="h4"
                                    className="text-xl font-semibold text-[#000000] dark:text-white mb-2"
                                    placeholder={__('Card Title…', 'suburbancm')}
                                    value={card.cardTitle}
                                    onChange={(val) => updateCard(i, 'cardTitle', val)}
                                    allowedFormats={[]}
                                />
                                <RichText
                                    tagName="p"
                                    className="text-sm text-[#80703a] dark:text-[#cccccc] leading-relaxed"
                                    placeholder={__('Card description…', 'suburbancm')}
                                    value={card.description}
                                    onChange={(val) => updateCard(i, 'description', val)}
                                    allowedFormats={[]}
                                />
                            </div>
                        ))}
                    </div>
                    {cards.length < MAX_CARDS && (
                        <div className="flex justify-center mt-6">
                            <Button isPrimary onClick={addCard}>
                                {__('Add Card', 'suburbancm')}
                            </Button>
                        </div>
                    )}
                </div>
            </div>
        </Fragment>
    );
};

export default Edit;