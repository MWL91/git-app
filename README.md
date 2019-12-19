# Git-app

App for get last sha from specific git repository.

## Installation

1. Clone this repository
2. Run docker container using `docker-compose up`
3. Open docker workspace container using `docker exec -it git_app bash`
4. Run command `composer install`
5. Copy env file `cp .env.example .env`
6. Generate key for application `php artisan key:generate`

### Installation commands shorthand

After docker setup:

```
docker-compose up
docker exec -it git_app bash
```

Run following:

```
composer install && \
cp .env.example .env && \
php artisan key:generate
```

## Updating app

1. `pull` this repository
2. `composer update` => in case of issues try `composer dump-autoload`

---

# Running the application

To run this app open container by `docker exec -it git_app bash` and simply type `php artisan gitinfo <OWNER>/<REPO> <BRANCH>`

## Example usage

`php artisan gitinfo MWL91/git-app` - will get last sha information from github (if configuration is default)

## Parameters and available options

--service=[SERVICE] - use if you want to use diffrent service than github. For now only github is available ;)

## Configuration

You can configure your app by given ENV variables:

```
GITINFO_DEFAULT_BRANCH - name of your default branch (default: master)
GITINFO_DEFAULT_SERVICE - default service provider (default: github)
```

Default values are stored as config file in `config/gitinfo.php`

---

# Unit tests / feature tests

Inside container simply run `phpunit` to run unit tests for this app.

## PHPUnit Code Coverage

You can genegate app code coverage by run command `phpunit --coverage-html ./coverage`.
Never put code coverage inside public directory!
