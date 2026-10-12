import { useState } from '@wordpress/element';
import { MediaUpload, MediaUploadCheck, useBlockProps } from '@wordpress/block-editor';
import { Button, IconButton } from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import { RichText } from '@wordpress/block-editor';

const PDFList = ({ pdfs, setPdfs }) => {
    // Reorder handler
    const movePdf = (from, to) => {
        const updated = [...pdfs];
        const [moved] = updated.splice(from, 1);
        updated.splice(to, 0, moved);
        setPdfs(updated);
    };
    // Name change handler
    const updateName = (index, name) => {
        const updated = [...pdfs];
        updated[index].name = name;
        setPdfs(updated);
    };
    // Remove handler
    const removePdf = (index) => {
        const updated = [...pdfs];
        updated.splice(index, 1);
        setPdfs(updated);
    };
    return (
        <div className="bidding-pdfs-list grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            {pdfs.map((pdf, i) => (
                <div key={pdf.id} className="bidding-pdf flex flex-col items-center bg-[#181818] rounded-lg p-5">
                    <span className="text-7xl text-[#e4d198] mb-4">
                        <span className="dashicons dashicons-media-document"></span>
                    </span>
                    <RichText
                        tagName="span"
                        value={pdf.name}
                        allowedFormats={[ 'core/bold', 'core/italic' ]}
                        onChange={(val) => updateName(i, val)}
                        placeholder={__('Custom name...', 'suburban')}
                        className="block text-center text-base text-white bg-[#222] border-[#80703a] mb-2 w-full px-2 py-1 rounded"
                    />
                    <div className="flex gap-2 mt-4 justify-center">
                        <IconButton
                            icon="arrow-left"
                            label={__('Move Left', 'suburban')}
                            onClick={() => i > 0 && movePdf(i, i - 1)}
                            disabled={i === 0}
                            className="bg-[#222] text-[#e4d198] border border-[#80703a] hover:bg-[#80703a] hover:text-white"
                        />
                        <IconButton
                            icon="arrow-right"
                            label={__('Move Right', 'suburban')}
                            onClick={() => i < pdfs.length - 1 && movePdf(i, i + 1)}
                            disabled={i === pdfs.length - 1}
                            className="bg-[#222] text-[#e4d198] border border-[#80703a] hover:bg-[#80703a] hover:text-white"
                        />
                        <IconButton
                            icon="trash"
                            label={__('Remove', 'suburban')}
                            onClick={() => removePdf(i)}
                            className="bg-[#222] text-red-500 border border-[#80703a] hover:bg-red-700 hover:text-white"
                        />
                    </div>
                </div>
            ))}
        </div>
    );
};

const Edit = ({ attributes, setAttributes }) => {
    const blockProps = useBlockProps({
        className: 'wp-block-bidding-pdfs bg-[#181818] border border-[#80703a] rounded-lg p-8 shadow-md my-6 relative',
    });
    const [pdfs, setPdfs] = useState(attributes.pdfs || []);
    const blockTitle = attributes.blockTitle || __('Downloads', 'suburban');
    // Sync state to attributes
    if (pdfs !== attributes.pdfs) setAttributes({ pdfs });
    return (
        <div {...blockProps}>
            <h3 className="text-2xl font-bold text-[#e4d198] mb-6 text-center">
                <RichText
                    tagName="span"
                    value={blockTitle}
                    allowedFormats={[ 'core/bold', 'core/italic' ]}
                    onChange={val => setAttributes({ blockTitle: val })}
                    placeholder={__('Section Title…', 'suburban')}
                    className="text-2xl font-bold text-[#e4d198] text-center bg-transparent border-none mb-0 p-0"
                    style={{ background: 'none', border: 'none', textAlign: 'center', color: '#e4d198', fontWeight: 'bold', fontSize: '1.5rem', marginBottom: 0 }}
                />
            </h3>
            <MediaUploadCheck>
                <MediaUpload
                    allowedTypes={[ 'application/pdf' ]}
                    multiple
                    gallery={false}
                    value={pdfs.map(pdf => pdf.id)}
                    onSelect={(media) => {
                        const newPdfs = media.map(file => ({
                            id: file.id,
                            url: file.url,
                            name: file.title || '',
                        }));
                        setPdfs([ ...pdfs, ...newPdfs ]);
                    }}
                    render={({ open }) => (
                        <Button
                            onClick={open}
                            isPrimary
                            className="absolute top-6 right-6 bg-[#e4d198] text-[#181818] hover:bg-[#a38f50] font-bold px-5 py-2 rounded shadow-lg z-10"
                        >
                            {__('Upload PDFs', 'suburban')}
                        </Button>
                    )}
                />
            </MediaUploadCheck>
            <PDFList pdfs={pdfs} setPdfs={setPdfs} />
        </div>
    );
};

export default Edit;
