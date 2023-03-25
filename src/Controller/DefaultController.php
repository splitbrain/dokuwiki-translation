<?php

namespace App\Controller;

use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use App\Controller\InitializableController;
use org\dokuwiki\translatorBundle\EntityRepository\LanguageNameEntityRepository;
use org\dokuwiki\translatorBundle\EntityRepository\RepositoryEntityRepository;
use org\dokuwiki\translatorBundle\Services\Language\LanguageManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller implements InitializableController {

    /**
     * @var RepositoryEntityRepository
     */
    private $repositoryRepository;

    /**
     * @var LanguageNameEntityRepository
     */
    private $languageNameRepository;

    public function initialize(Request $request) {
        $entityManager = $this->getDoctrine()->getManager();
        $this->repositoryRepository = $entityManager->getRepository('dokuwikiTranslatorBundle:RepositoryEntity');
        $this->languageNameRepository = $entityManager->getRepository('dokuwikiTranslatorBundle:LanguageNameEntity');
    }

    /**
     * Show front page
     * Language determined from url parameter, session or client info
     *
     * @param Request $request
     * @param LanguageManager $languageManager
     * @return Response
     *
     * @throws NonUniqueResultException
     */
    public function indexAction(Request $request, LanguageManager $languageManager) {
        $lang = $request->query->get('lang', null);

        if (!empty($lang)) {
            try {
                $this->languageNameRepository->getLanguageByCode($lang);
            } catch (NoResultException $e) {
                // just ignore unknown language codes because of spam.
                return $this->redirect($this->generateUrl('dokuwiki_translator_homepage'));
            }
        }

        $data['currentLanguage'] = $languageManager->getLanguage($request);
        $data['coreRepository'] = $this->repositoryRepository->getCoreRepositoryInformation($data['currentLanguage']);
        $data['repositories'] = $this->repositoryRepository->getExtensionRepositoryInformation($data['currentLanguage']);
        $data['languages'] = $this->languageNameRepository->getAvailableLanguages();
        $data['activated'] = $request->query->has('activated');
        $data['notActive'] = $request->query->has('notActive');

        return $this->render('dokuwikiTranslatorBundle:Default:index.html.twig', $data);
    }

    /**
     * Show translation progress of DokuWiki
     *
     * @param Request $request
     * @param LanguageManager $languageManager
     * @return Response
     *
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function showAction(Request $request, LanguageManager $languageManager) {
        $data = array();
        $data['repository'] = $this->repositoryRepository->getCoreTranslation();
        $data['currentLanguage'] = $languageManager->getLanguage($request);
        $data['languages'] = $this->languageNameRepository->getAvailableLanguages();
        $data['featureImport'] = $this->container->getParameter('featureImport');
        $data['featureAddTranslationFromDetail'] = $this->container->getParameter('featureAddTranslationFromDetail');
        $data['englishReadonly'] = $request->query->has('englishReadonly');

        return $this->render('dokuwikiTranslatorBundle:Default:show.html.twig', $data);
    }
}