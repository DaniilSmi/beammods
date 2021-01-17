<?php
	namespace App\Form;


	use App\Entity\RegisterForm;
	//use App\Entity\Task;
	use Symfony\Component\Form\AbstractType;

	use Symfony\Component\Form\FormBuilderInterface;
	use Symfony\Component\Form\Extension\Core\Type\TextType;
	use Symfony\Component\Form\Extension\Core\Type\PasswordType;
	use Symfony\Component\Form\Extension\Core\Type\EmailType;
	use Symfony\Component\Form\Extension\Core\Type\SubmitType;
	use Symfony\Component\OptionsResolver\OptionsResolver;

	/* creating form */
	class RegisterController extends AbstractType
	{
		public function buildForm(FormBuilderInterface $builder, array $options) {
				$builder
            ->add('login', TextType::class, array('attr' => array('class' => 'loginInput', 'placeholder' => 'Введите логин'), 'label' => false))
            ->add('email', EmailType::class, array('attr' => array('class' => 'loginInput', 'placeholder' => 'Введите email'), 'label' => false))
            ->add('password1', PasswordType::class, array('attr' => array('class' => 'loginInput', 'placeholder' => 'Введите пароль'), 'label' => false))
            ->add('password2', PasswordType::class, array('attr' => array('class' => 'loginInput', 'placeholder' => 'Введите пароль'), 'label' => false))
            ->add('submitLogin', SubmitType::class, array('attr' => array('class' => 'submitLogin'), 'label' => 'Регистрация'));
	

		}

	

		public function configureOptions(OptionsResolver $resolver)
		{
    $resolver->setDefaults(array(
        'data_class' => RegisterForm::class,
    ));
		}
}
?>