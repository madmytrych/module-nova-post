# Madmytrych Nova Post
![Madmytrych Nova Post](https://img.shields.io/badge/version-1.0.3-green.svg)
## Description
Nova Post shipping module for Magento 2.4.6

## Installation process(vendor):
```
composer config repositories.madmytrych git https://github.com/madmytrych/module-nova-post.git
composer require madmytrych/module-nova-post:1.*
bin/magento module:enable Madmytrych_NovaPost
bin/magento se:up
```
## Module Setup:
> Stores->Configuration->Sales->Delivery Methods->Nova Post:`Enabled: Yes`

> Stores->Configuration->Sales->Delivery Methods->Nova Post->Account API Credentials:`Api Key: YOUR_API_KEY`
```
bin/magento novapost:tables:fillout
```
## Uninstallation
```
 bin/magento module:uninstall Madmytrych_NovaPost
 bin/magento module:uninstall -r Madmytrych_NovaPost # to remove related tables

```
## License

[MIT](LICENSE.txt) © [EMAIL](mailto:madmytrych@gmail.com)
