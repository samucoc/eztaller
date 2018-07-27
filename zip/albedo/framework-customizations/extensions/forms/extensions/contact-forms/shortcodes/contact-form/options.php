<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

global $wplab_albedo_core;

$options = array(
	'main' => array(
		'type'    => 'box',
		'title'   => '',
		'options' => array(
			'id'       => array(
				'type'  => 'unique',
			),
			'builder'  => array(
				'type'    => 'tab',
				'title'   => esc_html__( 'Form Fields', 'albedo' ),
				'options' => array(
					'form' => array(
						'label' => false,
						'type'  => 'form-builder',
						'value' => array(
							'json' => apply_filters('fw:ext:forms:builder:load-item:form-header-title', true)
								? json_encode( array(
									array(
										'type'      => 'form-header-title',
										'shortcode' => 'form_header_title',
										'width'     => '',
										'options'   => array(
											'title'    => '',
											'subtitle' => '',
										)
									)
								) )
								: '[]'
						),
						'fixed_header' => true,
					),
				),
			),
			'styling' => array(
				'type'    => 'tab',
				'title'   => esc_html__( 'Styling', 'albedo' ),
				'options' => array(
					'form_style' => array(
						'label' => esc_html__( 'Form Style', 'albedo' ),
						'desc' => esc_html__( 'can be used to change color scheme', 'albedo' ),
						'type' => 'select',
						'value' => '',
						'choices' => array(
							'white' => esc_html__( 'White', 'albedo' ),
							'white_alt' => esc_html__( 'White, alternate style', 'albedo' ),
							'dark' => esc_html__( 'Dark', 'albedo' ),
							'dark_alt' => esc_html__( 'Dark, alternate style', 'albedo' ),
						),
					),
					'form_boxed' => array(
						'type' => 'multi-picker',
						'label' => false,
						'desc' => false,
						'picker' => array(
							'enabled' => array(
								'label' => esc_html__( 'Boxed form style', 'albedo' ),
								'desc' => esc_html__('Apply boxed style for a form container', 'albedo'),
								'type' => 'switch',
								'right-choice' => array(
									'value' => 'yes',
									'label' => esc_html__( 'Yes', 'albedo' )
								),
								'left-choice' => array(
									'value' => 'no',
									'color' => '#ccc',
									'label' => esc_html__( 'No', 'albedo' )
								),
								'value' => 'no',
							)
						),
						'choices' => array(
							'yes' => array(

								'box_style' => array(
									'label' => esc_html__( 'Box Style', 'albedo' ),
									'desc' => esc_html__( 'Light box style should be used within a Light form style, the same applies to dark styles', 'albedo' ),
									'type' => 'select',
									'value' => 'light',
									'choices' => array(
										'light' => esc_html__( 'Light', 'albedo' ),
										'dark' => esc_html__( 'Dark', 'albedo' ),
									),
								),

							)
						)
					),
					'inputs_style' => array(
						'label' => esc_html__( 'Inputs Style', 'albedo' ),
						'type' => 'select',
						'value' => 'rounded',
						'choices' => array(
							'rounded' => esc_html__( 'Rounded', 'albedo' ),
							'square' => esc_html__( 'Square', 'albedo' ),
						),
					),
					'submit_style'  => array(
						'label'   => esc_html__( 'Submit Button Style', 'albedo' ),
						'desc'    => esc_html__( 'Here you can choose pre-defined styles for a submit button', 'albedo' ),
						'type'    => 'select',
						'choices' => $wplab_albedo_core->cfg['button_styles']
					),
				)
			),
			'settings' => array(
				'type'    => 'tab',
				'title'   => esc_html__( 'Settings', 'albedo' ),
				'options' => array(
					'settings-options' => array(
						'title'   => esc_html__( 'Options', 'albedo' ),
						'type'    => 'tab',
						'options' => array(
							'form_email_settings' => array(
								'type'    => 'group',
								'options' => array(
									'email_to' => array(
										'type'  => 'text',
										'label' => esc_html__( 'Email To', 'albedo' ),
										'help' => esc_html__( 'We recommend you to use an email that you verify often', 'albedo' ),
										'desc'  => esc_html__( 'The form will be sent to this email address.', 'albedo' ),
									),
								),
							),
							'form_text_settings'  => array(
								'type'    => 'group',
								'options' => array(
									'subject-group' => array(
										'type' => 'group',
										'options' => array(
											'subject_message'    => array(
												'type'  => 'text',
												'label' => esc_html__( 'Subject Message', 'albedo' ),
												'desc' => esc_html__( 'This text will be used as subject message for the email', 'albedo' ),
												'value' => esc_html__( 'New message', 'albedo' ),
											),
										)
									),
									'submit-button-group' => array(
										'type' => 'group',
										'options' => array(
											'submit_button_text' => array(
												'type'  => 'text',
												'label' => esc_html__( 'Submit Button', 'albedo' ),
												'desc' => esc_html__( 'This text will appear in submit button', 'albedo' ),
												'value' => esc_html__( 'Send', 'albedo' ),
											),
										)
									),
									'success-group' => array(
										'type' => 'group',
										'options' => array(
											'success_message'    => array(
												'type'  => 'text',
												'label' => esc_html__( 'Success Message', 'albedo' ),
												'desc' => esc_html__( 'This text will be displayed when the form will successfully send', 'albedo' ),
												'value' => esc_html__( 'Message sent!', 'albedo' ),
											),
										)
									),
									'failure_message'    => array(
										'type'  => 'text',
										'label' => esc_html__( 'Failure Message', 'albedo' ),
										'desc' => esc_html__( 'This text will be displayed when the form will fail to be sent', 'albedo' ),
										'value' => esc_html__( 'Oops something went wrong.', 'albedo' ),
									),
								),
							),
						)
					),
					'mailer-options'   => array(
						'title'   => esc_html__( 'Mailer', 'albedo' ),
						'type'    => 'tab',
						'options' => array(
							'mailer' => array(
								'label' => false,
								'type'  => 'mailer'
							)
						)
					)
				),
			),
			'redirect' => array(
				'type'    => 'tab',
				'title'   => esc_html__( 'Form redirect', 'albedo' ),
				'options' => array(

					'redirect_on_success' => array(
						'type'  => 'text',
						'label' => esc_html__( 'Redirect on success', 'albedo' ),
						'desc' => esc_html__( 'Type here any URL where user will be redirected after form submit, e.g. to the Thank You page.', 'albedo' ),
					),

				)
			),
		),
	)
);
