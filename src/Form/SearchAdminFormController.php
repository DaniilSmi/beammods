<?php
	namespace App\Form;


	use App\Entity\SearchAdminForm;
	//use App\Entity\Task;
	use Symfony\Component\Form\AbstractType;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\Form\FormBuilderInterface;
	use Symfony\Component\Form\Extension\Core\Type\TextType;
	use Symfony\Component\Form\Extension\Core\Type\PasswordType;
	use Symfony\Component\Form\Extension\Core\Type\SubmitType;
	use Symfony\Component\OptionsResolver\OptionsResolver;

	class SearchAdminFormController extends AbstractType
	{
		public function buildForm(FormBuilderInterface $builder, array $options) {
				$builder
            ->add('value', TextType::class, array('attr' => array('class' => 'adloginInput'), 'label' => 'Поиск'))
            ->add('submitLogin', SubmitType::class, array('attr' => array('class' => 'adsubmitLogin'), 'label' => 'Поиск'));
		}
		public function configureOptions(OptionsResolver $resolver)
		{
    $resolver->setDefaults(array(
        'data_class' => SearchAdminForm::class
    ));
		}
}
?>