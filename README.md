PhpHooks
=========

PhpHooks is a collection of some useful [__customizable__](#customize) checks that you can use 
as [git pre-commit hook](http://git-scm.com/book/en/v2/Customizing-Git-Git-Hooks) before you commit some changes.

## Features

Every change (or changes) that you do was checked at the time through: 

* phplint - PHP syntax check
* forbidden - Check for forbidden methods like "die()", "var_dump()" and "print_r()"
* [phpmd](http://phpmd.org/) - Check for some code violations like codesize or naming
* [phpcs](https://github.com/squizlabs/PHP_CodeSniffer) - Check for coding standard violations
* [phpcpd](https://github.com/sebastianbergmann/phpcpd) - Check for duplicate code

## Install

### Requirements

* PHP installed and globally available
* Git installed

### Introduction

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