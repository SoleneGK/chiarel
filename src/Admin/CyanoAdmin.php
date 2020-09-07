<?php

namespace App\Admin;

use App\Entity\Tag;
use App\Entity\Series;
use App\Entity\Technique;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelType;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

final class CyanoAdmin extends AbstractAdmin
{
	protected function configureFormFields(FormMapper $form)
	{
		$form
			->with('Cyano')
				->add('file', FileType::class, [
					'required' => false,
				])
				->add('title', TextType::class, [
					'label' => 'Titre',
				])
				->add('description', TextareaType::class, [
					'label' => 'Description',
					'required' => false,
				])
			->end()
			->with('Métadonnées')
				->add('series', ModelType::class, [
					'class' => Series::class,
					'property' => 'name',
					'label' => 'Série',
					'required' => false,
				])
				->add('technique', ModelType::class, [
					'class' => Technique::class,
					'property' => 'name',
					'label' => 'Technique',
					'required' => false,
				])
				->add('creation_date', DateType::class, [
					'widget' => 'single_text',
					'label' => 'Date de création',
					'required' => false,
				])
				->add('height', NumberType::class, [
					'label' => 'Hauteur (en cm)',
					'required' => false,
				])
				->add('width', NumberType::class, [
					'label' => 'Largeur (en cm)',
					'required' => false,
				])
				->add('tags', ModelType::class, [
					'class' => Tag::class,
					'property' => 'name',
					'multiple' => true,
					'required' => false,
					'label' => 'Tags',
				])
			->end()
			->with('Publication')
				->add('active', CheckboxType::class, [
					'label' => 'Publier le cyano',
					'required' => false,
				])
				->add('etsy_id', IntegerType::class, [
					'label' => 'Id Etsy',
					'required' => false,
				])
			->end()
		;
	}

	protected function configureDatagridFilters(DatagridMapper $filter)
	{
		$filter
			->add('title', null, [
				'label' => 'Titre',
			])
			->add('series', null, [
				'label' => 'Série',
			])
			->add('tags', null, [
				'label' => 'Tags',
			])
			->add('active', null, [
				'label' => 'Publié',
			])
		;
	}

	protected function configureListFields(ListMapper $list)
	{
		$list
			->add('file_name', null, [
				'label' => 'Image',
				'template' => 'custom-sonata/list_image.html.twig',
			])
			->addIdentifier('title', null, [
				'label' => 'Titre',
				'route' => [
					'name' => 'show',
				],
			])
			->add('series', null, [
				'label' => 'Série',
				'route' => [
					'name' => 'show',
				],
			])
			->add('tags', null, [
				'label' => 'Tags',
				'route' => [
					'name' => 'show',
				],
			])
			->add('active', null, [
				'label' => 'Publié',
				'editable' => true,
			])
			->add('_action', null, [
				'actions' => [
					'edit' => []
				],
			])
		;
	}

	protected function configureShowFields(ShowMapper $show)
	{
		$show
			->with('Cyano')
				->add('file_name', null, [
					'label' => 'Image',
				])
				->add('title', 'string', [
					'label' => 'Titre',
				])
				->add('description', 'string', [
					'label' => 'Description',
				])
			->end()
			->with('Médadonnées')
				->add('series', null, [
					'label' => 'Série',
					'route' => [
						'name' => 'show',
					],
				])
				->add('technique', null, [
					'label' => 'Technique',
					'route' => [
						'name' => 'show',
					],
				])
				->add('creation_date', null, [
					'label' => 'Date de création',
				])
				->add('height', null, [
					'label' => 'Hauteur (en cm)',
				])
				->add('width', null, [
					'label' => 'Largeur (en cm)',
				])
				->add('tags', null, [
					'label' => 'Tags',
					'route' => [
						'name' => 'show',
					],
				])
			->end()
			->with('Publication')
				->add('active', null, [
					'label' => 'Publié',
				])
				->add('etsy_id', null, [
					'label' => 'Id etsy',
				])
			->end()
		;
	}
}