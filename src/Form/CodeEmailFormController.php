<?php
	namespace App\Form;

	use Symfony\Component\Form\AbstractType;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\Form\FormBuilderInterface;
	use Symfony\Component\OptionsResolver\OptionsResolver;
	use Symfony\Component\Form\Extension\Core\Type\IntegerType;
	use Symfony\Component\Form\Extension\Core\Type\SubmitType;
	use App\Entity\CodeEmailForm;

	class CodeEmailFormController extends AbstractType
	{
		public function buildForm(FormBuilderInterface $builder, array $options) {
			$builder
					->setMethod("POST")
					->setAction("/resetPassword")
					->add('code', IntegerType::class, array('attr' => array('class' => 'loginInput ds', 'placeholder' => 'Введите код из email', 'max' => 999999, 'min' => 0), 'label' => false))
					->add('submit', SubmitType::class, array('attr' => array('class' => 'submitLogin ds'), 'label' => 'Отправить'));
		}

		public function configureOptions(OptionsResolver $resolver) {
			$resolver->setDefaults(array(
				'data_class' => CodeEmailForm::class
			));
		}
	}
?>