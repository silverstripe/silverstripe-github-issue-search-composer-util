# Silverstripe Module Issue Browser Util

This utility reads a `composer.lock` file,
discovers any Silverstripe modules contained there,
and opens the [Silverstripe Issue Browser](http://silverstripe-issue-tracker.silverstripe.org) app.
It shows only issues related to those Silverstripe modules.

## Installation

Install within a project (auto-discovers lock file)

```
composer require --dev silverstripe/github-issue-search-composer-util:^0.1
``` 

Install globally (and pass through a lock file)

```
composer global require silverstripe/github-issue-search-composer-util:^0.1
``` 

## Usage

In a Silverstripe project:

```
vendor/bin/github-issue-search
```

Globally with a custom lock file:

```
cat /my/project/composer.lock | github-issue-search
```

The command will output a URL that you can open in your favourite browser.

On MacOSX, you can do this automatically with the `open` command,
on Windows with the `start` command.

```
vendor/bin/github-issue-search | xargs open
``` 