PhpHooks
=========

PhpHooks is a collection of some useful checks that you can use 
as [git hook](http://git-scm.com/book/en/v2/Customizing-Git-Git-Hooks) before you commit some changes.

## Features

At the time:

* phplint
* check for forbidden methods (die(), var_dump() and print_r())
* phpmd (check for codesize violations)

## Install

In the repository where you want to use the hooks just do the following:

    # Remove default hook directory (do this not if you use other hooks)
    rm -rf .git/hooks
    ln -s path/to/php-hooks/hooks .git/hooks
    
## Sample

[Screenshot](https://drive.google.com/file/d/0Bz-gdAnNazgHRjk0ZmFPQlJXQUk/view?usp=sharing)