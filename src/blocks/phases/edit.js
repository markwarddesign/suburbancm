import { __ } from '@wordpress/i18n';
import { useBlockProps, MediaUpload, MediaUploadCheck, RichText } from '@wordpress/block-editor';
import { Button, Icon, ToggleControl } from '@wordpress/components';
import { image, trash } from '@wordpress/icons';

export default function Edit({ attributes, setAttributes }) {
    const { phases = [] } = attributes;

    const updatePhase = (index, field, value) => {
        const newPhases = [...phases];
        newPhases[index][field] = value;
        setAttributes({ phases: newPhases });
    };

    const updateStep = (phaseIndex, stepIndex, field, value) => {
        const newPhases = [...phases];
        newPhases[phaseIndex].steps[stepIndex][field] = value;
        setAttributes({ phases: newPhases });
    };

    const updateStepType = (phaseIndex, stepIndex, isList) => {
        const newPhases = [...phases];
        const step = newPhases[phaseIndex].steps[stepIndex];
        step.isList = isList;
        if (isList) {
            step.text = Array.isArray(step.text) ? step.text : (step.text ? [step.text] : []);
        } else {
            step.text = Array.isArray(step.text) ? step.text.join('\n') : (step.text || '');
        }
        setAttributes({ phases: newPhases });
    };

    const addPhase = () => {
        setAttributes({
            phases: [
                ...phases,
                {
                    image: '',
                    imageAlt: '',
                    title: '',
                    subtitle: '',
                    description: '',
                    steps: []
                }
            ]
        });
    };

    const removePhase = (index) => {
        const newPhases = [...phases];
        newPhases.splice(index, 1);
        setAttributes({ phases: newPhases });
    };

    const addStep = (phaseIndex) => {
        const newPhases = [...phases];
        newPhases[phaseIndex].steps = newPhases[phaseIndex].steps || [];
        newPhases[phaseIndex].steps.push({
            heading: '',
            text: '',
            isList: false
        });
        setAttributes({ phases: newPhases });
    };

    const removeStep = (phaseIndex, stepIndex) => {
        const newPhases = [...phases];
        newPhases[phaseIndex].steps.splice(stepIndex, 1);
        setAttributes({ phases: newPhases });
    };

    return (
        <section
            {...useBlockProps()}
            style={{
                background: '#1f1f1f',
                padding: '48px 0',
                borderRadius: 0,
            }}
        >
            <div style={{
                maxWidth: 1120,
                margin: '0 auto',
                padding: '0 32px',
            }}>
                <div style={{ display: 'flex', flexDirection: 'column', gap: 64 }}>
                    {phases.map((phase, i) => (
                        <div
                            key={i}
                            style={{
                                background: '#2a2a2a',
                                borderRadius: 20,
                                boxShadow: '0 8px 32px 0 rgba(0,0,0,0.20)',
                                padding: '32px 24px',
                                marginBottom: 0,
                                position: 'relative',
                                transition: 'box-shadow 0.2s',
                            }}
                        >
                            {/* Remove Phase Icon */}
                            <button
                                onClick={() => removePhase(i)}
                                style={{
                                    position: 'absolute',
                                    top: 16,
                                    right: 16,
                                    background: '#000',
                                    border: 'none',
                                    cursor: 'pointer',
                                    padding: 0,
                                    zIndex: 10,
                                    width: 36,
                                    height: 36,
                                    borderRadius: '50%',
                                    display: 'flex',
                                    alignItems: 'center',
                                    justifyContent: 'center',
                                }}
                                aria-label={__('Remove Phase', 'suburban')}
                                type="button"
                            >
                                <Icon icon={trash} style={{ fill: '#fff', width: 20, height: 20 }} />
                            </button>
                            <div style={{
                                display: 'flex',
                                flexDirection: 'column',
                                gap: 0,
                                alignItems: 'start',
                                textAlign: 'start',
                            }}>
                                <div style={{
                                    width: '100%',
                                    marginBottom: 24,
                                    position: 'relative',
                                }}>
                                    <MediaUploadCheck>
                                        <MediaUpload
                                            onSelect={media => {
                                                updatePhase(i, 'image', media.url);
                                                updatePhase(i, 'imageAlt', media.alt || media.title || '');
                                            }}
                                            allowedTypes={['image']}
                                            value={phase.image}
                                            render={({ open }) => (
                                                <div style={{ position: 'relative' }}>
                                                    {phase.image ? (
                                                        <div style={{ marginBottom: 12, position: 'relative' }}>
                                                            <img
                                                                src={phase.image}
                                                                alt={phase.imageAlt || ''}
                                                                style={{
                                                                    width: '100%',
                                                                    height: 192,
                                                                    objectFit: 'cover',
                                                                    borderRadius: 12,
                                                                    boxShadow: '0 2px 8px 0 rgba(0,0,0,0.18)',
                                                                    margin: '0 auto',
                                                                    display: 'block'
                                                                }}
                                                            />
                                                            {/* Overlayed image controls (centered, black bg, white text/icons) */}
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
                                                                        {__('Replace', 'suburban')}
                                                                    </Button>
                                                                    <Button
                                                                        onClick={() => { updatePhase(i, 'image', ''); updatePhase(i, 'imageAlt', ''); }}
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
                                                                        {__('Remove', 'suburban')}
                                                                    </Button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    ) : (
                                                        <div style={{
                                                            position: 'relative',
                                                            width: '100%',
                                                            height: 192,
                                                            background: '#232323',
                                                            borderRadius: 12,
                                                            display: 'flex',
                                                            alignItems: 'center',
                                                            justifyContent: 'center',
                                                        }}>
                                                            <Button
                                                                onClick={open}
                                                                icon={trash}
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
                                                                {__('Add Image', 'suburban')}
                                                            </Button>
                                                        </div>
                                                    )}
                                                </div>
                                            )}
                                        />
                                    </MediaUploadCheck>
                                </div>

                                <RichText
                                    tagName="h3"
                                    value={phase.title}
                                    allowedFormats={[]}
                                    placeholder={__('Phase Title (e.g. Phase 1)', 'suburban')}
                                    onChange={val => updatePhase(i, 'title', val)}
                                    className={`text-sm uppercase tracking-wider block text-[#80703a] dark:text-[#a38f50]/70 mb-1`}
                                />
                                <RichText
                                    tagName="div"
                                    value={phase.subtitle}
                                    allowedFormats={[]}
                                    placeholder={__('Phase Subtitle', 'suburban')}
                                    onChange={val => updatePhase(i, 'subtitle', val)}
                                    style={{
                                        fontWeight: 400,
                                        fontSize: 22,
                                        color: '#e4d198',
                                        marginBottom: 12,
                                        lineHeight: 1.3,
                                    }}
                                />
                                <RichText
                                    tagName="div"
                                    value={phase.description}
                                    allowedFormats={['core/bold', 'core/italic']}
                                    placeholder={__('Phase Description', 'suburban')}
                                    onChange={val => updatePhase(i, 'description', val)}
                                    style={{
                                        fontSize: 18,
                                        color: '#cccccc',
                                        marginBottom: 24,
                                        lineHeight: 1.5,
                                    }}
                                />
                                <div style={{ width: '100%' }}>
                                    <ul style={{ listStyle: 'none', padding: 0, margin: 0, display: 'flex', flexDirection: 'column', gap: 24 }}>
                                        {(phase.steps || []).map((step, j) => (
                                            <li
                                                key={j}
                                                style={{
                                                    background: '#232323',
                                                    borderRadius: 12,
                                                    boxShadow: '0 1px 4px 0 rgba(0,0,0,0.10)',
                                                    marginBottom: 0,
                                                    padding: 20,
                                                    position: 'relative',
                                                    textAlign: 'left'
                                                }}
                                            >
                                                {/* Remove Step Icon */}
                                                <button
                                                    onClick={() => removeStep(i, j)}
                                                    style={{
                                                        position: 'absolute',
                                                        top: 12,
                                                        right: 12,
                                                        background: '#000',
                                                        border: 'none',
                                                        borderRadius: '50%',
                                                        width: 32,
                                                        height: 32,
                                                        display: 'flex',
                                                        alignItems: 'center',
                                                        justifyContent: 'center',
                                                        cursor: 'pointer',
                                                        padding: 0,
                                                        zIndex: 10,
                                                    }}
                                                    aria-label={__('Remove Step', 'suburban')}
                                                    type="button"
                                                >
                                                    <Icon icon={trash} style={{ fill: '#fff', width: 20, height: 20 }} />
                                                </button>
                                                <RichText
                                                    tagName="h4"
                                                    value={step.heading}
                                                    allowedFormats={[]}
                                                    placeholder={__('Step Heading', 'suburban')}
                                                    onChange={val => updateStep(i, j, 'heading', val)}
                                                    style={{
                                                        fontWeight: 600,
                                                        fontSize: 20,
                                                        color: '#fff',
                                                        marginBottom: 4,
                                                    }}
                                                />
                                                <div style={{ marginBottom: 8 }}>
                                                    <ToggleControl
                                                        label={__('Use Bulleted List', 'suburban')}
                                                        checked={!!step.isList}
                                                        onChange={(val) => updateStepType(i, j, val)}
                                                        help={__('Switch between regular text and a bulleted list for this step.', 'suburban')}
                                                        style={{ marginBottom: 8 }}
                                                    />
                                                </div>
                                                {step.isList ? (
                                                    <ul style={{ listStyle: 'disc', paddingLeft: 24, color: 'inherit', margin: 0 }}>
                                                        {(Array.isArray(step.text) ? step.text : []).map((item, idx) => (
                                                            <li
                                                                key={idx}
                                                                style={{
                                                                    display: 'flex',
                                                                    alignItems: 'center',
                                                                    marginBottom: 8,
                                                                    color: '#cccccc', // text color
                                                                    position: 'relative',
                                                                }}
                                                            >
                                                                <span
                                                                    style={{
                                                                        position: 'absolute',
                                                                        left: -24,
                                                                        color: '#a38f50', // gold bullet
                                                                        fontSize: 18,
                                                                        lineHeight: 1,
                                                                        pointerEvents: 'none',
                                                                        userSelect: 'none',
                                                                    }}
                                                                    aria-hidden="true"
                                                                >•</span>
                                                                <RichText
                                                                    tagName="span"
                                                                    value={item}
                                                                    allowedFormats={['core/bold', 'core/italic']}
                                                                    placeholder={__('List item', 'suburban')}
                                                                    onChange={val => {
                                                                        const newPhases = [...phases];
                                                                        newPhases[i].steps[j].text[idx] = val;
                                                                        setAttributes({ phases: newPhases });
                                                                    }}
                                                                    style={{
                                                                        fontSize: 16,
                                                                        color: '#cccccc',
                                                                        flex: 1,
                                                                        marginBottom: 0,
                                                                        marginLeft: 8,
                                                                    }}
                                                                />
                                                                <Button
                                                                    isDestructive
                                                                    onClick={() => {
                                                                        const newPhases = [...phases];
                                                                        newPhases[i].steps[j].text.splice(idx, 1);
                                                                        setAttributes({ phases: newPhases });
                                                                    }}
                                                                    style={{ marginLeft: 8 }}
                                                                    aria-label={__('Remove list item', 'suburban')}
                                                                >
                                                                    <Icon icon={trash} />
                                                                </Button>
                                                            </li>
                                                        ))}
                                                        <li>
                                                            <Button
                                                                isSecondary
                                                                onClick={() => {
                                                                    const newPhases = [...phases];
                                                                    if (!Array.isArray(newPhases[i].steps[j].text)) newPhases[i].steps[j].text = [];
                                                                    newPhases[i].steps[j].text.push('');
                                                                    setAttributes({ phases: newPhases });
                                                                }}
                                                                style={{ marginTop: 8, color: '#a38f50' }}
                                                            >
                                                                {__('Add List Item', 'suburban')}
                                                            </Button>
                                                        </li>
                                                    </ul>
                                                ) : (
                                                    <RichText
                                                        tagName="div"
                                                        value={step.text}
                                                        allowedFormats={['core/bold', 'core/italic']}
                                                        placeholder={__('Step Text', 'suburban')}
                                                        onChange={val => updateStep(i, j, 'text', val)}
                                                        style={{
                                                            fontSize: 16,
                                                            color: '#cccccc',
                                                            marginBottom: 4,
                                                        }}
                                                    />
                                                )}
                                            </li>
                                        ))}
                                    </ul>
                                    <Button onClick={() => addStep(i)} isSecondary style={{ marginTop: 16 }}>
                                        {__('Add Step', 'suburban')}
                                    </Button>
                                </div>
                            </div>
                        </div>
                    ))}
                    <Button onClick={addPhase} variant="primary" style={{ alignSelf: 'center', marginTop: 24 }}>
                        {__('Add Phase', 'suburban')}
                    </Button>
                </div>
            </div>
        </section>
    );
}