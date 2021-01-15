<?php

require_once __DIR__ . '/../repository/PermissionRepository.php';

class AppController
{
    protected $userMenu;
    private $request;
    private $permissionRepository;

    public function  __construct()
    {
        $this->request = $_SERVER['REQUEST_METHOD'];
        $this->permissionRepository = new PermissionRepository();
        $this->getMenu();
    }

    public function getPages(): ?array
    {
        return $this->permissionRepository->getPages();
    }

    protected function isPost(): bool
    {
        return $this->request === 'POST';
    }

    protected function isGet(): bool
    {
        return $this->request === 'GET';
    }

    protected function render(string $template = null, array $variables = [])
    {
        $templatePath = 'public/views/'.$template.'.php';
        $output = 'Site not found!';

        if(file_exists($templatePath)) {
            extract($variables);

            ob_start();
            include $templatePath;
            $output = ob_get_clean();
        } else {
            ob_start();
            include 'public/views/error.php';
            $output = ob_get_clean();
        }

        print $output;
    }

    private function getMenu(): void
    {
        $this->userMenu = $this->permissionRepository->getMenu();
    }
}