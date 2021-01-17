<?php
	namespace App\Form;

	use App\Entity\EmailResetForm;
	use Symfony\Component\Form\AbstractType;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\Form\FormBuilderInterface;
	use Symfony\Component\Form\Extension\Core\Type\EmailType;
	use Symfony\Component\Form\Extension\Core\Type\SubmitType;
	use Symfony\Component\OptionsResolver\OptionsResolver;

	class EmailResetFormController extends AbstractType
	{
		public function buildForm(FormBuilderInterface $builder, array $options) {
			$builder
					->add('email', EmailType::class, array('attr' => array('class' => 'loginInput', 'placeholder' => 'Введите email'), 'label' => false))
					->add('submit', SubmitType::class, array('attr' => array('class' => 'submitLogin'), 'label' => 'Отправить'));
		}

		public function configureOptions(OptionsResolver $resolver) {
			$resolver->setDefaults(array(
				'data_class' => EmailResetForm::class,
			));
		}
	}
?>