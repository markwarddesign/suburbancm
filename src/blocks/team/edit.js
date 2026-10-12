import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls, RichText } from '@wordpress/block-editor';
import { PanelBody, Button, CheckboxControl, Spinner, Notice, ToggleControl } from '@wordpress/components';
import { Fragment, useEffect, useState } from '@wordpress/element';

const Edit = ({ attributes, setAttributes }) => {
    const { title, showAll = true, selectedTeamMembers = [], hideTitle = false } = attributes;
    const [teamPosts, setTeamPosts] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState('');

    // Fetch team members from REST API with _embed for featured media
    useEffect(() => {
        setLoading(true);
        wp.apiFetch({ path: '/wp/v2/team?per_page=100&_embed' })
            .then((posts) => {
                setTeamPosts(posts);
                setLoading(false);
            })
            .catch(() => {
                setError(__('Could not load team members.', 'suburbancm'));
                setLoading(false);
            });
    }, []);

    // Handle checkbox change for selecting team members
    const handleSelectMember = (id, checked) => {
        let updated = [...selectedTeamMembers];
        if (checked) {
            updated.push(id);
        } else {
            updated = updated.filter((memberId) => memberId !== id);
        }
        setAttributes({ selectedTeamMembers: updated });
    };

    // Determine which members to show
    const visibleMembers = showAll
        ? teamPosts
        : teamPosts.filter((member) => selectedTeamMembers.includes(member.id));

    const blockProps = useBlockProps({
        className: 'suburbancm-team relative z-1 w-full flex items-center justify-center text-center py-20 px-4 sm:px-6 lg:px-8 z-10 text-[#000000] antialiased',
    });

    return (
        <Fragment>
            <InspectorControls>
                <PanelBody title={__('Team Settings', 'suburbancm')} initialOpen={true}>
                    <ToggleControl
                        label={__('Hide Title', 'suburbancm')}
                        checked={!!hideTitle}
                        onChange={(val) => setAttributes({ hideTitle: val })}
                    />
                    <CheckboxControl
                        label={__('Show All Team Members', 'suburbancm')}
                        checked={!!showAll}
                        onChange={(val) => setAttributes({ showAll: val })}
                    />
                    {!showAll && (
                        <div style={{ maxHeight: 200, overflowY: 'auto', marginTop: 12 }}>
                            {loading && <Spinner />}
                            {error && <Notice status="error">{error}</Notice>}
                            {!loading && !error && teamPosts.length === 0 && (
                                <p>{__('No team members found.', 'suburbancm')}</p>
                            )}
                            {!loading && !error && teamPosts.map((member) => (
                                <CheckboxControl
                                    key={member.id}
                                    label={member.title.rendered}
                                    checked={selectedTeamMembers.includes(member.id)}
                                    onChange={(checked) => handleSelectMember(member.id, checked)}
                                />
                            ))}
                        </div>
                    )}
                </PanelBody>
            </InspectorControls>
            <section {...blockProps}>
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    {!hideTitle && (
                        <RichText
                            tagName="h2"
                            className="text-3xl font-bold text-center text-brand-text-light dark:text-white mb-12"
                            placeholder={__('Enter title...', 'suburbancm')}
                            value={title}
                            onChange={(newTitle) => setAttributes({ title: newTitle })}
                        />
                    )}
                    <div className="team grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                        {loading && <Spinner />}
                        {error && <Notice status="error">{error}</Notice>}
                        {!loading && !error && visibleMembers.length === 0 && (
                            <p>{__('No team members to display.', 'suburbancm')}</p>
                        )}
                        {!loading && !error && visibleMembers.map((member) => (
                            <div
                                key={member.id}
                                className="team-member p-6 rounded-lg shadow-md text-center relative dark:bg-[#2a2a2a]"
                            >
                                <div className="team-member-image w-32 h-32 rounded-full mx-auto mb-4 border-4 border-gold overflow-hidden">
                                    {member._embedded?.['wp:featuredmedia']?.[0]?.source_url ? (
                                        <img
                                            src={member._embedded['wp:featuredmedia'][0].source_url}
                                            alt={member.title.rendered}
                                            className="h-full w-full object-cover"
                                        />
                                    ) : (
                                        <img
                                            src="https://via.placeholder.com/300x300?text=Photo"
                                            alt={member.title.rendered}
                                            className="h-full w-full object-cover"
                                        />
                                    )}
                                </div>
                                <span className="text-white text-xl font-semibold mb-1 block">
                                    {member.title.rendered}
                                </span>
                                {member.acf?.role && (
                                    <span className="text-gold font-medium mb-2 block">
                                        {member.acf.role}
                                    </span>
                                )}
                                {member.excerpt?.rendered && (
                                    <span
                                        className="text-sm text-gold"
                                        dangerouslySetInnerHTML={{ __html: member.excerpt.rendered }}
                                    />
                                )}
                                <div className="mt-4">
                                    <a
                                        href={member.link}
                                        className="inline-block text-[#a38f50] dark:text-[#e4d198] hover:underline font-semibold"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                    >
                                        {__('View Profile', 'suburbancm')}
                                    </a>
                                </div>
                            </div>
                        ))}
                    </div>
                </div>
            </section>
        </Fragment>
    );
};

export default Edit;