# Magento Keen IO
Magento module to send orders data to [keen.io](http://keen.io/). The plugin supports the Magento Community and Enterprise edition.

## Installation ##

Magento Keen IO uses [Composer](http://getcomposer.org) and [Magento Composer Installer](https://github.com/magento-hackathon/magento-composer-installer) to handle installation of the module and its dependencies. To install Magento Keen IO you will need a copy of _composer.phar_ in your path. If you do not have it availble, run the following commands from your terminal.

    $ curl -sS https://getcomposer.org/installer | php
    $ chmod a+x composer.phar

If you are already using Magento Composer Installer and have an existing _composer.json_, add _https://github.com/deved-it/magento-keen-io_ to the repositories list and _deved-it/magento-keen-io_ as a required dependency for your project. That's it!

If you do not have an existing Magento Composer Installer _composer.json_ file defined, you can use the following template.

    {
      "repositories": [
          {
            "type":"composer",
            "url":"http://packages.firegento.com"
          },
          {
            "type": "vcs",
            "url": "https://github.com/deved-it/magento-keen-io"
          }
      ],
      "require": {
          "magento-hackathon/magento-composer-installer": "*",
          "deved/magento-keen-io": "*"
      },
      "extra":{
          "magento-root-dir":"./",
          "magento-force":"true"
      }
    }


To install Magento Keen IO and its dependencies just run composer.phar.

    $ ./composer.phar install

## Configuration ##

Open the Magento Admin interface and go to _configuration->DEVED KEEN IO->Keen IO Configuration_ and fill in the fields with your _Project ID_ and _Write key_. When you will receive a new order, all order data will be sent to your keen.io project.
