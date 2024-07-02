<?php
/**
 * Copyright (c) 2024. Taurus. All rights reserved
 * @author Alex Tolochko
 */

namespace Taurus\Csp\Plugin;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Helper\SecureHtmlRenderer;
use Yireo\CspWhitelistInlineJs\Util\ScriptFinder;

class AddCspInlineScripts
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
     * @param Template $block
     * @param string $html
     * @return string
     */
    public function afterFetchView(Template $block, string $html): string
    {
        $scripts = $this->scriptFinder->find($html);
        foreach ($scripts as $fullScript => $inlineJs) {
            $newScript = $this->secureHtmlRenderer->renderTag('script', [], $inlineJs, false);
            $html = str_replace($fullScript, $newScript, $html);
        }

        return $html;
    }
}
