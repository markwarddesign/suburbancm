import { __ } from '@wordpress/i18n';
import { useCallback, memo } from '@wordpress/element';
import { useBlockProps, InnerBlocks, store as blockEditorStore, RichText } from '@wordpress/block-editor';
import { useSelect, useDispatch } from '@wordpress/data';
import { MediaUpload, MediaUploadCheck } from '@wordpress/block-editor';
import { TextControl } from '@wordpress/components';

const ALLOWED_BLOCKS = ['core/heading', 'core/paragraph', 'core/image', 'core/gallery', 'core/list', 'core/list-item'];
const INNER_BLOCKS_TEMPLATE = [
    ['core/paragraph', { placeholder: 'Project description or introduction' }],
    ['core/gallery', {}],
];

const DetailItem = memo(({ label, children }) => {
    console.log(`Rendering DetailItem: ${label}`);
    return (
        <div className="project-detail-item mb-4">
            <h3 className="project-detail-label text-sm font-bold mb-1">{label}</h3>
            <div className="project-detail-value">{children}</div>
        </div>
    );
});

export default function Edit({ attributes, setAttributes, context, clientId }) {
    console.log('%c--- Block Component Rendering ---', 'font-weight: bold; color: green;');
    console.log('Context:', { postType: context?.postType, postId: context?.postId });
    console.log('Attributes:', attributes);

    const blockProps = useBlockProps({ className: '' });
    const { postType, postId } = context || {};

    // Validate postType and postId
    if (!postType || !postId) {
        console.error('Invalid context: Missing postType or postId', { postType, postId });
        return <p {...blockProps}>{__('Error: Missing post type or ID', 'suburbancm')}</p>;
    }

    const { subtitle, client, location, size, startDate, completionDate, shortDescription } = attributes;

    const updateAttribute = useCallback((key, value) => {
        console.log(`RichText/TextControl onChange: key=${key}, value=${value}`);
        setAttributes({ [key]: value });
    }, [setAttributes]);

    const hasInnerBlocks = useSelect(
        (select) => {
            const blocks = select(blockEditorStore).getBlocks(clientId);
            console.log('Inner blocks:', blocks);
            return blocks.length > 0;
        },
        [clientId]
    );

    // Get and set featured image
    const featuredImageId = useSelect(
        (select) => select('core/editor').getEditedPostAttribute('featured_media'),
        []
    );
    const featuredImage = useSelect(
        (select) => featuredImageId ? select('core').getMedia(featuredImageId) : null,
        [featuredImageId]
    );
    const { editPost } = useDispatch('core/editor');

    const setFeaturedImage = (media) => {
        editPost({ featured_media: media ? media.id : 0 });
    };

    return (
        <div {...blockProps}>
            {/* Full-width featured image */}
            <div className="w-full mb-8">
                <MediaUploadCheck>
                    <MediaUpload
                        onSelect={setFeaturedImage}
                        allowedTypes={['image']}
                        value={featuredImageId}
                        render={({ open }) => (
                            <div className="relative cursor-pointer" onClick={open}>
                                {featuredImage ? (
                                    <img
                                        src={featuredImage.source_url}
                                        alt={featuredImage.alt_text || ''}
                                        className="w-full min-h-64 object-cover rounded-lg"
                                        style={{ objectFit: 'cover', width: '100%', minHeight: '16rem' }}
                                    />
                                ) : (
                                    <div className="w-full min-h-64 flex items-center justify-center bg-gray-200 rounded-lg">
                                        <span className="text-gray-500">{__('Set Featured Image', 'suburbancm')}</span>
                                    </div>
                                )}
                            </div>
                        )}
                    />
                </MediaUploadCheck>
            </div>
            <div className='flex gap-x-8'>
                <div className="w-1/3">
                    <h2 className="text-lg font-bold mb-4">Project Details</h2>
                    <DetailItem label={__('Client', 'suburbancm')}>
                        <RichText
                            identifier="client"
                            tagName="p"
                            value={client}
                            onChange={(value) => updateAttribute('client', value)}
                            placeholder={__('Enter client name...', 'suburbancm')}
                        />
                    </DetailItem>
                    <DetailItem label={__('Location', 'suburbancm')}>
                        <RichText
                            identifier="location"
                            tagName="p"
                            value={location}
                            onChange={(value) => updateAttribute('location', value)}
                            placeholder={__('Enter location...', 'suburbancm')}
                        />
                    </DetailItem>
                    <DetailItem label={__('Size', 'suburbancm')}>
                        <RichText
                            identifier="size"
                            tagName="p"
                            value={size}
                            onChange={(value) => updateAttribute('size', value)}
                            placeholder={__('Enter project size...', 'suburbancm')}
                        />
                    </DetailItem>
                    <DetailItem label={__('Start Date', 'suburbancm')}>
                        <TextControl
                            type="date"
                            value={startDate}
                            onChange={(value) => updateAttribute('startDate', value)}
                            __next40pxDefaultSize={true}
                            __nextHasNoMarginBottom={true}
                        />
                    </DetailItem>
                    <DetailItem label={__('Completion Date', 'suburbancm')}>
                        <TextControl
                            type="date"
                            value={completionDate}
                            onChange={(value) => updateAttribute('completionDate', value)}
                            __next40pxDefaultSize={true}
                            __nextHasNoMarginBottom={true}
                        />
                    </DetailItem>
                    <DetailItem label={__('Short Description', 'suburbancm')}>
                        <div className={`p-4 bg-gray-900 rounded-lg mb-4`}>
                        <RichText
                            identifier="short-description"
                            tagName="div"
                            multiline="p"
                            value={shortDescription}
                            onChange={(value) => updateAttribute('shortDescription', value)}
                            placeholder={__('Enter short description...', 'suburbancm')}
                        />
                        </div>
                        <p className="text-xs text-gray-500 mt-1">This description appears in project grid and archive listings, but not on the single project page.</p>
                    </DetailItem>
                </div>
                <div className="w-2/3">
                <h2>Project Overview</h2>
                    <InnerBlocks
                        allowedBlocks={ALLOWED_BLOCKS}
                        template={!hasInnerBlocks ? INNER_BLOCKS_TEMPLATE : undefined}
                    />
                </div>
            </div>
        </div>
    );
}