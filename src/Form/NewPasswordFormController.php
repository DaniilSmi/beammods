<?php
	namespace App\Form;

	use App\Entity\NewPasswordForm;
	use Symfony\Component\Form\AbstractType;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\Form\FormBuilderInterface;
	use Symfony\Component\Form\Extension\Core\Type\PasswordType;
	use Symfony\Component\Form\Extension\Core\Type\SubmitType;
	use Symfony\Component\OptionsResolver\OptionsResolver;

	class NewPasswordFormController extends AbstractType
	{
		public function buildForm(FormBuilderInterface $builder, array $options) {
			$builder
					->setMethod("POST")
					->setAction("/resetPassword2")
					->add('password1', PasswordType::class, array('attr' => array('class' => 'loginInput', 'placeholder' => 'Введите пароль'), 'label' => false))
					->add('password2', PasswordType::class, array('attr' => array('class' => 'loginInput', 'placeholder' => 'Подтвердите пароль'), 'label' => false))
					->add('submit', SubmitType::class, array('attr' => array('class' => 'submitLogin'), 'label' => 'Отправить'));
		}

		public function configureOptions(OptionsResolver $resolver) {
			$resolver->setDefaults(array(
				'data_class' => NewPasswordForm::class,
			));
		}
	}
?>