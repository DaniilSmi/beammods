<?php
	namespace App\Form;

	use Symfony\Component\Form\AbstractType;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\Form\FormBuilderInterface;
	use Symfony\Component\OptionsResolver\OptionsResolver;
	use Symfony\Component\Form\Extension\Core\Type\TextareaType;
	use Symfony\Component\Form\Extension\Core\Type\SubmitType;
	use App\Entity\CommentForm;

	class CommentFormController extends AbstractType
	{
		public function buildForm(FormBuilderInterface $builder, array $options) {
			$builder
					->setMethod("POST")
					->add('text', TextareaType::class, array('attr' => array(), 'label' => false))
					->add('submit', SubmitType::class, array('attr' => array('class' => 'submitLogin ds'), 'label' => 'Отправить'));
		}

		public function configureOptions(OptionsResolver $resolver) {
			$resolver->setDefaults(array(
				'data_class' => CommentForm::class
			));
		}
	}
?>