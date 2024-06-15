<?php
/**
 * Copyright (c) 2024. Taurus. All rights reserved
 * @author Alex Tolochko
 */

namespace Taurus\Csp\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

class Data extends AbstractHelper
{
    const XML_PATH_WHITELIST_DOMAINS = 'csp/whitelist/domains';

    /**
     * Get whiltelisted domains from admin config
     *
     * @return array
     */
    public function getTrustedDomains()
    {
        $result = [];
        $domains = explode("\n", $this->scopeConfig->getValue(self::XML_PATH_WHITELIST_DOMAINS, 'store'));
        foreach ($domains as $i => $domain) {
            $domain = trim($domain);
            if (!empty($domain)) {
                $result['custom_config_' . $i] = trim($domain);
            }
        }

        return $result;
    }
}
