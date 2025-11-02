import { RichText, useBlockProps } from "@wordpress/block-editor";

export default function save(props) {
	const { attributes } = props;
	const { subHeading } = attributes;
	const blockProps = useBlockProps.save({
		className: 'nds-sub-heading block flex items-center gap-2.5'
	});
	return (
		<div {...blockProps}>
			<span className="nds-icon size-3.5 block relative"></span>
			<RichText.Content
				tagName={"span"}
				value={subHeading}
				className={"font-light text-system-base block"}
			/>
		</div>
	);
}
