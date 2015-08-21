<?php

namespace HBDemo\Commenting;

use Honeybee\FrameworkBinding\Agavi\Renderer\ModuleTemplateRenderer;
use Honeybee\Infrastructure\Config\ConfigInterface;
use Honeybee\Infrastructure\Mail\MailServiceInterface;
use Psr\Log\LoggerInterface;

class MailService
{
    protected $config;
    protected $mail_service;
    protected $module_template_renderer;
    protected $logger;

    public function __construct(
        ConfigInterface $config,
        MailServiceInterface $mail_service,
        ModuleTemplateRenderer $module_template_renderer,
        LoggerInterface $logger
    ) {
        $this->config = $config;
        $this->mail_service = $mail_service;
        $this->module_template_renderer = clone($module_template_renderer);
        $this->module_template_renderer->setConfig(['module_name' => 'HBDemo_Commenting']);
        $this->logger = $logger;
    }
}
