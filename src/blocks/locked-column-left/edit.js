import { useBlockProps, InnerBlocks } from '@wordpress/block-editor';

export default function Edit() {
    const blockProps = useBlockProps({ className: 'locked-column-left' });
    return (
        <div {...blockProps}>
            <InnerBlocks
                template={[[
                    'suburbancm/project-details', {}, []
                ]]} 
                allowedBlocks={['suburbancm/project-details']}
                templateLock="all"
            />
        </div>
    );
}
