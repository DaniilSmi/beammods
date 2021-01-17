<?php
	namespace App\Form;


	use App\Entity\AdminlogForm;
	//use App\Entity\Task;
	use Symfony\Component\Form\AbstractType;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\Form\FormBuilderInterface;
	use Symfony\Component\Form\Extension\Core\Type\TextType;
	use Symfony\Component\Form\Extension\Core\Type\PasswordType;
	use Symfony\Component\Form\Extension\Core\Type\SubmitType;
	use Symfony\Component\OptionsResolver\OptionsResolver;

	class AdminlogFormController extends AbstractType
	{
		public function buildForm(FormBuilderInterface $builder, array $options) {
				$builder
            ->add('login', TextType::class, array('attr' => array('class' => 'adloginInput'), 'label' => 'Логин'))
            ->add('password', PasswordType::class, array('attr' => array('class' => 'adloginInput'), 'label' => 'Пароль'))
            ->add('submitLogin', SubmitType::class, array('attr' => array('class' => 'adsubmitLogin'), 'label' => 'Войти',));
		}
		public function configureOptions(OptionsResolver $resolver)
		{
    $resolver->setDefaults(array(
        'data_class' => AdminlogForm::class
    ));
		}
}
?>