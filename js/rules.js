var addRuleType = BBLogic.api.addRuleType
var __ = BBLogic.i18n.__

// Paged
addRuleType( 'extra-conditional-logic-for-bb/paged', {
    label: __( 'Archive Page' ),
    category: 'archive',
    form: {
        operator: {
            type: 'operator',
            operators: [
                'equals',
                'does_not_equal',
                'is_less_than',
                'is_greater_than',
            ],
        },
        value: {
            type: 'number',
            defaultValue: '0',
        },
    },
});

// Post Format
addRuleType( 'extra-conditional-logic-for-bb/post-format', {
    label: __( 'Post Format' ),
    category: 'post',
    form: {
        operator: {
            type: 'operator',
            operators: [
                'equals',
                'does_not_equal',
            ],
        },
        format: {
            type: 'select',
            options: [
              {
                label: 'Standard',
                value: 'standard',
              },
              {
                label: 'Aside',
                 value: 'aside',
              },
              {
                label: 'Audio',
                value: 'audio',
              },
              {
                label: 'Chat',
                value: 'chat',
              },
              {
                label: 'Gallery',
                value: 'gallery',
              },
              {
                label: 'Image',
                value: 'image',
              },
              {
                label: 'Link',
                value: 'link',
              },
              {
                label: 'Quote',
                value: 'quote',
              },
              {
                label: 'Status',
                value: 'status',
              },
              {
                label: 'Video',
                value: 'video',
              },
            ]
          },
    },
});

// User country code
addRuleType( 'extra-conditional-logic-for-bb/user-country-code', {
    label: __( 'User Country Code' ),
    category: 'user',
    form: {
        operator: {
            type: 'operator',
            operators: [
                'equals',
                'does_not_equal',
                'contains',
                'does not contain',
            ],
        },
        compare: {
            type: 'text',
            defaultValue: 'US',
        },
    },
} );