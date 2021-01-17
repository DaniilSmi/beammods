<?php
	namespace App\Form;

	use Symfony\Component\Form\AbstractType;
	use Symfony\Component\Form\FormBuilderInterface;
	use Symfony\Component\Form\Extension\Core\Type\TextType;
	use Symfony\Component\Form\Extension\Core\Type\EmailType;
	use Symfony\Component\Form\Extension\Core\Type\PasswordType;
	use Symfony\Component\Form\Extension\Core\Type\SubmitType;
	use Symfony\Component\OptionsResolver\OptionsResolver;
	use App\Entity\ProfileInfoForm;

	
	class ProfileInfoFormController extends AbstractType
	{
		public function buildForm(FormBuilderInterface $builder, array $options) {
			$builder
					->setAction('/profile')
					->setMethod("POST")
					->add('login', TextType::class, array('attr' => array('class' => 'loginInput', 'placeholder' => 'Введите новый логин'), 'label' => false))
					->add('email', EmailType::class, array('attr' => array('class' => 'loginInput', 'placeholder' => 'Введите новый email'), 'label' => false))
					->add('password', PasswordType::class, array('attr' => array('class' => 'loginInput', 'placeholder' => 'Введите ваш пароль'), 'label' => false))
					->add('submit', SubmitType::class, array('attr' => array('class' => 'submitLogin'), 'label' => 'Изменить'));
		}

		public function configureOptions(OptionsResolver $resolver) {
			$resolver->setDefaults(array(
				'data_class' => ProfileInfoForm::class,
			));
		}
	}

?>