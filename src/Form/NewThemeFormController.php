<?php
	namespace App\Form;

	use Symfony\Component\Form\AbstractType;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\Form\FormBuilderInterface;
	use Symfony\Component\OptionsResolver\OptionsResolver;
	use Symfony\Component\Form\Extension\Core\Type\TextType;
	use Symfony\Component\Form\Extension\Core\Type\SubmitType;
	use App\Entity\NewThemeForm;

	class NewThemeFormController extends AbstractType
	{
		public function buildForm(FormBuilderInterface $builder, array $options) {
			$builder
					->setMethod("POST")
					->add('theme', TextType::class, array('attr' => array('class' => 'loginInput', 'placeholder' => 'Введите тему'), 'label' => false))
					->add('subTheme', TextType::class, array('attr' => array('class' => 'loginInput', 'placeholder' => 'Введите под тему'), 'label' => false))
					->add('submit', SubmitType::class, array('attr' => array('class' => 'submitLogin ds'), 'label' => 'Создать'));
		}

		public function configureOptions(OptionsResolver $resolver) {
			$resolver->setDefaults(array(
				'data_class' => NewThemeForm::class
			));
		}
	}
?>