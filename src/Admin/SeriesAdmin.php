<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;

final class SeriesAdmin extends AbstractAdmin
{
	protected function configureFormFields(FormMapper $form)
	{
		$form->add('name', TextType::class, [
			'label' => 'Nom',
		]);
	}

	protected function configureDatagridFilters(DatagridMapper $filter)
	{
		$filter->add('name', null, [
			'label' => 'Nom',
		]);
	}

	protected function configureListFields(ListMapper $list)
	{
		$list
			->addIdentifier('name', null, [
				'label' => 'Nom',
				'route' => [
					'name' => 'show',
				]
			])
			->add('slug', null, [
				'label' => 'Slug',
			])
			->add('_action', null, [
				'actions' => [
					'edit' => []
				]
			])
		;
	}

	protected function configureShowFields(ShowMapper $show)
	{
		$show
			->add('name', 'string', [
				'label' => 'Nom',
			])
			->add('slug', 'string', [
				'label' => 'Slug',
			])
			->add('photos', null, [
				'route' => [
					'name' => 'show'
				],
				'label' => 'Photos',
			])
			->add('cyanos', null, [
				'route' => [
					'name' => 'show'
				],
				'label' => 'Cyanos',
			])
		;
	}
}