// ==== core/columns customizations ====

wp.hooks.addFilter(
  'blocks.registerBlockType',
  'nds/columns/register-attributes',
  (settings, name) => {
    if (name !== 'core/columns') return settings;
    return {
      ...settings,
      attributes: {
        ...settings.attributes,
        stackOnTablet: { type: 'boolean', default: false },
        justifyContent: {
          type: 'string',
          default: 'center', // or 'center'
        },
      },
    };
  }
);

wp.hooks.addFilter(
  'editor.BlockEdit',
  'nds/columns/block-edit',
  wp.compose.createHigherOrderComponent((BlockEdit) => {
    return (props) => {
      if (props.name !== 'core/columns') return wp.element.createElement(BlockEdit, props);

      const { attributes, setAttributes } = props;
      const { stackOnTablet, justifyContent } = attributes;

      return wp.element.createElement(
        wp.element.Fragment,
        {},
        wp.element.createElement(BlockEdit, props),
        wp.element.createElement(
          wp.blockEditor.InspectorControls,
          {},
          wp.element.createElement(
            wp.components.PanelBody,
            { title: 'NDS Custom Options', initialOpen: true },
            wp.element.createElement(wp.components.ToggleControl, {
              label: 'Stack on tablet',
              checked: !!stackOnTablet,
              onChange: (val) => setAttributes({ stackOnTablet: val }),
            }),
            wp.element.createElement(wp.components.SelectControl, {
              label: 'Justify content',
              value: justifyContent,
              options: [
                { label: 'Default', value: '' },
                { label: 'Start', value: 'justify-start' },
                { label: 'Center', value: 'justify-center' },
                { label: 'End', value: 'justify-end' },
                { label: 'Space between', value: 'justify-between' },
                { label: 'Space around', value: 'justify-around' },
                { label: 'Space evenly', value: 'justify-evenly' },
              ],
              onChange: (val) => setAttributes({ justifyContent: val }),
            })
          )
        )
      );
    };
  }, 'withStackOnTabletToggle')
);


wp.hooks.addFilter(
  'blocks.getSaveContent.extraProps',
  'nds/columns/save-class',
  (extraProps, blockType, attributes) => {
    if (blockType.name === 'core/columns') {
      const classes = [];

      if (attributes.stackOnTablet) {
        classes.push('stack-on-tablet');
      }

      if (attributes.justifyContent) {
        classes.push(attributes.justifyContent); // e.g. 'justify-center'
      }

      if (classes.length > 0) {
        extraProps.className = (extraProps.className || '') + ' ' + classes.join(' ');
      }
    }

    return extraProps;
  }
);


wp.hooks.addFilter(
  'editor.BlockListBlock',
  'nds/columns/editor-class',
  wp.compose.createHigherOrderComponent((BlockListBlock) => {
    return (props) => {
      if (props.block.name === 'core/columns') {
        const { stackOnTablet, justifyContent } = props.block.attributes;

        const classes = [];
        if (stackOnTablet) classes.push('stack-on-tablet');
        if (justifyContent) classes.push(justifyContent);

        return wp.element.createElement(BlockListBlock, {
          ...props,
          className: (props.className || '') + ' ' + classes.join(' '),
        });
      }

      return wp.element.createElement(BlockListBlock, props);
    };
  }, 'withEditorClass')
);

// ==== core/group customizations ====

wp.hooks.addFilter(
  'blocks.registerBlockType',
  'nds/group/register-attributes',
  (settings, name) => {
    if (name !== 'core/group') return settings;

    return {
      ...settings,
      attributes: {
        ...settings.attributes,
        allowFullWidth: { type: 'boolean', default: false },
      },
    };
  }
);

wp.hooks.addFilter(
  'editor.BlockEdit',
  'nds/group/block-edit',
  wp.compose.createHigherOrderComponent((BlockEdit) => {
    return (props) => {
      if (props.name !== 'core/group') return wp.element.createElement(BlockEdit, props);

      const { attributes, setAttributes } = props;

      return wp.element.createElement(
        wp.element.Fragment,
        {},
        wp.element.createElement(BlockEdit, props),
        wp.element.createElement(
          wp.blockEditor.InspectorControls,
          {},
          wp.element.createElement(
            wp.components.PanelBody,
            { title: 'NDS Custom Options' },
            wp.element.createElement(wp.components.ToggleControl, {
              label: 'Enable Full Width',
              checked: !!attributes.allowFullWidth,
              onChange: (val) => setAttributes({ allowFullWidth: val }),
            })
          )
        )
      );
    };
  }, 'withAllowFullWidthToggle')
);

wp.hooks.addFilter(
  'blocks.getSaveContent.extraProps',
  'nds/group/save-class',
  (extraProps, blockType, attributes) => {
    if (blockType.name === 'core/group' && attributes.allowFullWidth) {
      extraProps.className = (extraProps.className || '') + ' w-full';
    }
    return extraProps;
  }
);

wp.hooks.addFilter(
  'editor.BlockListBlock',
  'nds/group/editor-class',
  wp.compose.createHigherOrderComponent((BlockListBlock) => {
    return (props) => {
      if (props.block.name === 'core/group' && props.block.attributes.allowFullWidth) {
        return wp.element.createElement(BlockListBlock, {
          ...props,
          className: (props.className || '') + ' w-full',
        });
      }
      return wp.element.createElement(BlockListBlock, props);
    };
  }, 'withAllowFullWidthEditorClass')
);

// Register new attributes on core/image
wp.hooks.addFilter(
  'blocks.registerBlockType',
  'nds/image/register-attributes',
  (settings, name) => {
    if (name !== 'core/image') return settings;

    return {
      ...settings,
      attributes: {
        ...settings.attributes,
        centerOnTablet: {
          type: 'boolean',
          default: false,
        },
        centerOnMobile: {
          type: 'boolean',
          default: false,
        },
      },
    };
  }
);

// Add UI controls in Inspector
wp.hooks.addFilter(
  'editor.BlockEdit',
  'nds/image/block-edit',
  wp.compose.createHigherOrderComponent((BlockEdit) => {
    return (props) => {
      if (props.name !== 'core/image') return wp.element.createElement(BlockEdit, props);

      const { attributes, setAttributes } = props;

      return wp.element.createElement(
        wp.element.Fragment,
        {},
        wp.element.createElement(BlockEdit, props),
        wp.element.createElement(
          wp.blockEditor.InspectorControls,
          {},
          wp.element.createElement(
            wp.components.PanelBody,
            { title: 'NDS Display Options', initialOpen: true },
            wp.element.createElement(wp.components.ToggleControl, {
              label: 'Centre on tablet',
              checked: !!attributes.centerOnTablet,
              onChange: (val) => setAttributes({ centerOnTablet: val }),
            }),
            wp.element.createElement(wp.components.ToggleControl, {
              label: 'Centre on mobile',
              checked: !!attributes.centerOnMobile,
              onChange: (val) => setAttributes({ centerOnMobile: val }),
            })
          )
        )
      );
    };
  }, 'withCenteringOptions')
);

// Add class to saved block output
wp.hooks.addFilter(
  'blocks.getSaveContent.extraProps',
  'nds/image/save-class',
  (extraProps, blockType, attributes) => {
    if (blockType.name === 'core/image') {
      const classes = [];
      if (attributes.centerOnTablet) classes.push('nds-center-tablet');
      if (attributes.centerOnMobile) classes.push('nds-center-mobile');

      if (classes.length > 0) {
        extraProps.className = (extraProps.className || '') + ' ' + classes.join(' ');
      }
    }
    return extraProps;
  }
);

// Add class to editor view
wp.hooks.addFilter(
  'editor.BlockListBlock',
  'nds/image/editor-class',
  wp.compose.createHigherOrderComponent((BlockListBlock) => {
    return (props) => {
      if (props.block.name === 'core/image') {
        const { centerOnTablet, centerOnMobile } = props.block.attributes;
        const classNames = [];
        if (centerOnTablet) classNames.push('nds-center-tablet');
        if (centerOnMobile) classNames.push('nds-center-mobile');

        return wp.element.createElement(BlockListBlock, {
          ...props,
          className: (props.className || '') + ' ' + classNames.join(' '),
        });
      }

      return wp.element.createElement(BlockListBlock, props);
    };
  }, 'withEditorClass')
);

//  Core List Add Attribute
// Define your custom list styles here
const customListStyles = [
  { name: 'primary-style', label: 'Primary style' },
  // Add more here if needed
];

// 1) Register all custom styles for core/list
wp.domReady(() => {
  customListStyles.forEach(style => {
    wp.blocks.registerBlockStyle('core/list', style);
  });
});

// 2) Utility: remove any custom styles from a className string
function removeCustomStyles(className) {
  return className
    .split(' ')
    .filter(c => !customListStyles.some(style => c === `is-style-${style.name}`))
    .join(' ');
}

// 3) Front end: strip custom styles from ordered lists
wp.hooks.addFilter(
  'blocks.getSaveContent.extraProps',
  'nds/list/only-ul-has-custom-styles',
  (extraProps, blockType, attributes) => {
    if (blockType.name !== 'core/list') return extraProps;

    const { ordered } = attributes;

    if (ordered && typeof extraProps.className === 'string') {
      extraProps.className = removeCustomStyles(extraProps.className);
    }

    return extraProps;
  }
);

// 4) Editor: prevent custom styles from showing on ordered lists
wp.hooks.addFilter(
  'editor.BlockListBlock',
  'nds/list/editor-class-clean',
  wp.compose.createHigherOrderComponent((BlockListBlock) => {
    return (props) => {
      if (props.block?.name !== 'core/list') {
        return wp.element.createElement(BlockListBlock, props);
      }

      const { ordered } = props.block.attributes || {};
      let nextClass = props.className || '';

      if (ordered && typeof nextClass === 'string') {
        nextClass = removeCustomStyles(nextClass);
      }

      return wp.element.createElement(BlockListBlock, { ...props, className: nextClass });
    };
  }, 'withListEditorClassClean')
);