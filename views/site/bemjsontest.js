([
    {
      block: 'content005',
      row: true,
      content: [
        {
          elem: 'title',
          utils: ['one-line--center', 'no-margin-top'],
          phpParam: 'title',
          editable: true
        },
        {
          elem: 'nested',
          content: [
            {
              block: 'icon',
              icon: '001-consultation',
            },
            {
              elem: 'text-wrap',
              content: [
                {
                  elem: 'title-nested',
                  content: 'Классное преимущество, всем нравится{{phpParam:AZAZAZ}}'
                },
                {
                  elem: 'text',
                  phpParam: 'title',
                  content: [
                    {
                      content: 'Lorem ipsum dolor sit amet, consec{{phpParam:title}}tetur adipisicing elit. Quos suscipit officia quod quam illo in et beatae amet fuga, laudantium!'
                    },
                    {
                      block: 'button',
                      content: 'click me'
                    }
                  ]
                }
              ]
            }
          ]
        },
        {
          elem: 'nested',
          content: [
            {
              block: 'icon',
              icon: '001-consultation'
            },
            {
              elem: 'text-wrap',
              content: [
                {
                  elem: 'title-nested',
                  content: 'Классное преимущество, всем нравится'
                },
                {
                  elem: 'text',
                  content: 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quos suscipit officia quod quam illo in et beatae amet fuga, laudantium!'
                }
              ]
            }
          ]
        },
        {
          elem: 'nested',
          content: [
            {
              block: 'icon',
              icon: '001-consultation'
            },
            {
              elem: 'text-wrap',
              content: [
                {
                  elem: 'title-nested',
                  content: 'Классное преимущество, всем нравится'
                },
                {
                  elem: 'text',
                  content: 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quos suscipit officia quod quam illo in et beatae amet fuga, laudantium!'
                }
              ]
            }
          ]
        }
      ]
    }
  ]
)();