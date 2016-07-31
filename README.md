File Management System - CLI
==================

### Setup

- First lets fire up vagrant in a usual way (`vagrant up` + `vagrant ssh`)
- Start server (once shh-ed to vagrant box)

```
	cd /vagrant/www
	sudo php -S 0.0.0.0:80
```


- Verify all is good in your browser: `http://127.0.0.1:8080/info.php`
- Setup initial db schema `./run db`

Done!


### Tests

- Download behat `composer install`.
- Run tests `vendor/bin/behat`.

### Task

View [PROGRESS](PROGRESS.md) for details.

