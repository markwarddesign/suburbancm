import { useBlockProps, InnerBlocks } from '@wordpress/block-editor';

const LOCKED_COLUMNS_TEMPLATE = [
    [
        'core/columns',
        { className: 'locked-columns-inner', isStackedOnMobile: true},
        [
            [ 'core/column', { width: '33.33%' }, [ [ 'suburbancm/locked-column-left', {}, [] ] ] ],
            [ 'core/column', {}, [ [ 'suburbancm/locked-column-right', {}, [] ] ], false ] // right column unlocked
        ]
    ]
];

export default function Edit() {
    const blockProps = useBlockProps({ className: 'locked-columns-container' });
    return (
        <div {...blockProps}>
            <InnerBlocks
                template={LOCKED_COLUMNS_TEMPLATE}
                allowedBlocks={['core/columns']}
            />
        </div>
    );
}
