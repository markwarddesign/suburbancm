import { __ } from '@wordpress/i18n';
import {
	RichText,
	useBlockProps,
	MediaUpload,
	MediaUploadCheck,
	InspectorControls,
} from '@wordpress/block-editor';
import { Button, PanelBody, TextControl, Icon } from '@wordpress/components';
import { image as imageIcon, trash } from '@wordpress/icons';

/**
 * suburbancm/award-callout Gutenberg block editor view.
 *
 * @param {Object} props props
 * @return {Object} JSX
 */
const Edit = ({ attributes, setAttributes }) => {
	const {
		image,
		imageAlt,
		eyebrow,
		title,
		description,
		buttonText,
		buttonUrl,
		secondaryText,
		secondaryUrl,
	} = attributes;

	const blockProps = useBlockProps({
		className: 'suburbancm-award-callout py-16 lg:py-24 bg-[#1f1f1f]',
	});

	const overlayButtonStyle = {
		background: '#000',
		color: '#fff',
		border: 'none',
		pointerEvents: 'auto',
		opacity: 0.85,
		display: 'flex',
		alignItems: 'center',
		gap: 6,
	};

	return (
		<>
			<InspectorControls>
				<PanelBody title={__('Links', 'suburbancm')} initialOpen={true}>
					<TextControl
						label={__('Primary button URL', 'suburbancm')}
						value={buttonUrl}
						onChange={(val) => setAttributes({ buttonUrl: val })}
						help={__('e.g. the Peak 43 list or your BoiseDev profile', 'suburbancm')}
					/>
					<TextControl
						label={__('Secondary link URL', 'suburbancm')}
						value={secondaryUrl}
						onChange={(val) => setAttributes({ secondaryUrl: val })}
						help={__('Optional, e.g. the YouTube video. Leave empty to hide.', 'suburbancm')}
					/>
				</PanelBody>
				<PanelBody title={__('Badge image', 'suburbancm')} initialOpen={false}>
					<TextControl
						label={__('Alt text', 'suburbancm')}
						value={imageAlt}
						onChange={(val) => setAttributes({ imageAlt: val })}
					/>
				</PanelBody>
			</InspectorControls>

			<section {...blockProps}>
				<div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
					<div className="relative overflow-hidden max-w-5xl mx-auto bg-[#2a2a2a] p-8 md:p-12 rounded-xl shadow-xl border border-[#e4d198]/30">
						<div className="pointer-events-none absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-[#80703a] via-[#e4d198] to-[#80703a]"></div>

						<div className="flex flex-col lg:flex-row items-center text-center lg:text-left gap-8 lg:gap-12">
							<div
								className="suburbancm-award-callout__badge flex-shrink-0 flex items-center justify-center"
								style={{ width: '12rem', height: '12rem', position: 'relative' }}
							>
								<MediaUploadCheck>
									<MediaUpload
										onSelect={(media) =>
											setAttributes({ image: media.url, imageAlt: media.alt || imageAlt })
										}
										allowedTypes={['image']}
										value={image}
										render={({ open }) =>
											image ? (
												<div style={{ position: 'relative', width: '100%', height: '100%' }}>
													<img
														src={image}
														alt={imageAlt}
														style={{ width: '100%', height: '100%', objectFit: 'contain', display: 'block' }}
													/>
													<div
														style={{
															position: 'absolute',
															inset: 0,
															display: 'flex',
															alignItems: 'center',
															justifyContent: 'center',
															gap: 8,
															pointerEvents: 'none',
														}}
													>
														<Button onClick={open} isSecondary size="small" style={overlayButtonStyle}>
															<Icon icon={imageIcon} style={{ fill: '#fff', width: 18, height: 18 }} />
															{__('Replace', 'suburbancm')}
														</Button>
														<Button
															onClick={() => setAttributes({ image: '' })}
															isDestructive
															size="small"
															style={overlayButtonStyle}
														>
															<Icon icon={trash} style={{ fill: '#fff', width: 18, height: 18 }} />
															{__('Remove', 'suburbancm')}
														</Button>
													</div>
												</div>
											) : (
												<div
													style={{
														width: '10rem',
														height: '10rem',
														background: '#e4d198',
														borderRadius: '9999px',
														display: 'flex',
														flexDirection: 'column',
														alignItems: 'center',
														justifyContent: 'center',
														gap: 8,
													}}
												>
													<i className="fas fa-trophy" style={{ fontSize: 48, color: '#80703a' }} aria-hidden="true" />
													<Button onClick={open} isSecondary size="small" style={overlayButtonStyle}>
														<Icon icon={imageIcon} style={{ fill: '#fff', width: 18, height: 18 }} />
														{__('Add Logo', 'suburbancm')}
													</Button>
												</div>
											)
										}
									/>
								</MediaUploadCheck>
							</div>

							<div className="flex-1">
								<RichText
									tagName="p"
									className="text-sm font-semibold uppercase tracking-widest text-[#a38f50] mb-3"
									placeholder={__('Eyebrow (e.g. BoiseDev Peak 43 · 2026)', 'suburbancm')}
									value={eyebrow}
									onChange={(val) => setAttributes({ eyebrow: val })}
								/>
								<RichText
									tagName="h2"
									className="text-3xl md:text-4xl font-bold text-[#e4d198] mb-4"
									placeholder={__('Headline…', 'suburbancm')}
									value={title}
									onChange={(val) => setAttributes({ title: val })}
								/>
								<RichText
									tagName="p"
									className="text-lg md:text-xl text-[#e4d198]/90 leading-relaxed"
									placeholder={__('Description…', 'suburbancm')}
									value={description}
									onChange={(val) => setAttributes({ description: val })}
								/>

								<div className="mt-8 flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4 sm:gap-6">
									<RichText
										tagName="span"
										className="inline-block bg-[#a38f50] text-[#1f1f1f] font-semibold px-8 py-3 rounded-md shadow"
										placeholder={__('Button text…', 'suburbancm')}
										value={buttonText}
										onChange={(val) => setAttributes({ buttonText: val })}
										allowedFormats={[]}
									/>
									<span className="inline-flex items-center gap-2 text-[#e4d198] font-semibold">
										<i className="fas fa-play-circle" aria-hidden="true" />
										<RichText
											tagName="span"
											placeholder={__('Secondary link text…', 'suburbancm')}
											value={secondaryText}
											onChange={(val) => setAttributes({ secondaryText: val })}
											allowedFormats={[]}
										/>
									</span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
		</>
	);
};

export default Edit;
