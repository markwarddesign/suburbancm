import { useBlockProps, InnerBlocks } from '@wordpress/block-editor';

export default function Edit() {
    const blockProps = useBlockProps({ className: 'locked-column-right' });
    return (
        <div {...blockProps}>
            <InnerBlocks
                template={[
                    ['core/heading', { level: 2, className: 'project-overview-title', content: 'Project Overview' }],
                    ['core/paragraph', { placeholder: 'Describe the project here...', content: 'This is an example project overview. You can edit or replace this text.' }],
                    ['core/gallery', {}]
                ]}
                allowedBlocks={['core/heading', 'core/paragraph', 'core/gallery', 'core/image','core/list', 'core/quote', 'core/list-item']}
                templateLock={false}
            />
        </div>
    );
}
