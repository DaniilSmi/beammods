<?php
	namespace App\Form;


	use App\Entity\LoginForm;
	//use App\Entity\Task;
	use Symfony\Component\Form\AbstractType;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\Form\FormBuilderInterface;
	use Symfony\Component\Form\Extension\Core\Type\TextType;
	use Symfony\Component\Form\Extension\Core\Type\PasswordType;
	use Symfony\Component\Form\Extension\Core\Type\SubmitType;
	use Symfony\Component\OptionsResolver\OptionsResolver;

	class LoginController extends AbstractType
	{
		public function buildForm(FormBuilderInterface $builder, array $options) {
				$builder
						->setAction('/login')
						->setMethod('POST')
            ->add('loginEmail', TextType::class, array('attr' => array('class' => 'loginInput', 'placeholder' => 'Введите логин или email'), 'label' => false))
            ->add('passwordInput', PasswordType::class, array('attr' => array('class' => 'loginInput', 'placeholder' => 'Введите пароль'), 'label' => false))
            ->add('submitLogin', SubmitType::class, array('attr' => array('class' => 'submitLogin'), 'label' => 'Войти',));
		}
		public function configureOptions(OptionsResolver $resolver)
		{
    $resolver->setDefaults(array(
        'data_class' => LoginForm::class
    ));
		}
}
?>