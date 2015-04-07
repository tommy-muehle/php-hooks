PhpHooks
=========

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://travis-ci.org/tommy-muehle/php-hooks.svg?branch=master)](https://travis-ci.org/tommy-muehle/php-hooks)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/tommy-muehle/php-hooks/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/tommy-muehle/php-hooks/?branch=master)
[![Code Climate](https://codeclimate.com/github/tommy-muehle/php-hooks/badges/gpa.svg)](https://codeclimate.com/github/tommy-muehle/php-hooks)
[![Test Coverage](https://codeclimate.com/github/tommy-muehle/php-hooks/badges/coverage.svg)](https://codeclimate.com/github/tommy-muehle/php-hooks)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/af85b325-519d-4d75-a3ff-b5ba9d62677c/small.png)](https://insight.sensiolabs.com/projects/af85b325-519d-4d75-a3ff-b5ba9d62677c)

PhpHooks is a collection of some useful [__customizable__](#customize) checks that you can use 
as [git pre-commit hook](http://git-scm.com/book/en/v2/Customizing-Git-Git-Hooks) before you commit some changes.

## Features

Every change (or changes) that you do was checked at the time through: 

* phplint - PHP syntax check
* forbidden - Check for forbidden methods like "die()", "var_dump()" and "print_r()"
* [phpmd](http://phpmd.org/) - Check for some code violations like codesize or naming
* [phpcs](https://github.com/squizlabs/PHP_CodeSniffer) - Check for coding standard violations
* [phpcpd](https://github.com/sebastianbergmann/phpcpd) - Check for duplicate code
* [phpunit](https://phpunit.de/) - Check tests (only if configuration file is set!)
* [security-checker](https://github.com/sensiolabs/security-checker) - Check a given composer.lock file for known security vulnerabilities

## Install

### Requirements

* Git installed
* PHP installed and globally available
* Composer is available

### Introduction

Check out the PhpHooks repository to a save place:

    git clone https://github.com/tommy-muehle/php-hooks.git
    
Get in the cloned directory and do a composer update:
 
    # in /path/to/php-hooks
    composer update
    
Make the hook executable:
    
    # in /path/to/php-hooks
    chmod +x ./hooks/pre-commit
    
Test if everything works fine:

    # in /path/to/php-hooks
    ./hooks/pre-commit
    
    # shows
      ____  _           _   _             _
     |  _ \| |__  _ __ | | | | ___   ___ | | _____
     | |_) | |_ \| |_ \| |_| |/ _ \ / _ \| |/ / __|
     |  __/| | | | |_) |  _  | (_) | (_) |   <\__ \
     |_|   |_| |_| .__/|_| |_|\___/ \___/|_|\_\___/
                 |_|
    No files given to check.

In the repository where you want to use the hook just do the following:

    # Remove default hook directory (do this not if you use other hooks)
    rm -rf .git/hooks
    
    # Set a symlink to the hooks directory
    ln -s path/to/php-hooks/hooks .git/hooks
    
    # Alternative set one symlink for the pre-commit hook
    ln -s path/to/php-hooks/hooks/pre-commit .git/hooks/pre-commit
    
## <a id="customize"></a>Customize

Every project has own requirements, standards, styles and so long.
So you can customize the checks with using a ".pre-commit.yml" file in your project.

    phpmd:
      # Add here other or more rulesets (comma separated)
      ruleset: codesize
    phpcs:
      # Add here your own standard (path) or set a default like PSR1
      standard: /path/to/my/standard
    forbidden:
      # Add here methods that not allowed to commit like var_dump
      methods: ["evalMethod", "printEvalResults"]
    phpunit:
      configuration: /path/to/phpunit.xml
