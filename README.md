# Workplace Futures Group Website Widgets

# System Requirements

- PHP _(see [composer.json](composer.json) for current version & required extensions)_
- MySQL v8
- NGINX
- Redis
- PhpRedis extension
- Supervisor _(remote only, for queue process management)_
- Node.js _(local & CI/CD only, for front-end asset compiling)_
- NPM _(local & CI/CD only, for front-end asset compiling)_

# Local Setup

If you haven't already setup your local environment for development, take a look at the "Local environment" section of the [Yammayap Dev Handbook](https://dev-handbook.yammayap.com) for guidance.

You will also need to ensure you meet the system requirements listed above.

## Installation

- Clone this repository using your GIT GUI, or via the CLI: `git clone git@github.com:Yammayap/widgets.workplacefutures.com.git` _(you will only get the `test` branch by default, you may want to pull others too)_
- If you haven't already, open the project root directory in your local CLI
- Install PHP dependencies: `composer install`
- Install NPM dependencies: `npm install`

## Configuration

- Create a `.env` file by cloning the example: `cp .env.example .env`
- Generate a new application key by running: `php artisan key:generate`
- Ensure `APP_ENV` is set to `local`
- Ensure `APP_DEBUG` is set to `true`
- Ensure `APP_URL` is set to the domain being used to serve the project locally _(probably `https://widgets.workplacefutures.com.test`)_
- Ensure `LOG_CHANNEL` is set to `env-local`
- Set the relevant database and Redis connection details
- If you're not using the `log` mailer, you **must** set a `MAIL_TO_ADDRESS` for working locally
- Configure the remaining options in the `.env` file - all API keys / credentials required can be found in [BitWarden](https://vault.bitwarden.com)

## Building The Front-End Assets

[Vite](https://laravel.com/docs/vite) is used to build the front-end assets. It can be run in two ways:

You can run the development server via the `dev` command, which is useful while developing locally as it will automatically detect changes to your files and instantly reflect them in any open browser windows:

```npm run dev```

Or, you can run the `build` command, which will version and bundle the assets as if they were being used in production:

```npm run build```

## Database setup

To create the database schema and seed it with data, run `php artisan migrate:fresh --seed`.

## Test database setup

Run `touch database/database.sqlite` to create a SQLite database for running test locally.

# Developing

Take a look at the "PHP development" section of the [Yammayap Dev Handbook](https://dev-handbook.yammayap.com) for a refresher on our PHP development standards & tooling.

## GIT Workflow

Take a look at the ["Version control" section of the Yammayap Dev Handbook](https://dev-handbook.yammayap.com/version-control) for a refresher on our GIT workflow.

# CI/CD

_TBC_

# Remote Environments

_TBC_
