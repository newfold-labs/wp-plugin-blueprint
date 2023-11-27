import ActionField from "../../components/action-field";
import { SectionSettings } from "../../components/section";
import { 
	ShoppingBagIcon,
	BoltIcon, 
	AdjustmentsHorizontalIcon,
} from '@heroicons/react/24/outline';

const SettingsSection = () => {
	return (
		<SectionSettings
			title={__('Settings and Performance', 'wp-plugin-blueprint')}
			description={__('Customize & fine-tune your site.', 'wp-plugin-blueprint')}
		>
			<div className="nfd-flex nfd-flex-col nfd-gap-5">
				<ActionField
					label={__("Manage Settings", "wp-plugin-blueprint")}
					buttonLabel={__("Settings", "wp-plugin-blueprint")}
					href={"#/settings"}
					className={"wppb-app-home-settings-action"}
					icon={<AdjustmentsHorizontalIcon />}
				>
					{__('Manage your site settings. You can ajdust automatic updates, comments, revisions and more.', 'wp-plugin-blueprint')}
				</ActionField>

				<ActionField
					label={__("Performance", "wp-plugin-blueprint")}
					buttonLabel={__("Performance", "wp-plugin-blueprint")}
					href={"#/performance"}
					className={"wppb-app-home-performance-action"}
					icon={<BoltIcon />}
				>
					{__('Manage site performance and caching settings as well as clear the site cache.', 'wp-plugin-blueprint')}
				</ActionField>

				<ActionField
					label={__("Marketplace", "wp-plugin-blueprint")}
					buttonLabel={__("Visit Marketplace", "wp-plugin-blueprint")}
					href={"#/marketplace"}
					className={"wppb-app-home-marketplace-action"}
					icon={<ShoppingBagIcon />}
				>
					{__('Add site services, themes or plugins from the marketplace.', 'wp-plugin-blueprint')}
				</ActionField>
			</div>
		</SectionSettings >
	);
};

export default SettingsSection;
