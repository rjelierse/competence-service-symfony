<?php

namespace Sparse\CompetenceBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Util\Codes;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sparse\AppBundle\Controller\AbstractController;
use Sparse\AppBundle\Document\User;
use Sparse\CompetenceBundle\Document\Profile;
use Sparse\CompetenceBundle\Document\ProfileTemplate;
use Symfony\Component\HttpFoundation\Response;

/**
 * Controller for the Competence Template API.
 *
 * @author Raymond Jelierse <raymond@shareworks.nl>
 */
class TemplateController extends AbstractController 
{
    /**
     * List the available templates.
     * 
     * @return Response
     * 
     * @Rest\Get("/templates", name="list_competence_templates")
     */
    public function listAction()
    {
        $templates = $this
            ->getRepository(ProfileTemplate::class)
            ->findAll();
        
        return $this->handleView(View::create($templates));
    }

    /**
     * Get a specific template.
     * 
     * @param ProfileTemplate $template
     * 
     * @return Response
     * 
     * @Rest\Get("/templates/{template_id}", name="get_competence_template")
     * @ParamConverter("template", class="Sparse\CompetenceBundle\Document\ProfileTemplate", converter="doctrine.odm.mongodb", options={"id": "template_id"})
     */
    public function getAction(ProfileTemplate $template)
    {
        return $this->handleView(View::create($template));
    }

    /**
     * Create a competence profile for a user from the given template.
     *
     * @param ProfileTemplate $template
     * @param User            $user
     *
     * @return Response
     *
     * @Rest\Post("/templates/{template_id}/profile-for/{user_id}", name="create_competence_profile_from_template")
     * @ParamConverter("template", class="Sparse\CompetenceBundle\Document\ProfileTemplate", converter="doctrine.odm.mongodb", options={"id": "template_id"})
     * @ParamConverter("user", class="Sparse\AppBundle\Document\User", converter="doctrine.odm.mongodb", options={"id": "user_id"})
     */
    public function createProfileForUserAction(ProfileTemplate $template, User $user)
    {
        $profile = Profile::createFromTemplate($user, $template);
        $errors = $this->validate($profile, 'create');
        if (count($errors) > 0) {
            return $this->handleView(View::create(['message' => 'Validation failed', 'errors' => $errors], Codes::HTTP_BAD_REQUEST));
        }

        $manager = $this->getManager(Profile::class);
        $manager->persist($profile);
        $manager->flush();

        $view = View::create($profile, Codes::HTTP_CREATED)
            ->setRoute('get_user_competence_profile')
            ->setRouteParameters(['user_id' => $user->getId(), 'profile_id' => $profile->getId()]);

        return $this->handleView($view);
    }
}
