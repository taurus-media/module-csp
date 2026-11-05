<?php
/**
 * Copyright (c) 2024. Taurus. All rights reserved
 * @author Alex Tolochko
 */

namespace Taurus\Csp\Plugin;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Helper\SecureHtmlRenderer;
use Magento\Framework\View\Page\Config\Renderer;
use Taurus\Csp\Util\ScriptFinder;

class AddCspInlineScriptsToHead
{
    /**
     * @var ScriptFinder
     */
    private ScriptFinder $scriptFinder;

    /**
     * @var SecureHtmlRenderer
     */
    private SecureHtmlRenderer $secureHtmlRenderer;

    /**
     * @param ScriptFinder $scriptFinder
     * @param SecureHtmlRenderer $secureHtmlRenderer
     */
    public function __construct(
        ScriptFinder $scriptFinder,
        SecureHtmlRenderer $secureHtmlRenderer
    ) {
        $this->scriptFinder = $scriptFinder;
        $this->secureHtmlRenderer = $secureHtmlRenderer;
    }

    /**
     * @param Renderer $subject
     * @param string $html
     * @return string
     */
    public function afterRenderHeadContent(Renderer $subject, string $html)
    {
        $scripts = $this->scriptFinder->find($html);
        foreach ($scripts as $fullScript => $inlineJs) {
            $newScript = $this->secureHtmlRenderer->renderTag('script', [], $inlineJs, false);
            $html = str_replace($fullScript, $newScript, $html);
        }

        return $html;
    }
}
