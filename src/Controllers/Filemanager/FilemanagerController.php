<?php

namespace FTPApp\Controllers\Filemanager;

use FTPApp\Controllers\Controller;
use FTPApp\Http\HttpResponse;
use FTPApp\Http\JsonResponse;
use FTPApp\Modules\FtpAdapter\FtpAdapterException;

class FilemanagerController extends Controller
{
    /**
     * {@inheritDoc}
     *
     * Retrieves the connection configuration from the session and initialize
     * the ftp adapter connection for every request.
     *
     * @return HttpResponse|void
     */
    public function before()
    {
        try {
            $this->session()->start();

            $loggedIn = $this->sessionStorage()->getVariable('loggedIn');
            $lastLoginTime = $this->sessionStorage()->getVariable('lastLoginTime');

            if (is_bool($loggedIn) && $loggedIn) {
                // Check inactivity timeout
                if (time() - $lastLoginTime > self::getConfig()['inactivityTimeout'] * 60) {
                    if ($this->request->isAjaxRequest()) {
                        return new JsonResponse(['location' => $this->generateUrl('login')], 401);
                    } else {
                        return $this->redirectToRoute('login');
                    }
                }

                // Restart inactivity timeout
                $this->sessionStorage()->setVariable('lastLoginTime', time());

                $config = array_merge($this->sessionStorage()->getVariable('config'), self::getConfig()['ftp']);

                if (is_array($config) && is_bool($loggedIn) && $loggedIn) {
                    $this->ftpAdapter()->openConnection($config);
                }
            } else {
                if ($this->request->isAjaxRequest()) {
                    return new JsonResponse(['location' => $this->generateUrl('login')], 401);
                }
            }
        } catch (FtpAdapterException $ex) {
            return new JsonResponse(['error' => $ex->getMessage()], 500);
        }
    }

    public function index()
    {
        // If is not logged in make a redirection to login page.
        $loggedIn = $this->sessionStorage()->getVariable('loggedIn');
        if (is_bool($loggedIn) && !$loggedIn) {
            return $this->redirectToRoute('login');
        }

        // Regenerate the session ID.
        $this->session()->regenerateID(true);

        return $this->renderWithResponse('filemanager', [
            'homeUrl'   => $this->generateUrl('home'),
            'loginUrl' => $this->generateUrl('login'),
        ]);
    }

    public function browse()
    {
        try {
            return new JsonResponse([
                'result' => $this->ftpAdapter()->browse($this->getParameters()['path']),
            ]);
        } catch (FtpAdapterException $ex) {
            return new JsonResponse(['error' => $ex->getMessage()], 500);
        }
    }

    public function addFile()
    {
        try {
            $params = $this->request->getJSONBodyParameters();
            return new JsonResponse([
                'result' => $this->ftpAdapter()->addFile($params['path'] . $params['name']),
            ], 201);
        } catch (FtpAdapterException $ex) {
            return new JsonResponse(['error' => $ex->getMessage()], 500);
        }
    }

    public function addFolder()
    {
        try {
            $params = $this->request->getJSONBodyParameters();
            return new JsonResponse([
                'result' => $this->ftpAdapter()->addFolder($params['path'] . $params['name']),
            ], 201);
        } catch (FtpAdapterException $ex) {
            return new JsonResponse(['error' => $ex->getMessage()], 500);
        }
    }

    public function getFileContent()
    {
        try {
            return new JsonResponse([
                'result' => utf8_encode($this->ftpAdapter()->getFileContent($this->request->getParameters()['file'])),
            ]);
        } catch (FtpAdapterException $ex) {
            return new JsonResponse(['error' => $ex->getMessage()], 500);
        }
    }

    public function updateFileContent()
    {
        try {
            return new JsonResponse([
                'result' => $this->ftpAdapter()->updateFileContent(
                    $this->request->getJSONBodyParameters()['file'],
                    $this->request->getJSONBodyParameters()['content']
                ),
            ]);
        } catch (FtpAdapterException $ex) {
            return new JsonResponse(['error' => $ex->getMessage()], 500);
        }
    }

    public function remove()
    {
        try {
            return new JsonResponse([
                'result' => $this->ftpAdapter()->remove($this->request->getJSONBodyParameters()['files']),
            ]);
        } catch (FtpAdapterException $ex) {
            return new JsonResponse(['error' => $ex->getMessage()], 500);
        }
    }

    public function rename()
    {
        try {
            $params = $this->request->getJSONBodyParameters();
            $path   = $params['path'];
            return new JsonResponse([
                'result' => $this->ftpAdapter()->rename($path . $params['file'], $path . $params['newName']),
            ]);
        } catch (FtpAdapterException $ex) {
            return new JsonResponse(['error' => $ex->getMessage()], 500);
        }
    }

    public function getDirectoryTree()
    {
        try {
            return new JsonResponse([
                'result' => $this->ftpAdapter()->getDirectoryTree(),
            ]);
        } catch (FtpAdapterException $ex) {
            return new JsonResponse(['error' => $ex->getMessage()], 500);
        }
    }

    public function move()
    {
        try {
            $params = $this->request->getJSONBodyParameters();
            return new JsonResponse([
                'result' => $this->ftpAdapter()->move($params['path'] . $params['file'], $params['newPath']),
            ]);
        } catch (FtpAdapterException $ex) {
            return new JsonResponse(['error' => $ex->getMessage()], 500);
        }
    }

    public function permissions()
    {
        try {
            $params = $this->request->getJSONBodyParameters();
            return new JsonResponse([
                'result' => $this->ftpAdapter()->permissions($params['path'] . $params['file'], $params['permissions']),
            ]);
        } catch (FtpAdapterException $ex) {
            return new JsonResponse(['error' => $ex->getMessage()], 500);
        }
    }

    public function download()
    {
        try {
            return $this->ftpAdapter()->download($this->getParameters()['file']);
        } catch (FtpAdapterException $ex) {
            return new JsonResponse(['error' => $ex->getMessage()], 500);
        }
    }

    public function upload()
    {
        try {
            $file = $this->request->getFiles()['file'];
            return new JsonResponse([
                'result' => $this->ftpAdapter()->upload(
                    $file['tmp_name'],
                    $this->getParameters()['path'] . $file['name'],
                    self::getConfig()['ftp']['resumeUpload']
                ),
            ]);
        } catch (FtpAdapterException $ex) {
            return new JsonResponse(['error' => $ex->getMessage()], 500);
        }
    }
}
