import { useBlockProps, InnerBlocks } from '@wordpress/block-editor';

export default function Save() {
    const blockProps = useBlockProps.save();

    return (
        <div {...blockProps}>
            {/* The meta column is intentionally empty in the saved output */}
            <div className="meta-column"></div>
            <div className="inner-blocks-column">
                <InnerBlocks.Content />
            </div>
        </div>
    );
}