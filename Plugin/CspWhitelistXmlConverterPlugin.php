<?php
/**
 * Copyright (c) 2024. Taurus. All rights reserved
 * @author Alex Tolochko
 */

namespace Taurus\Csp\Plugin;

use Taurus\Csp\Helper\Data;
use Magento\Csp\Model\Collector\CspWhitelistXml\Converter;

class CspWhitelistXmlConverterPlugin
{
    /**
     * @var Data
     */
    private $helper;

    /**
     * @var string[]
     */
    private $allowedPolicies = [
        'script-src',
        'style-src',
        'img-src',
        'connect-src',
        'media-src',
        'font-src',
        'frame-src'
    ];

    /**
     * @param Data $helper
     */
    public function __construct(
        Data $helper
    ) {
        $this->helper = $helper;
    }

    /**
     * Whitelist configured domains for CSP
     *
     * @param Converter $subject
     * @param $config
     * @return array
     */
    public function afterConvert(Converter $subject, $config)
    {
        if ($trustedDomains = $this->helper->getTrustedDomains()) {
            foreach ($config as $policyId => $policy) {
                if (in_array($policyId, $this->allowedPolicies)) {
                    $config[$policyId]['hosts'] = array_merge($policy['hosts'] ?? [], $trustedDomains);
                }
            }
        }

        return $config;
    }
}
