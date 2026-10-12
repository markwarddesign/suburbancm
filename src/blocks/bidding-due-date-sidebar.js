import { registerPlugin } from '@wordpress/plugins';
import { PluginDocumentSettingPanel } from '@wordpress/edit-post';
import { useSelect, useDispatch } from '@wordpress/data';
import { DateTimePicker } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

const META_KEY = 'due_date';

const DueDatePanel = () => {
    const meta = useSelect((select) => select('core/editor').getEditedPostAttribute('meta'), []);
    const { editPost } = useDispatch('core/editor');
    const value = meta && meta[META_KEY] ? meta[META_KEY] : '';
    return (
        <PluginDocumentSettingPanel
            name="bidding-due-date-panel"
            title={__('Due Date', 'suburbancm')}
            className="bidding-due-date-panel"
            icon="calendar"
        >
            <DateTimePicker
                currentDate={value || undefined}
                onChange={(date) => editPost({ meta: { ...meta, [META_KEY]: date ? date.substring(0, 10) : '' } })}
                isDateOnly
            />
        </PluginDocumentSettingPanel>
    );
};

registerPlugin('bidding-due-date-sidebar', {
    render: DueDatePanel,
    icon: 'calendar',
});
