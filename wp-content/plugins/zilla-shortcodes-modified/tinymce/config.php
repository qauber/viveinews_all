<?php

/*-----------------------------------------------------------------------------------*/
/*	Button Config
/*-----------------------------------------------------------------------------------*/

$zilla_shortcodes['button'] = array(
	'no_preview' => true,
	'params' => array(
		'url' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Button URL', 'bingo'),
			'desc' => __('Add the button\'s url eg http://example.com', 'bingo')
		),
		'color' => array(
			'type' => 'select',
			'label' => __('Button Style', 'bingo'),
			'desc' => __('Select the button\'s style, ie the button\'s colour', 'bingo'),
			'options' => array(
				'one' => 'Primary',
				'two' => 'Secondary',
				'three' => 'Tertiary',

			)
		),

		'type' => array(
			'type' => 'select',
			'label' => __('Button Type', 'bingo'),
			'desc' => __('Select the button\'s type', 'bingo'),
			'options' => array(
				'default' => 'Default',
				'skill' => 'Skill'
			)
		),
		'target' => array(
			'type' => 'select',
			'label' => __('Button Target', 'bingo'),
			'desc' => __('_self = open in same window. _blank = open in new window', 'bingo'),
			'options' => array(
				'_self' => '_self',
				'_blank' => '_blank'
			)
		),
		'icon' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Icon', 'bingo'),
			'desc' => __('http://fortawesome.github.io/Font-Awesome/icons/', 'bingo'),
		),

		'content' => array(
			'std' => 'Button Text',
			'type' => 'text',
			'label' => __('Button\'s Text', 'bingo'),
			'desc' => __('Add the button\'s text', 'bingo'),
		)
	),
	'shortcode' => '[button url="{{url}}" icon="{{icon}}" color="{{color}}" type="{{type}}" target="{{target}}"] {{content}} [/button]',
	'popup_title' => __('Insert Button Shortcode', 'bingo')
);



/*-----------------------------------------------------------------------------------*/
/*	video Config
/*-----------------------------------------------------------------------------------*/

$zilla_shortcodes['video'] = array(
	'no_preview' => true,
	'params' => array(

		'host' => array(

			'type' => 'select',
			'label' => __('Host Name', 'bingo'),
			'desc' => __('Select the host name', 'bingo'),
			'options' => array(
				'youtube'     => 'YouTube',
				'vimeo'       => 'Vimeo',
				'dailymotion' => 'Dailymotion',
			)
		),
		'video_id' => array(
			'std' => 'Video ID',
			'type' => 'text',
			'label' => __('Video id', 'bingo'),
			'desc' => __('add the video id', 'bingo'),
		)
	),
	'shortcode' => '[xxl_video type="{{host}}" video_id="{{video_id}}" ][/xxl_video]',
	'popup_title' => __('Insert Video Shortcode', 'bingo')
);



// [progress title ="Web programmer" score ="100" type="two" text="se din dujone dulechilam bone"]

/*-----------------------------------------------------------------------------------*/
/*	Progress Config
/*-----------------------------------------------------------------------------------*/


$zilla_shortcodes['progress'] = array(
	'no_preview' => true,
	'params' => array(

		'type' => array(
			'type' => 'select',
			'label' => __('Type', 'bingo'),
			'desc' => __('Select the type', 'bingo'),
			'options' => array(
				'one'     => 'Default',
				'two'       => 'With Toggle',
				'three' => 'Deep',
				'four' => 'Radial',
			)
		),
		'title' => array(
			'std' => 'Title',
			'type' => 'text',
			'label' => __('Title', 'bingo'),
			'desc' => __('add the title', 'bingo'),
		),
		'score' => array(
			'std' => '50',
			'type' => 'text',
			'label' => __('Score', 'bingo'),
			'desc' => __('Please add integer value', 'bingo'),
		),
		'alltext' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Hidden Text', 'bingo'),
			'desc' => __('add hidden text only in toggle type', 'bingo'),
		),


	),
	'shortcode' => '[progress title="{{title}}" type="{{type}}" score="{{score}}"   text="{{alltext}}" ]',
	'popup_title' => __('Insert Progress Shortcode', 'bingo')
);






/*-----------------------------------------------------------------------------------*/
/*	download Config
/*-----------------------------------------------------------------------------------*/


$zilla_shortcodes['download'] = array(
	'no_preview' => true,
	'params' => array(


		'title' => array(
			'std' => 'Title',
			'type' => 'text',
			'label' => __('Title', 'bingo'),
			'desc' => __('add the title', 'bingo'),
		),
		'description' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Description', 'bingo'),
			'desc' => __('', 'bingo'),
		),
		'extension' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Extension', 'bingo'),
			'desc' => __('add extension like .pdf', 'bingo'),
		),


	),
	'shortcode' => '[download title="{{title}}"  description="{{description}}"   extension="{{extension}}" ]',
	'popup_title' => __('Insert Progress Shortcode', 'bingo')
);










/*-----------------------------------------------------------------------------------*/
/*	Alert Config
/*-----------------------------------------------------------------------------------*/

$zilla_shortcodes['alert'] = array(
	'no_preview' => true,
	'params' => array(
		'style' => array(
			'type' => 'select',
			'label' => __('Alert Style', 'bingo'),
			'desc' => __('Select the alert\'s style, ie the alert colour', 'bingo'),
			'options' => array(
				'white' => 'White',
				'grey' => 'Grey',
				'red' => 'Red',
				'yellow' => 'Yellow',
				'green' => 'Green'
			)
		),
		'content' => array(
			'std' => 'Your Alert!',
			'type' => 'textarea',
			'label' => __('Alert Text', 'bingo'),
			'desc' => __('Add the alert\'s text', 'bingo'),
		)

	),
	'shortcode' => '[zilla_alert style="{{style}}"] {{content}} [/zilla_alert]',
	'popup_title' => __('Insert Alert Shortcode', 'bingo')
);

/*-----------------------------------------------------------------------------------*/
/*	Toggle Config
/*-----------------------------------------------------------------------------------*/

$zilla_shortcodes['toggle'] = array(
	'no_preview' => true,
	'params' => array(
		'title' => array(
			'type' => 'text',
			'label' => __('Toggle Content Title', 'bingo'),
			'desc' => __('Add the title that will go above the toggle content', 'bingo'),
			'std' => 'Title'
		),
		'content' => array(
			'std' => 'Content',
			'type' => 'textarea',
			'label' => __('Toggle Content', 'bingo'),
			'desc' => __('Add the toggle content. Will accept HTML', 'bingo'),
		),
		'state' => array(
			'type' => 'select',
			'label' => __('Toggle State', 'bingo'),
			'desc' => __('Select the state of the toggle on page load', 'bingo'),
			'options' => array(
				'open' => 'Open',
				'closed' => 'Closed'
			)
		),

	),
	'shortcode' => '[zilla_toggle title="{{title}}" state="{{state}}"] {{content}} [/zilla_toggle]',
	'popup_title' => __('Insert Toggle Content Shortcode', 'bingo')
);

/*-----------------------------------------------------------------------------------*/
/*	Tabs Config
/*-----------------------------------------------------------------------------------*/

$zilla_shortcodes['tabs'] = array(
    'params' => array(
		'type' => array(
			'type' => 'select',
			'label' => __('Tab Direction', 'bingo'),
			'desc' => __('Select the direction of Tab on page load', 'bingo'),
			'options' => array(
				'top' => 'Top',
				'vertical' => 'Vertical',

			)
		),

   	),
    'no_preview' => true,
    'shortcode' => '[tabs type="{{type}}"] {{child_shortcode}}  [/tabs]',
    'popup_title' => __('Insert Tab Shortcode', 'bingo'),

    'child_shortcode' => array(
        'params' => array(

		'type' => array(
			'type' => 'select',
			'label' => __('Tab Active', 'bingo'),
			'desc' => __('please select this just for one', 'bingo'),
			'options' => array(
				'' => '',
				'true' => 'true',

			),
		),

            'title' => array(
                'std' => 'Title',
                'type' => 'text',
                'label' => __('Tab Title', 'bingo'),
                'desc' => __('Title of the tab', 'bingo'),
            ),
            'content' => array(
                'std' => 'Tab Content',
                'type' => 'textarea',
                'label' => __('Tab Content', 'bingo'),
                'desc' => __('Add the tabs content', 'bingo')
            )
        ),
        'shortcode' => '[tab active="{{type}}" title="{{title}}"] {{content}} [/tab]',
        'clone_button' => __('Add Tab', 'bingo')
    )
);



// [accordion ]
// [aitem title="Web Developer at Envato" subtitle="September 2007 - June 2013"]





/*-----------------------------------------------------------------------------------*/
/*	accordion Config
/*-----------------------------------------------------------------------------------*/

$zilla_shortcodes['accordion'] = array(
    'params' => array(),
    'no_preview' => true,
    'shortcode' => '[accordion] {{child_shortcode}}  [/accordion]',
    'popup_title' => __('Insert Accordion Shortcode', 'bingo'),

    'child_shortcode' => array(
        'params' => array(

            'title' => array(
                'std' => 'Title',
                'type' => 'text',
                'label' => __('Title', 'bingo'),
                'desc' => __('', 'bingo'),
            ),
            'subtitle' => array(
                'std' => 'Subtitle',
                'type' => 'text',
                'label' => __('Subtitle', 'bingo'),
                'desc' => __('', 'bingo')
            ),
            'content' => array(
                'std' => 'Content',
                'type' => 'textarea',
                'label' => __('Content', 'bingo'),
                'desc' => __('Add content', 'bingo')
            )

        ),
        'shortcode' => '[aitem title="{{title}}" subtitle="{{subtitle}}"] {{content}} [/aitem]',
        'clone_button' => __('Add Accordion', 'bingo')
    )
);





// [timeline]
// [titem position="1" title="Master of Science - Harvard" subtitle="September 2007 - June 2013" ]
// [titem position="2" title="Master of Science - Harvard" subtitle="September 2007 - June 2013" ]
// [titem position="3" title="Master of Science - Harvard" subtitle="September 2007 - June 2013" ]
// [/timeline]



/*-----------------------------------------------------------------------------------*/
/*	timeline Config
/*-----------------------------------------------------------------------------------*/


$zilla_shortcodes['timeline'] = array(
    'params' => array(),
    'no_preview' => true,
    'shortcode' => '[timeline] {{child_shortcode}}  [/timeline]',
    'popup_title' => __('Insert Timeline Shortcode', 'bingo'),

    'child_shortcode' => array(
        'params' => array(

            'title' => array(
                'std' => 'Title',
                'type' => 'text',
                'label' => __('Title', 'bingo'),
                'desc' => __('', 'bingo'),
            ),
            'position' => array(
                'std' => '',
                'type' => 'text',
                'label' => __('Position', 'bingo'),
                'desc' => __('pleae give them a position number like : 1,2,3', 'bingo')
            ),


        ),
        'shortcode' => '[titem title="{{title}}" position="{{position}}" ]',
        'clone_button' => __('Add timeline item', 'bingo')
    )
);


// [list type="bullet"]
// [item]asdfsdlfja[/item]
// [item]asdfsdlfja[/item]
// [item]asdfsdlfja[/item]

// [/list]



/*-----------------------------------------------------------------------------------*/
/*	list Config
/*-----------------------------------------------------------------------------------*/


$zilla_shortcodes['list'] = array(
    'params' => array(
		'type' => array(
			'type' => 'select',
			'label' => __('List Style', 'bingo'),
			'desc' => __('Select list style', 'bingo'),
			'options' => array(
				'bullet' => 'Bullet',
				'check' => 'Check',
				'number' => 'Number',

			)
		),
    ),
    'no_preview' => true,
    'shortcode' => '[list type="{{type}}"] {{child_shortcode}}  [/list]',
    'popup_title' => __('Insert Timeline Shortcode', 'bingo'),

    'child_shortcode' => array(
        'params' => array(

            'content' => array(
                'std' => 'Content',
                'type' => 'text',
                'label' => __('Content', 'bingo'),
                'desc' => __('', 'bingo'),
            ),



        ),
        'shortcode' => '[item] {{content}} [/item]',
        'clone_button' => __('Add list item', 'bingo')
    )
);










// [profile name="Tareq Jobayere" birth="April 26, 1988" location="Rome,Italy" status="Employed" degree="MBA" permit="E.U." website="http://example.com"]


/*-----------------------------------------------------------------------------------*/
/*	Profile Config
/*-----------------------------------------------------------------------------------*/




$zilla_shortcodes['profile'] = array(
	'no_preview' => true,
	'params' => array(
		'name' => array(
			'type' => 'text',
			'label' => __('Name', 'bingo'),
			'desc' => __('Add your name', 'bingo'),
			'std' => 'Name'
		),
		'birth' => array(
			'type' => 'text',
			'label' => __('Birth', 'bingo'),
			'desc' => __('Add your birthday', 'bingo'),
			'std' => 'birth'
		),
		'location' => array(
			'type' => 'text',
			'label' => __('Location', 'bingo'),
			'desc' => __('Add your location', 'bingo'),
			'std' => 'Location'
		),

		'status' => array(
			'type' => 'text',
			'label' => __('Status', 'bingo'),
			'desc' => __('Add your status', 'bingo'),
			'std' => 'Status'
		),
		'degree' => array(
			'type' => 'text',
			'label' => __('Degree', 'bingo'),
			'desc' => __('Add your degree', 'bingo'),
			'std' => 'Degree'
		),
		'permit' => array(
			'type' => 'text',
			'label' => __('permit', 'bingo'),
			'desc' => __('', 'bingo'),
			'std' => 'Permit'
		),
		'website' => array(
			'type' => 'text',
			'label' => __('Website', 'bingo'),
			'desc' => __('', 'bingo'),
			'std' => 'Website'
		),




	),
	'shortcode' => '[profile name="{{name}}" birth="{{birth}}" location="{{location}}" status="{{status}}" degree="{{degree}}" permit="{{permit}}" website="{{website}}"]',
	'popup_title' => __('Insert Profile Shortcode', 'bingo')
);






/*-----------------------------------------------------------------------------------*/
/*	Columns Config
/*-----------------------------------------------------------------------------------*/

$zilla_shortcodes['columns'] = array(
	'params' => array(),
	'shortcode' => ' {{child_shortcode}} ', // as there is no wrapper shortcode
	'popup_title' => __('Insert Columns Shortcode', 'bingo'),
	'no_preview' => true,

	// child shortcode is clonable & sortable
	'child_shortcode' => array(
		'params' => array(
			'column' => array(
				'type' => 'select',
				'label' => __('Column Type', 'bingo'),
				'desc' => __('Select the type, ie width of the column.', 'bingo'),
				'options' => array(
					'zilla_one_third' => 'One Third',
					'zilla_one_third_last' => 'One Third Last',
					'zilla_two_third' => 'Two Thirds',
					'zilla_two_third_last' => 'Two Thirds Last',
					'zilla_one_half' => 'One Half',
					'zilla_one_half_last' => 'One Half Last',
					'zilla_one_fourth' => 'One Fourth',
					'zilla_one_fourth_last' => 'One Fourth Last',
					'zilla_three_fourth' => 'Three Fourth',
					'zilla_three_fourth_last' => 'Three Fourth Last',
					'zilla_one_fifth' => 'One Fifth',
					'zilla_one_fifth_last' => 'One Fifth Last',
					'zilla_two_fifth' => 'Two Fifth',
					'zilla_two_fifth_last' => 'Two Fifth Last',
					'zilla_three_fifth' => 'Three Fifth',
					'zilla_three_fifth_last' => 'Three Fifth Last',
					'zilla_four_fifth' => 'Four Fifth',
					'zilla_four_fifth_last' => 'Four Fifth Last',
					'zilla_one_sixth' => 'One Sixth',
					'zilla_one_sixth_last' => 'One Sixth Last',
					'zilla_five_sixth' => 'Five Sixth',
					'zilla_five_sixth_last' => 'Five Sixth Last'
				)
			),
			'content' => array(
				'std' => '',
				'type' => 'textarea',
				'label' => __('Column Content', 'bingo'),
				'desc' => __('Add the column content.', 'bingo'),
			)
		),
		'shortcode' => '[{{column}}] {{content}} [/{{column}}] ',
		'clone_button' => __('Add Column', 'bingo')
	)
);





/*-----------------------------------------------------------------------------------*/
/*	Buy Button Config
/*-----------------------------------------------------------------------------------*/

$zilla_shortcodes['buy_block'] = array(
	'no_preview' => true,
	'params' => array(

		'image' => array(
			'std' => 'Title',
			'type' => 'text',
			'label' => __('Image link', 'bingo'),
			'desc' => __('URL of the image you want to use', 'bingo'),
		),
		'purchase' => array(
			'std' => 'Purchase',
			'type' => 'text',
			'label' => __('Purchase button text', 'bingo'),
			'desc' => __('Text of the button of the Purchase button', 'bingo'),
		),
		'content' => array(
			'std' => '',
			'type' => 'textarea',
			'label' => __('Block text', 'bingo'),
			'desc' => __('Add the text content.', 'bingo'),
		)


	),
	'shortcode' => '[buy_theme image="{{image}}" puchase_text="{{purchase}}"] {{content}} [/buy_theme]',
	'popup_title' => __('Insert Buy block Shortcode', 'bingo')
);





/*-----------------------------------------------------------------------------------*/
/*	Project Block Config
/*-----------------------------------------------------------------------------------*/

$zilla_shortcodes['project_block'] = array(
	'no_preview' => true,
	'params' => array(

		'title' => array(
			'std' => 'Title',
			'type' => 'text',
			'label' => __('Title of the block', 'bingo'),
			'desc' => __('add the title of the block', 'bingo'),
		),
		'type' => array(
			'type' => 'select',
			'label' => __('Block type', 'bingo'),
			'desc' => __('Select the block type', 'bingo'),
			'options' => array(
				'one' => 'crowdfunding',
				'two' => 'rating',
				'three' => 'selling',
				'four' => 'auction',

			)
		),
		'content' => array(
			'std' => '',
			'type' => 'textarea',
			'label' => __('Block text', 'bingo'),
			'desc' => __('Add the text content.', 'bingo'),
		)

	),
	'shortcode' => '[project_block title="{{title}}" type="{{type}}"] {{content}} [/project_block]',
	'popup_title' => __('Insert Project block Shortcode', 'bingo')
);





/*-----------------------------------------------------------------------------------*/
/*	Testimonial Block Config
/*-----------------------------------------------------------------------------------*/

$zilla_shortcodes['testimonial_block'] = array(
	'no_preview' => true,
	'params' => array(

		'title' => array(
			'std' => 'Title',
			'type' => 'text',
			'label' => __('Title of the block', 'bingo'),
			'desc' => __('add the title of the block', 'bingo'),
		),
		'image' => array(
			'std' => 'Title',
			'type' => 'text',
			'label' => __('Image link', 'bingo'),
			'desc' => __('URL of the image you want to use', 'bingo'),
		),
		'content' => array(
			'std' => '',
			'type' => 'textarea',
			'label' => __('Block text', 'bingo'),
			'desc' => __('Add the text content.', 'bingo'),
		)

	),
	'shortcode' => '[testimonial_block title="{{title}}" image="{{image}}"] {{content}} [/testimonial_block]',
	'popup_title' => __('Insert Testimonial block Shortcode', 'bingo')
);


/*-----------------------------------------------------------------------------------*/
/*	Blockquotes Config
/*-----------------------------------------------------------------------------------*/

$zilla_shortcodes['blockquotes'] = array(
	'no_preview' => true,
	'params' => array(

		'cite' => array(
			'std' => 'Cite',
			'type' => 'text',
			'label' => __('Cite text', 'bingo'),
			'desc' => __('Please enter the cite text for blockquotes', 'bingo'),
		),
		'content' => array(
			'std' => '',
			'type' => 'textarea',
			'label' => __('Block text', 'bingo'),
			'desc' => __('Add the text content.', 'bingo'),
		)

	),
	'shortcode' => '[blockquotes cite="{{cite}}"] {{content}} [/blockquotes]',
	'popup_title' => __('Insert Blockquote Shortcode', 'bingo')
);





/*-----------------------------------------------------------------------------------*/
/*	Alert Config
/*-----------------------------------------------------------------------------------*/

$zilla_shortcodes['alert'] = array(
	'no_preview' => true,
	'params' => array(

		'title' => array(
			'std' => 'Title',
			'type' => 'text',
			'label' => __('Title of the block', 'bingo'),
			'desc' => __('add the title of the block', 'bingo'),
		),
		'type' => array(
			'type' => 'select',
			'label' => __('Alert type', 'bingo'),
			'desc' => __('Select the alert type', 'bingo'),
			'options' => array(
				'' => 'normal',
				'success' => 'success',
				'info' => 'info',
				'warning' => 'warning',
				'error' => 'error',

			)
		),
		'content' => array(
			'std' => '',
			'type' => 'textarea',
			'label' => __('Block text', 'bingo'),
			'desc' => __('Add the text content.', 'bingo'),
		)

	),
	'shortcode' => '[alert title="{{title}}" type="{{type}}"] {{content}} [/alert]',
	'popup_title' => __('Insert Project block Shortcode', 'bingo')
);



?>