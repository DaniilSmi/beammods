<?php
	
	namespace App\Form;

	use Symfony\Component\Form\AbstractType;
	use Symfony\Component\Form\FormBuilderInterface;
	use Symfony\Component\OptionsResolver\OptionsResolver;
	use Symfony\Component\Form\Extension\Core\Type\FileType;


	
	use App\Entity\ProfileImageForm;

	class ProfileImageFormController extends AbstractType
	{
		public function buildForm(FormBuilderInterface $builder, array $options) {
			$builder
            ->add('image', FileType::class, array('label' => false));
		}
		public function configureOptions(OptionsResolver $resolver)
		{
	    $resolver->setDefaults(array(
	        'data_class' => ProfileImageForm::class,
	    ));
		}
	} 

?>