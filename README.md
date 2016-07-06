# IN ACTIVE DEVELOPMENT

Commit history may be rewritten, so prepare to `git pull --rebase`

----------

PHP class wrapper for basic Cashnet web API

# Requirements

* PHP >= 5.5.9

The install script uses [wget][3] to download the dependency package manager [Composer v1.1.2][2].
If you do not have [wget][3], then you will need to [manually download Composer][2]
and place `composer.phar` in the project root directory.

# Installation

If you're installing this for production use, then you can get all the dependencies with the script.

    ./install --prod

----------

# Development

You can run the install script with the `--dev` flag to grab the developer tools like [PHPUnit][4].

    ./install --dev

## Testing

To run the test suite, use the `test` script.

    ./test

The verbose flag will show more detailed output.

    ./test -v

## Notes

All data is passed to Cashnet encoded in the query string of the URL as a GET request. This allows for an easily shareable link. **NOTE:** This includes the amount, effectively allowing the client to change and set their own price - you must be proactive about validating transactions.

`getForm()` renders an HTML5 form using [Symfony][6] and [twig][7].

### Data Types:

* Required Fields
    - `store` The Cashnet Store Code.
    - `itemcode`
    - `amount` Price USD charged to CC for item. This is a [MoneyType Field][8].
    - `signouturl` Callback URL for receipt confirmation.

* Cashnet Globals  
These fields pre-populate the credit card form on Cashnet's site,
and are returned *unmodified* to the callback page signouturl.
(This is a passthru data transfer - no user input from Cashnet's pages
are ever transferred back to your server.)
    - `CARDNAME_G`
    - `EMAIL_G`
    - `ADDR_G`
    - `CITY_G`
    - `STATE_G`
    - `ZIP_G`

* Custom Data  
`UID` is included in the global namespace, but is not used by Cashnet.
Other data may be passed unmodified *and unused* thru Cashnet's server
for consumption on the callback server in the form of `refXtypeX` : `refXvalX`.
All other POST data are discarded.

----------
[1]:http://php.net/manual/en/book.pdo.php
[2]:https://getcomposer.org/download/
[3]:https://www.gnu.org/software/wget/
[4]:https://phpunit.de/
[5]:https://github.com/jeff-puckett/mysql-dtp
[6]:http://symfony.com/doc/current/book/forms.html
[7]:http://twig.sensiolabs.org/
[8]:http://symfony.com/doc/current/reference/forms/types/money.html
> Written with [StackEdit](https://stackedit.io/).
