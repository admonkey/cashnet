# IN ACTIVE DEVELOPMENT

Commit history may be rewritten, so prepare to `git pull --rebase`

----------

PHP class wrapper for basic Cashnet web API

# Requirements

* PHP >= 5.5.9
* Encrypted (HTTPS) Connection

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

You can use the class with an optional [PDO database connection][1]
to create and save transaction records.
Examples are included for MySQL and Microsoft SQL Server.

### Data Types:

* Required Fields
    - `store` The Cashnet Store Code. This field *is not* returned to the callback signouturl.
    - `itemcode`
    - `amount` Price USD charged to CC for item. This is a [MoneyType Field][8].
    - `signouturl` Callback URL for receipt confirmation.

* TODO: Optional Transaction Fields  
More than one `itemcode` can be included in a transaction. This is identified by appending a
number onto the `itemcode` key, such as `itemcode2=DIFFERENT-CODE`, `itemcode3=ANOTHER-CODE`, etc.
        - `itemcodeX` (string)
        - `amountX` (money)
        - `qtyX` (integer)

* Cashnet Globals  
These fields pre-populate the first page on Cashnet's site,
which are inturn used to pre-populate the credit card form on the following page.
These fields *can be modified* on that first page,
but are returned *unmodified* to the callback page signouturl
regardless of changes on the credit card form page.
(This is a passthru data transfer - no user input from Cashnet's credit card form
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

* Cashnet Transaction Response Fields  
In addition to receiving the Cashnet Globals and Custom Data via POST to the callback signouturl,
there are some additional fields pertaining to information about the transaction
    * Always
        - `result`      (integer) Result of transaction. 0 = Success, non-zero means error.
        - `respmessage` (string)  Detailed status of the transaction.
        - `merchant`    (string)
        - `custcode`    (string)
        - `itemcnt`     (integer)
        - `lname`       (string)
        - `itemcodeX`   (string)  The "X" is the variable ID for multiple items; defaults to 1.
        - `amountX`     (money)
        - `qtyX`        (integer)
        - `BILLING_ADDRESS` Defunct field that's always blank. **Use `ADDR_G` instead.**
    * On Success
        - `operator`    (string)
        - `station`     (string)
        - `pmtcode`     (string)
        - `pmttype`     (string)
        - `lname`       (string)  This is the full Cashnet client name, not the customer last name.
        - `batchno`     (integer) Main client transaction bucket ID.
        - `tx`          (integer) Primary identifying transaction number.
        - `cctype`      (string)
        - `effdate`     (date)
        - `glX`         (string)  "X" is variable for multiple items. Value is usually "000000"
    * On Failure
        - `failedtx`       (integer) Always 0. Seems to be aborted `tx` set to zero.
        - `ccerrorcode`    (integer) Always 902 because Cashnet will only callback on signout.
        - `ccerrormessage` (string) Always "Customer Cancelled before processing payment"

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
