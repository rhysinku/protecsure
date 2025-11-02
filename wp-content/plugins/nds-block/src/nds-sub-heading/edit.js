
import { __ } from '@wordpress/i18n';


import { RichText, useBlockProps } from '@wordpress/block-editor';

import './editor.scss';


export default function Edit(props) {
	const { setAttributes, attributes, } = props;
	const {subHeading } = attributes;
	const blockProps = useBlockProps({
		className: 'nds-sub-heading block flex items-center gap-2.5'
	});
	return (
		<div {...blockProps}>
			<span className="nds-icon size-3.5 block relative">
			</span>
			<RichText
				tagName={"span"}
				value={subHeading}
				className={"font-light text-base block"}
				allowedFormats={[]}
				onChange={(newVal) => setAttributes({ subHeading: newVal })}
				placeholder={"sub Heading"}
			/>
		</div>
	);
}