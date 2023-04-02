<?php

namespace App\Services\Repository;

use Exception;
use Monolog\Logger;
use App\Services\Git\GitCloneException;
use App\Services\Git\GitPullException;
use App\Services\Git\GitPushException;
use App\Services\GitHub\GitHubCreatePullRequestException;
use App\Services\GitHub\GitHubForkException;
use App\Services\GitHub\GitHubServiceException;
use App\Services\Language\LanguageParseException;
use App\Services\Language\NoDefaultLanguageException;
use App\Services\Language\NoLanguageFolderException;
use App\Services\Mail\MailService;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class RepositoryErrorReporter {

    /**
     * @var MailService
     */
    private $emailService;

    /**
     * @var Logger
     */
    private $logger;

    private $data;

    function __construct(MailService $emailService, Logger $logger) {
        $this->emailService = $emailService;
        $this->logger = $logger;
    }

    /**
     * General error handler function
     *
     * @param Exception $e
     * @param Repository $repo
     * @param bool $update true if repository fork update, false if sending submitted translation
     * @return string
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    private function handleError(Exception $e, Repository $repo, $update) {
        $this->data = array();
        $this->data['repo'] =  $repo->getEntity();
        $this->data['exception'] = $e;
        if ($update) {
            $template = $this->determineEmailTemplateUpdate($e);
        } else {
            $template = $this->determineEmailTemplateTranslation($e);
        }

        $file = '';
        if(isset($this->data['fileName'])) {
            $file = 'in file: ' . $this->data['fileName'] . '(' . $this->data['lineNumber'] . ')';
        }
        $this->logger->error(sprintf(
            'error during repository update (%s: %s) %s',
            get_class($e),
            $e->getMessage(),
            $file
        ));
        $this->logger->debug($e->getTraceAsString());
        if ($template !== '' && $repo->isFunctional()) {
            $repo->getEntity()->setErrorCount($repo->getEntity()->getErrorCount() + 1);

            $this->emailService->sendEmail(
                $repo->getEntity()->getEmail(),
                'Error during import of ' . $repo->getEntity()->getDisplayName(),
                $template,
                $this->data
            );
            return $this->emailService->getLastMessage();
        } else {
            return 'Unknown error:' .get_class($e);
        }
    }

    /**
     * Handle errors during sending of a submitted translation
     *
     * @param Exception $e
     * @param Repository $repo
     * @return string
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function handleTranslationError(Exception $e, Repository $repo) {
        return $this->handleError($e, $repo, false);
    }

    /**
     * Returns an email template for exceptions that needs attention of extension author
     *
     * @param Exception $e
     * @return string template referrer
     */
    private function determineEmailTemplateTranslation(Exception $e) {
        if ($e instanceof GitHubCreatePullRequestException) {
            return 'mail/translationErrorPullRequest.txt.twig';
        }
        return '';
    }

    /**
     * Handle errors during creation/update of local repository fork
     *
     * @param Exception $e
     * @param Repository $repo
     * @return string
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function handleUpdateError(Exception $e, Repository $repo) {
        return $this->handleError($e, $repo, true);
    }

    /**
     * Returns an email template for exceptions that needs attention of extension author
     *
     * @param Exception $e
     * @return string template referrer
     */
    private function determineEmailTemplateUpdate(Exception $e) {
        if ($e instanceof GitPullException) {
            return 'mail/importErrorUpdate.txt.twig';
        }

        if ($e instanceof GitPushException) {
            return 'mail/importErrorUpdate.txt.twig';
        }

        if ($e instanceof GitHubServiceException) {
            return 'mail/importErrorGitHubUrl.txt.twig';
        }

        if ($e instanceof GitCloneException) {
            return 'mail/importErrorClone.txt.twig';
        }

        if ($e instanceof GitHubForkException) {
            return 'mail/importErrorClone.txt.twig';
        }

        if ($e instanceof NoLanguageFolderException) {
            return 'mail/importErrorNoLangFolder.txt.twig';
        }

        if ($e instanceof NoDefaultLanguageException) {
            return 'mail/importErrorNoDefaultTranslation.txt.twig';
        }

        if ($e instanceof LanguageParseException) {
            $this->data['fileName'] = basename(dirname($e->getFileName())) . '/' . basename($e->getFileName());
            $this->data['lineNumber'] = $e->getLineNumber();
            $this->data['message'] = $e->getMessage();

            return 'mail/importErrorLanguageParse.txt.twig';
        }
        return '';
    }
}