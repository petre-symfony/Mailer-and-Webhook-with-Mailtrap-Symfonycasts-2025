<?php

namespace App\Form;

use App\Dto\BookingDto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookingType extends AbstractType {
	public function buildForm(FormBuilderInterface $builder, array $options): void {
		$builder
			->add('name')
			->add('email', EmailType::class)
			->add('date', DateType::class, [
				'input' => 'datetime_immutable',
			]);
	}

	public function configureOptions(OptionsResolver $resolver): void {
		$resolver->setDefaults([
			'data_class' => BookingDto::class,
		]);
	}
}
