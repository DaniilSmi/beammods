<?php
	namespace App\Form;


	use App\Entity\UserFormAdmin;
	//use App\Entity\Task;
	use Symfony\Component\Form\AbstractType;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\Form\FormBuilderInterface;
	use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
	use Symfony\Component\Form\Extension\Core\Type\TextType;
	use Symfony\Component\Form\Extension\Core\Type\SubmitType;
	use Symfony\Component\OptionsResolver\OptionsResolver;

	class UserFormAdminController extends AbstractType
	{
		public function buildForm(FormBuilderInterface $builder, array $options) {
				$builder
						->add('id', TextType::class, array())
						->add('delete', CheckboxType::class, array('attr' => array(), 'label' => 'Удалить?'))
            ->add('submitLogin', SubmitType::class, array('attr' => array('class' => 'adsubmitLogin'), 'label' => 'Войти'));
		}
		public function configureOptions(OptionsResolver $resolver)
		{
    $resolver->setDefaults(array(
        'data_class' => UserFormAdmin::class
    ));
		}
}
?>