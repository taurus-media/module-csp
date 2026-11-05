# Taurus CSP module #

### Main Features: ###

* Adds the domains from the "Whitelisted domains" setting (`csp/whitelist/domains`) to the CSP policies
* Whitelists inline scripts in block HTML and in the page head, instead of the `Yireo_CspWhitelistInlineJs` plugin (disabled in `etc/frontend/di.xml`)
* Uses its own `Taurus\Csp\Util\ScriptFinder`, so it works with `yireo/magento2-csp-whitelist-inline-js` 0.1.x, which removed its `ScriptFinder` class
