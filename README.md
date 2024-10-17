<div align="center">

<!-- Module Image Here -->

</div>

<h1 align="center">element119 | Admin Indexer Report</h1>

## 📝 Features
✔️ Allow admins to reindex data, logging who did so and when

✔️ Provide advice for recommended indexer configuration and improvements

✔️ Health report for indexer-related cron jobs

✔️ Surface indexer batch configuration information

✔️ Provide educational resources for indexer configuration and performance

✔️ Supports custom indexer implementations

✔️ Theme agnostic

✔️ Built in accordance with Magento best practises

✔️ Dedicated module configuration section secured with custom admin user controls

✔️ Seamless integration with Magento

✔️ Built with developers and extensibility in mind to make customisations as easy as possible

✔️ Installable via Composer

⏳ Data visualisation

⏳ Allow merchants to set indexer batch sizes via the admin

<br/>

## 🔌 Installation
Run the following command to *install* this module:
```bash
composer require element119/module-admin-indexer-report
php bin/magento setup:upgrade
```

<br/>

## ⏫ Updating
Run the following command to *update* this module:
```bash
composer update element119/module-admin-indexer-report
php bin/magento setup:upgrade
```

<br/>

## ❌ Uninstallation
Run the following command to *uninstall* this module:
```bash
composer remove element119/module-admin-indexer-report
php bin/magento setup:upgrade
```

<br/>

## 📚 User Guide
Configuration for this module can be found in the Magento admin under `Stores -> Settings -> Configuration -> Advanced
-> System -> Indexer Report`.

<br>

### Indexer Report
The indexer information can be found below the native indexer grid in the admin under `System -> Tools -> Index
Management`.

<br>

### Enable Indexer History Log Cron
The periodic capture of indexer-related cron information can be disabled by setting this option to `No`. This is set to
`Yes` by default.

<br>

## 📸 Screenshots & GIFs
![admin-indexer-report-all-notices](https://github.com/user-attachments/assets/e3a2eb1a-051b-4c11-844e-f69190d962c2)
