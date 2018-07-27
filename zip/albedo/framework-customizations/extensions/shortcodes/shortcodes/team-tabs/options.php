<?php if (!defined('FW')) die('Forbidden');

global $wplab_albedo_core;

$options = array(
	'id' => array( 'type' => 'unique' ),
	'general' => array(
		'title' => esc_html__( 'General', 'albedo' ),
		'type' => 'tab',
		'options' => array(

			'block_title' => array(
				'type'  => 'text',
				'label' => esc_html__('Block title', 'albedo'),
				'value' => esc_html__('Meet The Team', 'albedo'),
			),
			'block_text' => array(
				'type'  => 'textarea',
				'label' => esc_html__('Block text', 'albedo'),
				'value' => esc_html__('We Make Beautiful Things...', 'albedo'),
			),
			'items' => array(
				'type'          => 'addable-popup',
				'label'         => esc_html__( 'Team Members', 'albedo' ),
				'popup-title'   => esc_html__( 'Add/Edit Team Member', 'albedo' ),
				'desc'          => esc_html__( 'Create your team', 'albedo' ),
				'template'      => '{{=name}}',
				'popup-options' => array(
					'photo' => array(
						'label' => esc_html__('Photo', 'albedo'),
						'type' => 'background-image',
					),
					'content_photo' => array(
						'label' => esc_html__('Content Photo', 'albedo'),
						'type' => 'background-image',
					),
					'name' => array(
						'type'  => 'text',
						'label' => esc_html__('Name', 'albedo')
					),
					'position' => array(
						'type'  => 'text',
						'label' => esc_html__('Position', 'albedo')
					),
					'free_text' => array(
						'type'  => 'textarea',
						'label' => esc_html__('Free Text', 'albedo')
					),
				) + wplab_albedo_utils::get_social_cfg_usyon(),
			),
			'animation_effect' => array(
				'label' => esc_html__( 'Animation Effect', 'albedo' ),
				'type' => 'select',
				'choices' => $wplab_albedo_core->cfg['animations'],
				'value' => 'fadeInUp',
			),
		)
	),
);
