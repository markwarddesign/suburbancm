import { __ } from '@wordpress/i18n';
import { useBlockProps, RichText } from '@wordpress/block-editor';
import { PanelBody, SelectControl, TextControl, Button } from '@wordpress/components';
import { InspectorControls } from '@wordpress/block-editor';
import { useEffect, useState } from '@wordpress/element';

const Edit = ({ attributes, setAttributes }) => {
    const { selectedProjects, title, description, buttonText, buttonUrl } = attributes;
    const [projects, setProjects] = useState([]);
    const [previewProjects, setPreviewProjects] = useState([]);

    useEffect(() => {
        // Fetch projects from the REST API with _embed to include featured media
        wp.apiFetch({ path: '/wp/v2/projects?per_page=100&_embed' }).then((posts) => {
            setProjects(posts);
        });
    }, []);

    useEffect(() => {
        // Fetch selected projects for preview with _embed
        if (selectedProjects.length > 0) {
            wp.apiFetch({ path: `/wp/v2/projects?include=${selectedProjects.join(',')}&_embed` }).then((posts) => {
                setPreviewProjects(posts);
            });
        } else {
            setPreviewProjects([]);
        }
    }, [selectedProjects]);

    const updateSelectedProjects = (projectIds) => {
        setAttributes({ selectedProjects: projectIds });
    };

    const blockProps = useBlockProps({
        className: 'suburbancm-projects-block',
    });

    return (
        <>
            {/* Sidebar Controls */}
            <InspectorControls>
                <PanelBody title={__('Select Projects', 'suburbancm')} initialOpen={true}>
                    <SelectControl
                        multiple
                        label={__('Projects', 'suburbancm')}
                        value={selectedProjects || []}
                        options={projects.map((project) => ({
                            label: project.title.rendered,
                            value: project.id,
                        }))}
                        onChange={(newSelected) => updateSelectedProjects(newSelected)}
                    />
                </PanelBody>
                <PanelBody title={__('Button Settings', 'suburbancm')} initialOpen={false}>
                    <TextControl
                        label={__('Button Text', 'suburbancm')}
                        value={buttonText || ''}
                        onChange={(value) => setAttributes({ buttonText: value })}
                    />
                    <TextControl
                        label={__('Button URL', 'suburbancm')}
                        value={buttonUrl || ''}
                        onChange={(value) => setAttributes({ buttonUrl: value })}
                    />
                </PanelBody>
            </InspectorControls>

            {/* Block Content */}
            <div {...blockProps}>
                <section id="projects" className="py-16 lg:py-24 bg-[#ffffff] dark:bg-[#2a2a2a] overflow-hidden">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <RichText
                            tagName="h2"
                            className="text-3xl font-bold text-center text-white mb-4 dark:text-[#ffffff]"
                            value={title}
                            onChange={(value) => setAttributes({ title: value })}
                            placeholder={__('Enter title…', 'suburbancm')}
                        />
                        <div className="mt-4 mb-12 text-center text-lg text-[#80703a] dark:text-[#e4d198]/80">
                            <RichText
                                tagName="span"
                                className=""
                                value={description}
                                onChange={(value) => setAttributes({ description: value })}
                                placeholder={__('Enter optional description…', 'suburbancm')}
                            />
                        </div>
                        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                            {previewProjects.map((project) => (
                                <div
                                    key={project.id}
                                    className="bg-[#f6f5ec] dark:bg-[#1f1f1f] rounded-lg shadow-md overflow-hidden group border border-[#e4d198]/50 dark:border-[#80703a]/50 hover:shadow-xl transition-all duration-300 ease-in-out"
                                >
                                    <div className="overflow-hidden">
                                        {project._embedded?.['wp:featuredmedia']?.[0]?.source_url && (
                                            <img
                                                src={project._embedded['wp:featuredmedia'][0].source_url}
                                                alt={project.title.rendered}
                                                className="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300 ease-in-out"
                                            />
                                        )}
                                    </div>
                                    <div className="p-6">
                                        <h3 className="text-xl font-semibold mb-2 text-white dark:text-[#ffffff]">
                                            {project.title.rendered}
                                        </h3>
                                        <p className="text-[#80703a] dark:text-[#e4d198]/80 mb-4 text-sm">
                                            {project.excerpt?.rendered
                                                ? project.excerpt.rendered.replace(/<[^>]+>/g, '')
                                                : project.content?.rendered
                                                    .replace(/<[^>]+>/g, '') // Strip HTML tags
                                                    .split(/\s+/) // Split into words
                                                    .slice(0, 20) // Take the first 20 words
                                                    .join(' ') + '...' // Join and append ellipsis
                                            }
                                        </p>
                                        <a
                                            href={project.link}
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            className="text-[#a38f50] hover:text-[#80703a] font-medium text-sm relative after:absolute after:bg-[#a38f50] dark:after:bg-[#e4d198] after:bottom-0 after:left-0 after:h-px after:w-full after:scale-x-0 after:origin-left hover:after:scale-x-100 after:transition-transform after:duration-300 after:ease-out"
                                        >
                                            {__('View Details →', 'suburbancm')}
                                        </a>
                                    </div>
                                </div>
                            ))}
                            {previewProjects.length === 0 && (
                                <p className="text-center">
                                    {__('No projects selected. Use the sidebar to select projects.', 'suburbancm')}
                                </p>
                            )}
                        </div>
                        {buttonText && (
                            <div className="text-center mt-8">
                                <Button
                                    type="button"
                                    className="btn primary"
                                    disabled
                                >
                                    {buttonText}
                                </Button>
                            </div>
                        )}
                    </div>
                </section>
            </div>
        </>
    );
};

export default Edit;