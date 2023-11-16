import ActionField from "../../components/action-field";
import { SectionSettings } from "../../components/section";

const WebContentSection = () => {
	return (
		<SectionSettings
			title={__('Website Content', 'wp-plugin-blueprint')}
			description={__('Create, manage & sort your story.', 'wp-plugin-blueprint')}
		>
			<div className="nfd-flex nfd-flex-col nfd-gap-5">
				<ActionField
					label={__("Blog", "wp-plugin-blueprint")}
					buttonLabel={__("New Post", "wp-plugin-blueprint")}
					href={window.NewfoldRuntime.admin_url + 'post-new.php'}
					className={"wppb-app-home-blog-action"}
				>
					{__('Write a new blog post.', 'wp-plugin-blueprint')}
				</ActionField>

				<ActionField
					label={__("Pages", "wp-plugin-blueprint")}
					buttonLabel={__("New Page", "wp-plugin-blueprint")}
					href={window.NewfoldRuntime.admin_url + 'post-new.php?post_type=page'}
					className={"wppb-app-home-pages-action"}
				>
					{__('Add fresh pages to your website.', 'wp-plugin-blueprint')}
				</ActionField>

				<ActionField
					label={__("Categories", "wp-plugin-blueprint")}
					buttonLabel={__("Manage Categories", "wp-plugin-blueprint")}
					href={window.NewfoldRuntime.admin_url + 'edit-tags.php?taxonomy=category'}
					className={"wppb-app-home-categories-action"}
				>
					{__('Organize existing content into categories.', 'wp-plugin-blueprint')}
				</ActionField>
			</div>
		</SectionSettings >
	);
};

export default WebContentSection;
