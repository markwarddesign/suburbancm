import { __ } from '@wordpress/i18n';
import { RichText, useBlockProps, MediaUpload, MediaUploadCheck } from '@wordpress/block-editor';
import { Button, SelectControl } from '@wordpress/components';
import { useState } from '@wordpress/element';

// List of FontAwesome icons (add more as needed)
const ICON_OPTIONS = [
    { label: __('Shield', 'suburbancm'), value: 'fa-shield-alt' },
    { label: __('Exclamation Triangle', 'suburbancm'), value: 'fa-exclamation-triangle' },
    { label: __('Check Circle', 'suburbancm'), value: 'fa-check-circle' },
    { label: __('Hard Hat', 'suburbancm'), value: 'fa-hard-hat' },
    { label: __('User Shield', 'suburbancm'), value: 'fa-user-shield' },
];

const DEFAULT_IMAGE = 'https://placehold.co/150x150/a38f50/ffffff/png?text=Safety+First';
const DEFAULT_ICON = 'fa-shield-alt';

const DEFAULT_LIST = [
    __('Rigorous adherence to all OSHA standards and local safety regulations.', 'suburbancm'),
    __('Continuous safety training, certifications, and toolbox talks for all personnel.', 'suburbancm'),
    __('Development and implementation of site-specific safety plans tailored to each project.', 'suburbancm'),
    __('Proactive hazard identification, risk assessment, and regular safety audits.', 'suburbancm'),
    __('Fostering a culture where every individual is empowered and responsible for safety.', 'suburbancm'),
];

const Edit = (props) => {
    const { attributes, setAttributes } = props;
    const {
        image = DEFAULT_IMAGE,
        imageAlt = '',
        icon = DEFAULT_ICON,
        title = __('Safety: Our Unwavering Commitment', 'suburbancm'),
        description = __('At SuburbanCM, safety is paramount. It\'s a non-negotiable core value integrated into every phase of our work. We are dedicated to creating and maintaining the safest possible environments for our team, subcontractors, clients, and the communities we serve.', 'suburbancm'),
        list = DEFAULT_LIST,
        afterText = __('Our goal is zero incidents. We firmly believe that a safe project is fundamental to a successful project.', 'suburbancm'),
    } = attributes;

    const blockProps = useBlockProps({
        className: 'suburbancm-callout max-w-7xl mx-auto mt-16 lg:mt-24 p-6 md:p-10 bg-[#e4d198]/30 dark:bg-[#a38f50]/20 rounded-xl shadow-xl animate-on-scroll delay-100 border border-[#a38f50]/30 dark:border-[#e4d198]/30',
    });

    const updateListItem = (idx, value) => {
        const newList = [...list];
        newList[idx] = value;
        setAttributes({ list: newList });
    };

    const addListItem = () => setAttributes({ list: [...list, ''] });
    const removeListItem = (idx) => setAttributes({ list: list.filter((_, i) => i !== idx) });

    return (
        <div {...blockProps}>
            <div className="flex flex-col md:flex-row items-center md:items-start text-center md:text-left">
                <div className="flex-shrink-0 mb-6 md:mb-0 md:mr-8 flex flex-col items-center">
                    <i
                        className={`fas ${icon}`}
                        style={{
                            fontSize: 80,
                            color: '#a38f50',
                            background: '#fff',
                            borderRadius: '50%',
                            width: 128,
                            height: 128,
                            display: 'flex',
                            alignItems: 'center',
                            justifyContent: 'center',
                            boxShadow: '0 2px 8px 0 rgba(0,0,0,0.18)',
                            marginBottom: 16,
                        }}
                        aria-hidden="true"
                    />
                    <SelectControl
                        label={__('Select Icon', 'suburbancm')}
                        value={icon}
                        options={ICON_OPTIONS}
                        onChange={val => setAttributes({ icon: val })}
                        style={{ width: 180 }}
                    />
                </div>
                <div className="flex-1">
                    <RichText
                        tagName="h3"
                        className="text-3xl md:text-4xl font-bold text-[#a38f50] dark:text-[#e4d198] mb-4"
                        value={title}
                        onChange={val => setAttributes({ title: val })}
                        placeholder={__('Callout Title', 'suburbancm')}
                    />
                    <RichText
                        tagName="p"
                        className="text-lg text-[#000000] dark:text-[#e4d198]/90 mb-6 leading-relaxed"
                        value={description}
                        onChange={val => setAttributes({ description: val })}
                        placeholder={__('Callout Description', 'suburbancm')}
                    />
                    <ul className="space-y-3 text-md text-[#80703a] dark:text-[#cccccc] leading-relaxed text-left">
                        {list.map((item, idx) => (
                            <li className="flex items-start" key={idx}>
                                <svg className="flex-shrink-0 h-5 w-5 text-[#a38f50] dark:text-[#e4d198] mr-2 mt-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fillRule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clipRule="evenodd" /></svg>
                                <RichText
                                    tagName="span"
                                    value={item}
                                    onChange={val => updateListItem(idx, val)}
                                    placeholder={__('List item', 'suburbancm')}
                                    style={{ flex: 1 }}
                                />
                                <Button
                                    isDestructive
                                    onClick={() => removeListItem(idx)}
                                    style={{ marginLeft: 8 }}
                                    aria-label={__('Remove list item', 'suburbancm')}
                                >✕</Button>
                            </li>
                        ))}
                        <li>
                            <Button
                                isSecondary
                                onClick={addListItem}
                                style={{ marginTop: 8, color: '#a38f50' }}
                            >
                                {__('Add List Item', 'suburbancm')}
                            </Button>
                        </li>
                    </ul>
                    <RichText
                        tagName="p"
                        className="mt-6 text-lg text-[#000000] font-semibold dark:text-[#e4d198] leading-relaxed"
                        value={afterText}
                        onChange={val => setAttributes({ afterText: val })}
                        placeholder={__('Closing statement', 'suburbancm')}
                    />
                </div>
            </div>
        </div>
    );
};

export default Edit;
