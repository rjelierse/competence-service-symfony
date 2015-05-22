<?php

namespace Sparse\CompetenceBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Util\Codes;
use FOS\RestBundle\View\View;
use JMS\SecurityExtraBundle\Annotation\SecureParam;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sparse\AppBundle\Controller\AbstractController;
use Sparse\AppBundle\Document\User;
use Sparse\CompetenceBundle\Document\Profile;
use Sparse\CompetenceBundle\Document\ProfileTemplate;
use Sparse\CompetenceBundle\Event\CompetenceProfileEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Controller for the Competence Profile API.
 *
 * @author Raymond Jelierse <raymond@shareworks.nl>
 */
class ProfileController extends AbstractController 
{
    /**
     * Retrieve the competence profiles for the user.
     *
     * @param User $user
     *
     * @return Response
     *
     * @Rest\Get("/users/{user_id}/profiles", name="list_user_competence_profiles")
     * @ParamConverter("user", class="Sparse\AppBundle\Document\User", converter="doctrine.odm.mongodb", options={"id": "user_id"})
     * @SecureParam(name="user", permissions="VIEW_COMPETENCE_PROFILE")
     */
    public function listAction(User $user)
    {
        $profiles = $this->getRepository(Profile::class)
            ->findForUser($user)
            ->toArray(false);
        
        $view = $this->view($profiles);
            
        return $this->handleView($view);
    }

    /**
     * Store a competence profile for the user.
     *
     * @param User            $user     The user
     * @param Profile         $profile  The competence profile
     * @param ProfileTemplate $template The template to create the profile from
     *
     * @return Response
     *
     * @Rest\Post("/users/{user_id}/profiles", name="create_user_competence_profile")
     * @ParamConverter("user", class="Sparse\AppBundle\Document\User", converter="doctrine.odm.mongodb", options={"id": "user_id"})
     * @ParamConverter("profile", class="Sparse\CompetenceBundle\Document\Profile", converter="fos_rest.request_body")
     * @ParamConverter("template", class="Sparse\CompetenceBundle\Document\ProfileTemplate", converter="doctrine.odm.mongodb", options={"id": "template_id"})
     * @SecureParam(name="user", permissions="CREATE_COMPETENCE_PROFILE")
     */
    public function createAction(User $user, Profile $profile = null, ProfileTemplate $template = null)
    {
        if (null !== $template) {
            $profile = Profile::createFromTemplate($user, $template);
        } else {
            $profile->setStudent($user);
        }
        
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
    
    /**
     * Retrieve a competence profile for the user.
     * 
     * @param Profile $profile
     * 
     * @return Response
     * 
     * @Rest\Get("/users/{user_id}/profiles/{profile_id}", name="get_user_competence_profile")
     * @ParamConverter("profile", class="Sparse\CompetenceBundle\Document\Profile", converter="doctrine.odm.mongodb", options={"id": "profile_id"})
     * @SecureParam(name="profile", permissions="VIEW")
     */
    public function getAction(Profile $profile)
    {
        $this->get('event_dispatcher')->dispatch(CompetenceProfileEvent::READ, CompetenceProfileEvent::create($profile));
        
        $view = View::create($profile);
        
        return $this->handleView($view);
    }
    
    /**
     * Store a competence profile for the user.
     * 
     * @param Profile $profile The competence profile
     *
     * @return Response
     * 
     * @Rest\Put("/users/{user_id}/profiles/{profile_id}", name="update_user_competence_profile")
     * @ParamConverter("profile", class="Sparse\CompetenceBundle\Document\Profile", converter="fos_rest.request_body")
     * @SecureParam(name="profile", permissions="EDIT")
     */
    public function updateAction(Profile $profile)
    {
        $errors = $this->validate($profile, 'update');
        if (count($errors) > 0) {
            return $this->handleView(View::create(['message' => 'Validation failed', 'errors' => $errors], Codes::HTTP_BAD_REQUEST));
        }

        $manager = $this->getManager(Profile::class);
        $manager->persist($profile);
        $manager->flush();
        
        return $this->handleView(View::create());
    }

    /**
     * Delete the competence profile for the user.
     * 
     * @param Profile $profile The competence profile
     *
     * @return Response
     *
     * @Rest\Delete("/users/{user_id}/profiles/{profile_id}", name="delete_user_competence_profile")
     * @ParamConverter("profile", class="Sparse\CompetenceBundle\Document\Profile", converter="doctrine.odm.mongodb", options={"id": "profile_id"})
     * @SecureParam(name="profile", permissions="DELETE")
     */
    public function deleteAction(Profile $profile)
    {
        $manager = $this->getManager(Profile::class);
        $manager->remove($profile);
        $manager->flush();

        return $this->handleView(View::create());
    }

    /**
     * Lock the competence profile.
     *
     * @param Profile $profile The competence profile
     *
     * @return Response
     *
     * @Rest\Patch("/users/{user_id}/profiles/{profile_id}/lock", name="lock_user_competence_profile")
     * @ParamConverter("profile", class="Sparse\CompetenceBundle\Document\Profile", converter="doctrine.odm.mongodb", options={"id": "profile_id"})
     * @SecureParam(name="profile", permissions="LOCK")
     */
    public function lockAction(Profile $profile)
    {
        throw new HttpException(501, 'Action not implemented yet.');
    }

    /**
     * Unlock the competence profile.
     *
     * @param Profile $profile The competence profile
     *
     * @return Response
     *
     * @Rest\Patch("/users/{user_id}/profiles/{profile_id}/unlock", name="unlock_user_competence_profile")
     * @ParamConverter("profile", class="Sparse\CompetenceBundle\Document\Profile", converter="doctrine.odm.mongodb", options={"id": "profile_id"})
     * @SecureParam(name="profile", permissions="UNLOCK")
     */
    public function unlockAction(Profile $profile)
    {
        throw new HttpException(501, 'Action not implemented yet.');
    }
}
