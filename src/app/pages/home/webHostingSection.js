import ActionField from "../../components/action-field";
import { SectionSettings } from "../../components/section";

const WebHostingSection = () => {
	return (
		<SectionSettings
			title={__('Web Hosting', 'wp-plugin-blueprint')}
			description={__('Access & manage your Blueprint account.', 'wp-plugin-blueprint')}
		>
			<div className="nfd-flex nfd-flex-col nfd-gap-5">
				<ActionField
					label={__("Manage Blueprint Account", "wp-plugin-blueprint")}
					buttonLabel={__("Blueprint Account", "wp-plugin-blueprint")}
					href={
						`https://www.blueprint.com/login?` +
						`&utm_campaign=` +
						`&utm_content=home_hosting_sites_link` +
						`&utm_term=manage_sites` +
						`&utm_medium=brand_plugin` +
						`&utm_source=wp-admin/admin.php?page=blueprint#/home`
					}
					target="_blank"
					className={"wppb-app-home-sites-action"}
				>
					{__("Manage Blueprint account products, options and billing.", "wp-plugin-blueprint")}
				</ActionField>
			</div>
		</SectionSettings>
	);
};

export default WebHostingSection;
