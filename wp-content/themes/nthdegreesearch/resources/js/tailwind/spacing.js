const plugin = require('tailwindcss/plugin');

module.exports = plugin(({matchUtilities}) => {
  // Padding top utilities
  matchUtilities(
    {
      'nds_pt': (value) => ({
        paddingTop: value,
      }),
    },
    {
      values: {
        none: '0',
        xxsm: '40px',
        xsm: '80px',
        sm: '100px',
        md: '160px',
        lg: '210px',
      },
    }
  );

  // Padding bottom utilities
  matchUtilities(
    {
      'nds_pb': (value) => ({
        paddingBottom: value,
      }),
    },
    {
      values: {
        none: '0',
        xxsm: '40px',
        xsm: '80px',
        sm: '100px',
        md: '160px',
        lg: '210px',
      },
    }
  );
});